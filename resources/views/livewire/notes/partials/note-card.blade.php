<div class="bg-keep-card dark:bg-[#202124] border border-keep-border dark:border-[#5f6368] rounded-lg p-4 flex flex-col gap-3 min-h-[160px] transition-all hover:shadow-[0_1px_3px_rgba(60,64,67,0.15),0_1px_2px_rgba(60,64,67,0.3)] dark:hover:shadow-[0_1px_3px_rgba(0,0,0,0.5),0_1px_2px_rgba(0,0,0,0.3)] hover:border-keep-borderHover dark:hover:border-[#e8eaed] group">
    <div class="flex justify-between items-start gap-2">
        <p class="text-sm font-semibold text-keep-textPrimary dark:text-[#e8eaed] m-0 leading-snug">{{ $note->title }}</p>
        @if ($activeTab !== 'trash')
            <button wire:click="toggleFavorite({{ $note->id }})"
                wire:key="star-{{ $viewContext }}-{{ $note->id }}" 
                class="bg-transparent border-none cursor-pointer text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors hover:bg-brand-light/50 dark:hover:bg-[#413123]/50
                {{ $note->is_favorite ? 'text-brand-dark dark:text-[#fb923c]' : 'text-keep-textSecondary dark:text-[#9aa0a6]' }}"
                data-tooltip="{{ $note->is_favorite ? 'Remove from favorites' : 'Favorite' }}">
                @if ($note->is_favorite)
                    <i class="fa-solid fa-star text-[#e37400]"></i>
                @else
                    <i class="fa-regular fa-star"></i>
                @endif
            </button>
        @endif
    </div>

    <p class="text-xs text-keep-textBody dark:text-[#e8eaed] leading-relaxed m-0 overflow-hidden flex-1">
        {{ Str::limit($note->body, 120) }}
    </p>

    <div class="flex justify-between items-center mt-auto pt-2">
        <div class="flex items-center gap-1">
            @if ($note->tag)
                <span class="text-[10px] px-2.5 py-0.5 rounded-full font-medium
                    {{ $note->tag === 'Personal' ? 'bg-tag-personalBg dark:bg-purple-900/30 text-tag-personalText dark:text-purple-300' : 
                       ($note->tag === 'Work' ? 'bg-tag-workBg dark:bg-emerald-900/30 text-tag-workText dark:text-emerald-300' : 
                       ($note->tag === 'Idea' ? 'bg-tag-ideaBg dark:bg-amber-900/30 text-tag-ideaText dark:text-amber-300' : 
                       ($note->tag === 'Important' ? 'bg-tag-importantBg dark:bg-red-900/30 text-tag-importantText dark:text-red-300' : 
                       ($note->tag === 'Study' ? 'bg-tag-studyBg dark:bg-blue-900/30 text-tag-studyText dark:text-blue-300' : 'bg-tag-defaultBg dark:bg-[#3c4043] text-tag-defaultText dark:text-[#e8eaed]')))) }}">
                    {{ $note->tag }}
                </span>
            @endif

            @if ($note->is_archived && $activeTab !== 'archive')
                <span class="text-[10px] px-2.5 py-0.5 rounded-full font-medium bg-gray-100 dark:bg-[#3c4043] text-gray-500 dark:text-[#9aa0a6]" data-tooltip="Archived">
                    <i class="fa-solid fa-box-archive"></i>
                </span>
            @endif
        </div>

        @if ($activeTab === 'trash')
            <div class="flex gap-1.5">
                <button wire:click="restore({{ $note->id }})"
                    class="text-[10px] py-1 px-2.5 rounded bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 cursor-pointer font-medium transition-colors hover:bg-green-100 dark:hover:bg-green-900/50">Restore</button>
                <button wire:click="forceDelete({{ $note->id }})"
                    wire:confirm="Delete permanently?"
                    class="text-[10px] py-1 px-2.5 rounded bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800 cursor-pointer font-medium transition-colors hover:bg-red-100 dark:hover:bg-red-900/50">Delete</button>
            </div>
        @else
            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                {{-- PIN --}}
                <button wire:click="togglePin({{ $note->id }})"
                    class="bg-transparent border-none cursor-pointer text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors
                    hover:bg-brand-light/50 dark:hover:bg-[#413123]/50
                    {{ $note->is_pinned ? 'text-brand-dark dark:text-[#fb923c]' : 'text-keep-textSecondary dark:text-[#9aa0a6] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]' }}"
                    data-tooltip="{{ $note->is_pinned ? 'Unpin' : 'Pin note' }}">
                    @if ($note->is_pinned)
                        <i class="fa-solid fa-thumbtack"></i>
                    @else
                        <i class="fa-solid fa-thumbtack opacity-60"></i>
                    @endif
                </button>

                {{-- ARCHIVE --}}
                <button wire:click="toggleArchive({{ $note->id }})" 
                    class="bg-transparent border-none cursor-pointer text-keep-textSecondary dark:text-[#9aa0a6] text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors hover:bg-keep-bg dark:hover:bg-[#3c4043] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]"
                    data-tooltip="{{ $note->is_archived ? 'Unarchive' : 'Archive' }}">
                    @if ($note->is_archived)
                        <i class="fa-solid fa-box-open"></i>
                    @else
                        <i class="fa-solid fa-box-archive"></i>
                    @endif
                </button>

                {{-- EDIT --}}
                <button wire:click="openEdit({{ $note->id }})" 
                    class="bg-transparent border-none cursor-pointer text-keep-textSecondary dark:text-[#9aa0a6] text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors hover:bg-keep-bg dark:hover:bg-[#3c4043] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]"
                    data-tooltip="Edit">
                    <i class="fa-regular fa-pen-to-square"></i>
                </button>

                {{-- DELETE --}}
                <button wire:click="delete({{ $note->id }})" 
                    class="bg-transparent border-none cursor-pointer text-keep-textSecondary dark:text-[#9aa0a6] text-xs p-1 rounded-full flex items-center justify-center w-7 h-7 transition-colors hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400"
                    data-tooltip="Remove">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
            </div>
        @endif
    </div>

    <p class="text-[9px] text-keep-textSecondary/80 dark:text-[#9aa0a6] m-0 text-right">{{ $note->created_at->format('d M Y') }}</p>
</div>
