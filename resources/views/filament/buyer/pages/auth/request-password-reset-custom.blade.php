<x-filament-panels::page.simple>
    @if (filament()->hasLogin())
        <x-slot name="subheading">
            {{ $this->loginAction }}
        </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_PASSWORD_RESET_REQUEST_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

    <form method="POST" action="{{ route('password.sendResetLink') }}">
    @csrf
    <div class="flex flex-col space-y-3">
        <label for="email" class="text-sm text-gray-800">Email address*</label>
        <input type="email" name="email" id="email" class="px-4 py-1.5 border rounded-lg" required autofocus>
    </div>
    
    <button type="submit" class="mt-4 px-4 py-2 bg-primaryx text-sm w-full font-bold text-white rounded-lg hover:bg-blue-700">
        {{ __('Send reset link') }}
    </button>
</form>


    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_PASSWORD_RESET_REQUEST_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page.simple>
