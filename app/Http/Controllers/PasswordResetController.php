<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Pages\SimplePage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Htmlable;


class PasswordResetController extends Controller
{
    use WithRateLimiting;

    protected function getRateLimitedNotification(TooManyRequestsException $exception): ?Notification
    {
        return Notification::make()
            ->title(__('filament-panels::pages/auth/password-reset/reset-password.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]))
            ->body(array_key_exists('body', __('filament-panels::pages/auth/password-reset/reset-password.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/password-reset/reset-password.notifications.throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]) : null)
            ->danger();
    }

    // Send the password reset link
    public function sendResetLinkEmail(Request $request)
    {
        try {
            // Rate limit: max 2 requests per minute (or whatever config is set)
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();
            return redirect()->back(); // Or just `return;` if using Livewire
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        $token = Password::createToken($user);
        $resetUrl = URL::temporarySignedRoute(
            'filament.buyer.auth.password-reset.reset', // Your password reset route name
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)), // Expiration time
            [
                'token' => $token,
                'email' => $user->email,
            ]
        );
        

        // Use Brevo (Sendinblue) API to send the email
        $apiKey = env('BREVO_API_KEY');

        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Supplaio',
                'email' => 'no-reply@supplaio.com'
            ],
            'to' => [
                ['email' => $user->email]
            ],
            'subject' => 'Reset Your Password',
            'htmlContent' => "
                <html>
                    <body>
                        <h2 style=\"color: #2c3e50;\">Hello {$user->name},</h2>
                        <p style=\"font-size: 16px;\">You requested a password reset. Please click the link below to reset your password:</p>
                        
                        <p style=\"text-align: center; margin: 30px 0;\">
                            <a href=\"{$resetUrl}\" style=\"display: inline-block; background-color: #1a73e8; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-size: 16px;\">
                                Reset Password
                            </a>
                        </p>
                    </body>
                </html>
            ",
        ]);

        // Check if the email was sent successfully
        if ($response->successful()) {
            Notification::make()
            ->title('We have emailed your password reset link!')
            ->success()
            ->send();

            return redirect()->back(); // redirects to the same page
        }else{
            Notification::make()
            ->title('Failed to send password reset email.')
            ->success()
            ->send();
            return redirect()->back(); // redirects to the same page
        }
    }
}
