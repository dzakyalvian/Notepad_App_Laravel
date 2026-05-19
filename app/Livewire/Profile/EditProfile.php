<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public $avatar;

    public function mount(): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $this->name = $user->name;
    }

    public function save(): void
    {
        $this->validate([
            'name'   => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $user->name = $this->name;

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        Session::flash('success', 'Profile updated!');
    }

    public function deleteAvatar(): void
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);

            $user->avatar = null;
            $user->save();
        }
    }

    public function render()
    {
        return view('livewire.profile.edit-profile');
    }
}
