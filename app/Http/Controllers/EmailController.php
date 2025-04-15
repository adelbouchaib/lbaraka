<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Filament\Facades\Filament;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

use Filament\Notifications\Notification;
use App\Models\User;


use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Pages\SimplePage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Htmlable;

 
class EmailController extends Controller
{
    use WithRateLimiting;

    
    protected function getRateLimitedNotification(TooManyRequestsException $exception): ?Notification
    {
        return Notification::make()
            ->title(__('filament-panels::pages/auth/email-verification/email-verification-prompt.notifications.notification_resend_throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]))
            ->body(array_key_exists('body', __('filament-panels::pages/auth/email-verification/email-verification-prompt.notifications.notification_resend_throttled') ?: []) ? __('filament-panels::pages/auth/email-verification/email-verification-prompt.notifications.notification_resend_throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable,
            ]) : null)
            ->danger();
    }

    public function sendMail(Request $request){

        try {
            // Rate limit: max 2 requests per minute (or whatever config is set)
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();
            return redirect()->back(); // Or just `return;` if using Livewire
        }

        $apiKey = env('BREVO_API_KEY');

        $user = auth()->user();

        $verificationUrl = URL::temporarySignedRoute(
            'filament.buyer.auth.email-verification.verify', // your route name
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)), // expiration
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email',[
        'sender' =>    
        [
            'name' => 'Supplaio',
            'email' => 'no-reply@supplaio.com'
        ],
        'to' => [
        [ 'email' => $user->email ]
        ],
        'subject' => 'Verify your email address',
        'htmlContent' => "
            <html>
                <body>
                        <h2 style=\"color: #2c3e50;\">Hello {$user->name},</h2>
                        <p style=\"font-size: 16px;\">Thank you for registering with us!</p>
                        <p style=\"font-size: 16px;\">To complete your registration, please verify your email by clicking the button below:</p>
                        
                        <p style=\"text-align: center; margin: 30px 0;\">
                            <a href=\"{$verificationUrl}\" style=\"display: inline-block; background-color: #1a73e8; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 5px; font-size: 16px;\">
                                Verify Email
                            </a>
                        </p>
                </body>
            </html>            
        ",
        'trackLinks' => 'none',


    ]);

        if ($response->successful()) {
           Notification::make()
                ->title('Verification email sent!')
                ->success()
                ->send();

                return redirect()->back(); // redirects to the same page


        } else {
            Notification::make()
            ->title('Failed to send verification email.')
            ->success()
            ->send();
            return redirect()->back(); // redirects to the same page


        }
    
}
   
}