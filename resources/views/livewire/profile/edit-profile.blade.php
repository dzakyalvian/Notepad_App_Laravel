<div style="max-width:480px; margin:0 auto; padding:2rem;">

    @if (session('success'))
        <div style="background:#1a2e1a; color:#4ade80; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:1rem;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- AVATAR --}}
    <div style="display:flex; flex-direction:column; align-items:center; margin-bottom:2rem;">
        @if (auth()->user()->avatar)
            <img src="{{ Storage::url(auth()->user()->avatar) }}"
                style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid #ea580c;">
        @else
            <div style="width:80px; height:80px; border-radius:50%; background:#ea580c; display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:600; color:white;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif

        <label style="display:inline-block; margin-top:10px; font-size:13px; color:#ea580c; cursor:pointer;">
            Change photo
            <input wire:model="avatar" type="file" accept="image/*" style="display:none;">
        </label>

        @if (auth()->user()->avatar)
            <button wire:click="deleteAvatar" wire:confirm="Remove profile photo?"
                style="background:none; border:none; color:#f87171; font-size:12px; cursor:pointer; margin-top:4px;">
                🗑 Remove photo
            </button>
        @endif

        @if ($avatar)
            <p style="font-size:12px; color:#525252; margin-top:4px;">New photo selected ✓</p>
        @endif
    </div>

    {{-- FORM --}}
    <div style="display:flex; flex-direction:column; gap:12px;">
        <div>
            <label style="font-size:12px; color:#737373; display:block; margin-bottom:4px;">Display name</label>
            <input wire:model="name" type="text"
                style="width:100%; background:#2a2a2a; border:1px solid #3a3a3a; border-radius:8px; padding:10px 14px; color:#f5f5f5; font-size:14px; outline:none; box-sizing:border-box;">
            @error('name')
                <span style="color:#f87171; font-size:12px;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label style="font-size:12px; color:#737373; display:block; margin-bottom:4px;">Email</label>
            <input type="text" value="{{ auth()->user()->email }}" disabled
                style="width:100%; background:#1f1f1f; border:1px solid #2e2e2e; border-radius:8px; padding:10px 14px; color:#525252; font-size:14px; outline:none; box-sizing:border-box;">
        </div>

        <button wire:click="save"
            style="background:#ea580c; color:white; border:none; border-radius:8px; padding:10px; font-size:14px; font-weight:500; cursor:pointer; margin-top:4px;">
            Save changes
        </button>

        <a href="/dashboard"
            style="text-align:center; font-size:13px; color:#525252; text-decoration:none; display:block;">
            ← Back to notes
        </a>
    </div>
</div>
