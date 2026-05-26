<div class="bg-keep-card border border-keep-border rounded-lg p-4 flex flex-col gap-3 min-h-[160px] transition-all hover:shadow-[0_1px_3px_rgba(60,64,67,0.15),0_1px_2px_rgba(60,64,67,0.3)] hover:border-keep-borderHover group">
    <div class="flex justify-between items-start gap-2">
        <p class="text-sm font-semibold text-keep-textPrimary m-0 leading-snug">{{ $note->title }}</p>
        @if ($activeTab !== 'trash')
            <button wire:click="toggleFavorite({{ $note->id }})"
                wire:key="star-{{ $viewContext }}-{{ $note->id }}" 
                class="bg-transparent border-none cursor-pointer text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors hover:bg-brand-light/50
                {{ $note->is_favorite ? 'text-brand-dark' : 'text-keep-textSecondary' }}"
                data-tooltip="{{ $note->is_favorite ? 'Remove from favorites' : 'Favorite' }}">
                @if ($note->is_favorite)
                    <i class="fa-solid fa-star text-[#e37400]"></i>
                @else
                    <i class="fa-regular fa-star"></i>
                @endif
            </button>
        @endif
    </div>

    <p class="text-xs text-keep-textBody leading-relaxed m-0 overflow-hidden flex-1">
        {{ Str::limit($note->body, 120) }}
    </p>

    <div class="flex justify-between items-center mt-auto pt-2">
        @if ($note->tag)
            <span class="text-[10px] px-2.5 py-0.5 rounded-full font-medium
                {{ $note->tag === 'Personal' ? 'bg-tag-personalBg text-tag-personalText' : 
                   ($note->tag === 'Work' ? 'bg-tag-workBg text-tag-workText' : 
                   ($note->tag === 'Idea' ? 'bg-tag-ideaBg text-tag-ideaText' : 
                   ($note->tag === 'Important' ? 'bg-tag-importantBg text-tag-importantText' : 
                   ($note->tag === 'Study' ? 'bg-tag-studyBg text-tag-studyText' : 'bg-tag-defaultBg text-tag-defaultText')))) }}">
                {{ $note->tag }}
            </span>
        @else
            <span></span>
        @endif

        @if ($activeTab === 'trash')
            <div class="flex gap-1.5">
                <button wire:click="restore({{ $note->id }})"
                    class="text-[10px] py-1 px-2.5 rounded bg-green-50 text-green-700 border border-green-200 cursor-pointer font-medium transition-colors hover:bg-green-100">Restore</button>
                <button wire:click="forceDelete({{ $note->id }})"
                    wire:confirm="Delete permanently?"
                    class="text-[10px] py-1 px-2.5 rounded bg-red-50 text-red-700 border border-red-200 cursor-pointer font-medium transition-colors hover:bg-red-100">Delete</button>
            </div>
        @else
            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                {{-- PIN --}}
                <button wire:click="togglePin({{ $note->id }})"
                    class="bg-transparent border-none cursor-pointer text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors
                    hover:bg-brand-light/50
                    {{ $note->is_pinned ? 'text-brand-dark' : 'text-keep-textSecondary hover:text-keep-textPrimary' }}"
                    data-tooltip="{{ $note->is_pinned ? 'Unpin' : 'Pin note' }}">
                    @if ($note->is_pinned)
                        <i class="fa-solid fa-thumbtack"></i>
                    @else
                        <i class="fa-solid fa-thumbtack opacity-60"></i>
                    @endif
                </button>

                {{-- EDIT --}}
                <button wire:click="openEdit({{ $note->id }})" 
                    class="bg-transparent border-none cursor-pointer text-keep-textSecondary text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors hover:bg-keep-bg hover:text-keep-textPrimary"
                    data-tooltip="Edit">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>

                {{-- DELETE --}}
                <button wire:click="delete({{ $note->id }})" 
                    class="bg-transparent border-none cursor-pointer text-keep-textSecondary text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors hover:bg-red-50 hover:text-red-600"
                    data-tooltip="Remove">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </div>
        @endif
    </div>

    <p class="text-[9px] text-keep-textSecondary/80 m-0 text-right">{{ $note->created_at->format('d M Y') }}</p>
</div>
