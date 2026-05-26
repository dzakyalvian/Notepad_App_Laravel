<div class="flex min-h-screen bg-keep-bg dark:bg-[#202124] text-keep-textPrimary dark:text-[#e8eaed] font-sans transition-colors duration-200">

    {{-- SIDEBAR OVERLAY FOR MOBILE --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden sm:hidden transition-opacity"></div>

    {{-- SIDEBAR --}}
    <div id="sidebar" class="fixed sm:static inset-y-0 left-0 transform -translate-x-full sm:translate-x-0 w-60 bg-keep-bg dark:bg-[#202124] sm:bg-transparent dark:sm:bg-transparent py-4 flex flex-col gap-1 shrink-0 z-50 transition-transform duration-200 ease-in-out border-r border-keep-border/60 dark:border-[#5f6368] sm:border-none">

        <div class="px-4 pb-4">
            <button wire:click="openCreate"
                class="bg-brand-primary hover:bg-brand-dark text-white border-none rounded-[24px] py-3 px-5 text-sm font-medium cursor-pointer flex items-center justify-center gap-2 w-full shadow-[0_1px_2px_0_rgba(60,64,67,0.3),0_1px_3px_1px_rgba(60,64,67,0.15)] transition-colors">
                <i class="fa-solid fa-plus"></i> New note
            </button>
        </div>

        {{-- All Notes --}}
        <button wire:click="cancelForm" 
            class="border-none rounded-r-[24px] rounded-l-none py-2.5 px-6 text-left text-sm font-medium cursor-pointer flex items-center gap-3 w-[calc(100%-8px)] transition-colors
            {{ $activeTab === 'all' 
                ? 'bg-brand-light dark:bg-[#413123] text-brand-primary dark:text-[#fb923c] hover:bg-brand-light/80 dark:hover:bg-[#523d2b] hover:text-brand-dark font-semibold' 
                : 'bg-transparent text-keep-textSecondary dark:text-[#9aa0a6] hover:bg-keep-border/40 dark:hover:bg-[#3c4043] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]' }}">
            <i class="fa-regular fa-lightbulb"></i> Notes
            <span class="ml-auto text-xs font-normal text-keep-textSecondary dark:text-[#9aa0a6]">{{ $totalNotes }}</span>
        </button>

        {{-- Favorites --}}
        <button wire:click="$set('activeTab', 'favorites')" 
            class="border-none rounded-r-[24px] rounded-l-none py-2.5 px-6 text-left text-sm font-medium cursor-pointer flex items-center gap-3 w-[calc(100%-8px)] transition-colors
            {{ $activeTab === 'favorites' 
                ? 'bg-brand-light dark:bg-[#413123] text-brand-primary dark:text-[#fb923c] hover:bg-brand-light/80 dark:hover:bg-[#523d2b] hover:text-brand-dark font-semibold' 
                : 'bg-transparent text-keep-textSecondary dark:text-[#9aa0a6] hover:bg-keep-border/40 dark:hover:bg-[#3c4043] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]' }}">
            <i class="fa-regular fa-star"></i> Favorites
        </button>

        {{-- Archive --}}
        <button wire:click="$set('activeTab', 'archive')" 
            class="border-none rounded-r-[24px] rounded-l-none py-2.5 px-6 text-left text-sm font-medium cursor-pointer flex items-center gap-3 w-[calc(100%-8px)] transition-colors
            {{ $activeTab === 'archive' 
                ? 'bg-brand-light dark:bg-[#413123] text-brand-primary dark:text-[#fb923c] hover:bg-brand-light/80 dark:hover:bg-[#523d2b] hover:text-brand-dark font-semibold' 
                : 'bg-transparent text-keep-textSecondary dark:text-[#9aa0a6] hover:bg-keep-border/40 dark:hover:bg-[#3c4043] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]' }}">
            <i class="fa-solid fa-box-archive"></i> Archive
        </button>

        {{-- Trash --}}
        <button wire:click="$set('activeTab', 'trash')" 
            class="border-none rounded-r-[24px] rounded-l-none py-2.5 px-6 text-left text-sm font-medium cursor-pointer flex items-center gap-3 w-[calc(100%-8px)] transition-colors
            {{ $activeTab === 'trash' 
                ? 'bg-brand-light dark:bg-[#413123] text-brand-primary dark:text-[#fb923c] hover:bg-brand-light/80 dark:hover:bg-[#523d2b] hover:text-brand-dark font-semibold' 
                : 'bg-transparent text-keep-textSecondary dark:text-[#9aa0a6] hover:bg-keep-border/40 dark:hover:bg-[#3c4043] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]' }}">
            <i class="fa-regular fa-trash-can"></i> Trash
        </button>

        @if ($tags->count() > 0)
            <div class="mt-6 px-6">
                <p class="text-[11px] text-keep-textSecondary font-semibold uppercase tracking-wider mb-2.5">
                    Tags
                </p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($tags as $t)
                        <span class="text-xs px-3 py-1 rounded-full font-medium cursor-pointer
                            {{ $t === 'Personal' ? 'bg-tag-personalBg text-tag-personalText' : 
                               ($t === 'Work' ? 'bg-tag-workBg text-tag-workText' : 
                               ($t === 'Idea' ? 'bg-tag-ideaBg text-tag-ideaText' : 
                               ($t === 'Important' ? 'bg-tag-importantBg text-tag-importantText' : 
                               ($t === 'Study' ? 'bg-tag-studyBg text-tag-studyText' : 'bg-tag-defaultBg text-tag-defaultText')))) }}">
                            {{ $t }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- MAIN --}}
    <div class="flex-1 py-4 sm:py-6 px-4 sm:px-8 flex flex-col gap-4 sm:gap-6 min-w-0">

        {{-- SEARCH --}}
        @if (!$showForm)
            <div class="flex items-center gap-2.5 bg-keep-navbar dark:bg-[#202124] sm:dark:bg-[#28292c] border border-keep-border dark:border-[#5f6368] rounded-lg py-2.5 px-4 w-full max-w-[600px] shadow-sm transition-all focus-within:shadow-md focus-within:border-keep-borderHover dark:focus-within:border-[#80868b] mx-auto">
                <i class="fa-solid fa-magnifying-glass text-keep-textSecondary dark:text-[#9aa0a6] text-sm"></i>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search notes..."
                    class="bg-transparent border-none outline-none text-keep-textPrimary dark:text-[#e8eaed] placeholder-keep-textSecondary/70 dark:placeholder-[#9aa0a6]/70 text-sm w-full font-sans">
                @if ($search)
                    <button wire:click="$set('search', '')"
                        class="bg-transparent border-none cursor-pointer text-keep-textSecondary dark:text-[#9aa0a6] hover:text-keep-textPrimary dark:hover:text-[#e8eaed] text-xs p-0 flex items-center transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                @endif
            </div>
        @endif

        {{-- FORM --}}
        @if ($showForm)
            <div class="bg-keep-navbar dark:bg-[#202124] sm:dark:bg-[#28292c] border border-keep-border dark:border-[#5f6368] rounded-lg p-4 sm:p-5 flex flex-col gap-3 shadow-md w-full max-w-[600px] mx-auto">
                <input wire:model="title" type="text" placeholder="Title"
                    class="bg-transparent border-none text-keep-textPrimary dark:text-[#e8eaed] placeholder-keep-textSecondary/70 dark:placeholder-[#9aa0a6]/70 text-base font-semibold outline-none w-full py-1">
                @error('title')
                    <span class="text-[#d93025] dark:text-[#f28b82] text-xs">{{ $message }}</span>
                @enderror

                <textarea wire:model="body" placeholder="Write your note here..." rows="4"
                    class="bg-transparent border-none text-keep-textBody dark:text-[#e8eaed] placeholder-keep-textSecondary/70 dark:placeholder-[#9aa0a6]/70 text-sm outline-none w-full resize-none py-1 leading-relaxed"></textarea>
                @error('body')
                    <span class="text-[#d93025] text-xs">{{ $message }}</span>
                @enderror

                {{-- TAG PILLS --}}
                <div class="flex flex-wrap gap-1.5 my-2">
                    <button type="button" wire:click="$set('tag', 'Personal')" 
                        class="px-3 py-1 rounded-full text-xs font-medium cursor-pointer border-none transition-colors
                        {{ $tag === 'Personal' ? 'bg-tag-personalText text-white' : 'bg-tag-personalBg text-tag-personalText' }}">
                        Personal
                    </button>
                    <button type="button" wire:click="$set('tag', 'Work')" 
                        class="px-3 py-1 rounded-full text-xs font-medium cursor-pointer border-none transition-colors
                        {{ $tag === 'Work' ? 'bg-tag-workText text-white' : 'bg-tag-workBg text-tag-workText' }}">
                        Work
                    </button>
                    <button type="button" wire:click="$set('tag', 'Idea')" 
                        class="px-3 py-1 rounded-full text-xs font-medium cursor-pointer border-none transition-colors
                        {{ $tag === 'Idea' ? 'bg-tag-ideaText text-white' : 'bg-tag-ideaBg text-tag-ideaText' }}">
                        Idea
                    </button>
                    <button type="button" wire:click="$set('tag', 'Important')" 
                        class="px-3 py-1 rounded-full text-xs font-medium cursor-pointer border-none transition-colors
                        {{ $tag === 'Important' ? 'bg-tag-importantText text-white' : 'bg-tag-importantBg text-tag-importantText' }}">
                        Important
                    </button>
                    <button type="button" wire:click="$set('tag', 'Study')" 
                        class="px-3 py-1 rounded-full text-xs font-medium cursor-pointer border-none transition-colors
                        {{ $tag === 'Study' ? 'bg-tag-studyText text-white' : 'bg-tag-studyBg text-tag-studyText' }}">
                        Study
                    </button>
                    <button type="button" wire:click="$set('showCustomTag', true)" 
                        class="px-3 py-1 rounded-full text-xs font-medium cursor-pointer bg-[#f1f3f4] dark:bg-[#3c4043] text-keep-textSecondary dark:text-[#9aa0a6] border border-dashed border-keep-border dark:border-[#5f6368] hover:bg-[#e8eaed] dark:hover:bg-[#5f6368] transition-colors">
                        + Custom Tag
                    </button>

                    @if ($showCustomTag)
                        <div class="flex items-center gap-1.5 w-full mt-2">
                            <input wire:model="customTag" type="text" placeholder="Type tag name..."
                                wire:keydown.enter="applyCustomTag"
                                class="bg-keep-navbar dark:bg-[#202124] border border-keep-border dark:border-[#5f6368] rounded-md py-1.5 px-3 text-keep-textPrimary dark:text-[#e8eaed] text-xs outline-none flex-1">
                            <button wire:click="applyCustomTag"
                                class="py-1.5 px-3 rounded-md border-none bg-brand-primary hover:bg-brand-dark text-white text-xs font-medium cursor-pointer transition-colors">
                                Add
                            </button>
                            <button wire:click="$set('showCustomTag', false)"
                                class="py-1.5 px-3 rounded-md border-none bg-[#f1f3f4] dark:bg-[#3c4043] hover:bg-[#e8eaed] dark:hover:bg-[#5f6368] text-keep-textSecondary dark:text-[#9aa0a6] text-xs cursor-pointer transition-colors">
                                ✕
                            </button>
                        </div>
                    @endif
                </div>

                <div class="flex gap-2 justify-end border-t border-keep-bg dark:border-[#5f6368]/30 pt-3 mt-1">
                    <button wire:click="cancelForm"
                        class="bg-transparent text-keep-textSecondary dark:text-[#9aa0a6] border-none rounded py-2 px-4 text-xs font-medium cursor-pointer transition-colors hover:bg-keep-bg dark:hover:bg-[#3c4043]">
                        Cancel
                    </button>
                    <button wire:click="save"
                        class="bg-brand-primary text-white border-none rounded py-2 px-5 text-xs font-medium cursor-pointer transition-colors hover:bg-brand-dark">
                        {{ $editingId ? 'Update' : 'Save' }}
                    </button>
                </div>
            </div>
        @else
            {{-- NOTES GRID ARSITEKTUR GOOGLE KEEP --}}
            <div class="flex flex-col gap-8 w-full">

                {{-- ================= PINNED NOTES GRID ================= --}}
                @if($pinnedNotes->count() > 0)
                    <div class="flex flex-col gap-2">
                        <p class="text-[11px] text-keep-textSecondary dark:text-[#9aa0a6] font-semibold uppercase tracking-wider px-1">
                            Pinned
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($pinnedNotes as $note)
                                <div wire:key="note-pinned-{{ $note->id }}">
                                    @include('livewire.notes.partials.note-card', ['note' => $note, 'viewContext' => 'pinned'])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ================= OTHERS / REGULAR NOTES GRID ================= --}}
                <div class="flex flex-col gap-2">
                    @if($pinnedNotes->count() > 0 && $otherNotes->count() > 0)
                        <p class="text-[11px] text-keep-textSecondary dark:text-[#9aa0a6] font-semibold uppercase tracking-wider px-1">
                            Others
                        </p>
                    @endif

                    @if($otherNotes->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($otherNotes as $note)
                                <div wire:key="note-other-{{ $note->id }}">
                                    @include('livewire.notes.partials.note-card', ['note' => $note, 'viewContext' => 'other'])
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State jika benar-benar kosong di kedua sisi --}}
                        @if($pinnedNotes->count() == 0)
                            <div class="text-center py-20 px-4 sm:px-8 text-keep-textSecondary dark:text-[#9aa0a6]">
                                <p class="text-5xl m-0 mb-4 text-keep-border dark:text-[#5f6368]"><i class="fa-regular fa-lightbulb"></i></p>
                                <p class="text-base font-semibold m-0 mb-1 text-keep-textPrimary dark:text-[#e8eaed]">No notes found</p>
                                <p class="text-xs m-0">Notes you add appear here</p>
                            </div>
                        @endif
                    @endif
                </div>

            </div>

            {{-- PAGINATION (Hanya terikat pada $otherNotes) --}}
            @if ($otherNotes->hasPages())
                <div class="flex justify-center items-center gap-2 mt-8">
                    @if ($otherNotes->onFirstPage())
                        <span class="py-1.5 px-3 rounded-lg bg-keep-border/30 dark:bg-[#3c4043]/50 text-keep-textSecondary/50 dark:text-[#9aa0a6]/50 text-xs border border-keep-border/40 dark:border-[#5f6368]/50">← Prev</span>
                    @else
                        <button wire:click="previousPage" class="py-1.5 px-3 rounded-lg bg-keep-card dark:bg-[#28292c] text-keep-textSecondary dark:text-[#9aa0a6] text-xs border border-keep-border dark:border-[#5f6368] cursor-pointer transition-colors hover:bg-keep-bg dark:hover:bg-[#3c4043] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]">← Prev</button>
                    @endif

                    <span class="py-1.5 px-3 text-keep-textSecondary dark:text-[#9aa0a6] text-xs font-semibold">
                        {{ $otherNotes->currentPage() }} / {{ $otherNotes->lastPage() }}
                    </span>

                    @if ($otherNotes->hasMorePages())
                        <button wire:click="nextPage" class="py-1.5 px-3 rounded-lg bg-keep-card dark:bg-[#28292c] text-keep-textSecondary dark:text-[#9aa0a6] text-xs border border-keep-border dark:border-[#5f6368] cursor-pointer transition-colors hover:bg-keep-bg dark:hover:bg-[#3c4043] hover:text-keep-textPrimary dark:hover:text-[#e8eaed]">Next →</button>
                    @else
                        <button class="py-1.5 px-3 rounded-lg bg-keep-border/30 dark:bg-[#3c4043]/50 text-keep-textSecondary/50 dark:text-[#9aa0a6]/50 text-xs border border-keep-border/40 dark:border-[#5f6368]/50" disabled>Next →</button>
                    @endif
                </div>
            @endif

        @endif
    </div>
</div>