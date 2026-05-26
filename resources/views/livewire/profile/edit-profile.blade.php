<div class="max-w-[480px] mx-auto py-10 px-6 font-sans">

    @if (session('success'))
        <div class="bg-[#e6f4ea] text-[#137333] border border-[#c3e6cb] p-2.5 rounded-lg text-xs mb-6 font-medium flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-keep-navbar border border-keep-border rounded-lg p-8 shadow-sm">
        {{-- AVATAR --}}
        <div class="flex flex-col items-center mb-8">
            @if (auth()->user()->avatar)
                <img src="{{ Storage::url(auth()->user()->avatar) }}"
                    class="w-20 h-20 rounded-full object-cover border-2 border-brand-primary">
            @else
                <div class="w-20 h-20 rounded-full bg-brand-primary flex items-center justify-center text-3xl font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif

            <label class="inline-block mt-3 text-xs text-brand-primary font-medium cursor-pointer">
                Change photo
                <input wire:model="avatar" type="file" accept="image/*" class="hidden">
            </label>

            @if (auth()->user()->avatar)
                <button wire:click="deleteAvatar" wire:confirm="Remove profile photo?"
                    class="bg-transparent border-none text-[#d93025] text-xs cursor-pointer mt-1.5 font-medium flex items-center gap-1">
                    <i class="fa-regular fa-trash-can"></i> Remove photo
                </button>
            @endif

            @if ($avatar)
                <p class="text-xs text-keep-textSecondary mt-1.5 font-medium">New photo selected ✓</p>
            @endif
        </div>

        {{-- FORM --}}
        <div class="flex flex-col gap-4">
            <div>
                <label class="text-xs text-keep-textSecondary font-semibold block mb-1.5 uppercase tracking-wider">Display name</label>
                <input wire:model="name" type="text"
                    class="w-full bg-keep-navbar border border-keep-border rounded-lg py-2.5 px-3.5 text-keep-textPrimary text-sm outline-none transition-colors focus:border-keep-borderHover">
                @error('name')
                    <span class="text-[#d93025] text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="text-xs text-keep-textSecondary font-semibold block mb-1.5 uppercase tracking-wider">Email address</label>
                <input type="text" value="{{ auth()->user()->email }}" disabled
                    class="w-full bg-keep-bg border border-keep-border/60 rounded-lg py-2.5 px-3.5 text-keep-textSecondary/80 text-sm outline-none cursor-not-allowed">
            </div>

            <button wire:click="save"
                class="bg-brand-primary hover:bg-brand-dark text-white border-none rounded-lg p-3 text-sm font-medium cursor-pointer mt-2 transition-colors flex items-center justify-center gap-2">
                Save changes
            </button>

            <a href="/dashboard"
                class="text-center text-xs text-keep-textSecondary font-medium no-underline block transition-colors hover:text-keep-textPrimary mt-2">
                ← Back to notes
            </a>
        </div>
    </div>
</div>
