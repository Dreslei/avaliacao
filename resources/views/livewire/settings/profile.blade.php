<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">

        <form wire:submit.prevent="updatefoto" class="my-6 w-full space-y-6" enctype="multipart/form-data">
            <h2 class="text-base font-semibold">{{ __('Profile photo') }}</h2>

            <div class="flex items-center gap-4">
                <img
                    src="{{ $foto_atual ? \Storage::disk('public')->url($foto_atual) : asset('images/foto-default.png') }}"
                    class="w-24 h-24 rounded-full object-cover border"
                    alt="foto"
                />

                @if ($foto_atual)
                    <flux:button type="button" wire:click="removefoto" variant="subtle">
                        {{ __('Remover Foto') }}
                    </flux:button>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium">{{ __('Nova foto') }}</label>
                <input type="file" wire:model="foto" accept="image/*" class="mt-1">
                @error('foto') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            @if ($foto)
                <div>
                    <p class="text-sm text-gray-600">{{ __('Preview') }}:</p>
                    <img src="{{ $foto->temporaryUrl() }}" class="w-24 h-24 rounded-full object-cover border">
                </div>
            @endif

            <div class="flex items-center justify-start">
                <flux:button variant="primary" type="submit">{{ __('Atualizar Foto') }}</flux:button>
            </div>
        </form>

        <hr class="my-6">

        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}
                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
