<x-filament-panels::page.simple>
    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
        {{
            __('filament-panels::pages/auth/email-verification/email-verification-prompt.messages.notification_sent', [
                'email' => filament()->auth()->user()->getEmailForVerification(),
            ])
        }}
    Please check your spam folder.

    </p>

   

    <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
    <span>
        {{ __('filament-panels::pages/auth/email-verification/email-verification-prompt.messages.notification_not_received') }}
    </span>

    <form method="POST" action="{{ route('sendMail') }}">
        @csrf
        <button type="submit" class="text-gray-800 hover:underline font-medium">
            {{ __('Resend') }}
        </button>
    </form>
</div>

</x-filament-panels::page.simple>
