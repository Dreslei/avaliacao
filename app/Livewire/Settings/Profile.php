<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';

    public $foto;
    public ?string $foto_atual = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->foto_atual = Auth::user()->foto;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function updatefoto(): void
    {
        $this->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:min_width=96,min_height=96'],
        ], [
            'foto.required'   => 'Envie uma imagem.',
            'foto.image'      => 'O arquivo precisa ser uma imagem válida.',
            'foto.mimes'      => 'Formatos permitidos: JPG, JPEG, PNG, WEBP.',
            'foto.max'        => 'Tamanho máximo: 2 MB.',
            'foto.dimensions' => 'A imagem deve ter pelo menos 96x96 pixels.',
        ]);

        $user = Auth::user();

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $path = $this->foto->store('fotos/'.$user->id, 'public');

        $user->foto = $path;
        $user->save();

        $this->foto_atual = $path;
        $this->reset('foto');

        $this->dispatch('profile-updated', name: $user->name);
        $this->dispatch('notify', type: 'success', message: 'Foto de perfil atualizada!');
    }

    public function removefoto(): void
    {
        $user = Auth::user();

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->foto = null;
        $user->save();

        $this->foto_atual = null;

        $this->dispatch('notify', type: 'success', message: 'Foto removida.');
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
