<div style="display:flex; min-height:100vh; background:#1a1a1a; color:#e5e5e5; font-family:sans-serif;">

    {{-- SIDEBAR --}}
    <div
        style="width:220px; background:#1f1f1f; border-right:1px solid #2e2e2e; padding:1rem; display:flex; flex-direction:column; gap:6px;">

        <button wire:click="openCreate"
            style="background:#ea580c; color:white; border:none; border-radius:8px; padding:10px; font-size:14px; font-weight:500; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; margin-bottom:8px;">
            + New note
        </button>

        <button wire:click="cancelForm"
            style="background:{{ $activeTab === 'all' ? '#2e2e2e' : 'transparent' }}; color:{{ $activeTab === 'all' ? '#f5f5f5' : '#a3a3a3' }}; border:none; border-radius:8px; padding:9px 12px; text-align:left; font-size:14px; cursor:pointer; display:flex; align-items:center; gap:8px;">
            ☰ All notes
            <span style="margin-left:auto; font-size:12px; color:#525252;">{{ $totalNotes }}</span>
        </button>

        <button wire:click="$set('activeTab', 'favorites')"
            style="background:{{ $activeTab === 'favorites' ? '#2e2e2e' : 'transparent' }}; color:{{ $activeTab === 'favorites' ? '#f5f5f5' : '#a3a3a3' }}; border:none; border-radius:8px; padding:9px 12px; text-align:left; font-size:14px; cursor:pointer; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-star"></i> Favorites
        </button>

        <button wire:click="$set('activeTab', 'trash')"
            style="background:{{ $activeTab === 'trash' ? '#2e2e2e' : 'transparent' }}; color:{{ $activeTab === 'trash' ? '#f5f5f5' : '#a3a3a3' }}; border:none; border-radius:8px; padding:9px 12px; text-align:left; font-size:14px; cursor:pointer; display:flex; align-items:center; gap:8px;">
            <i class="fa-regular fa-trash-can"></i> Trash
        </button>

        @if ($tags->count() > 0)
            <div style="margin-top:1rem;">
                <p
                    style="font-size:11px; color:#525252; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px; padding:0 4px;">
                    Tags</p>
                <div style="display:flex; flex-wrap:wrap; gap:6px; padding:0 4px;">
                    @foreach ($tags as $t)
                        <span
                            style="font-size:12px; padding:3px 10px; border-radius:99px; cursor:pointer;
                            background:{{ $t === 'Personal' ? '#3d2b7a' : ($t === 'Work' ? '#1a3d24' : ($t === 'Idea' ? '#3d2a0d' : ($t === 'Important' ? '#3d1c1c' : ($t === 'Study' ? '#122b52' : '#2e2e2e')))) }};
                            color:{{ $t === 'Personal' ? '#a78bfa' : ($t === 'Work' ? '#34d399' : ($t === 'Idea' ? '#fbbf24' : ($t === 'Important' ? '#f87171' : ($t === 'Study' ? '#60a5fa' : '#a3a3a3')))) }};">
                            {{ $t }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- MAIN --}}
    <div style="flex:1; padding:1.5rem; display:flex; flex-direction:column; gap:1rem;">

        {{-- SEARCH --}}
        @if (!$showForm)
            <div
                style="display:flex; align-items:center; gap:10px; background:#2a2a2a; border:1px solid #3a3a3a; border-radius:99px; padding:10px 20px; width:100%;">
                <i class="fa-solid fa-magnifying-glass" style="color:#525252; font-size:14px;"></i>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search notes..."
                    style="background:transparent; border:none; outline:none; color:#e5e5e5; font-size:14px; width:100%;">
                @if ($search)
                    <button wire:click="$set('search', '')"
                        style="background:none; border:none; cursor:pointer; color:#525252; font-size:13px; padding:0;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                @endif
            </div>
        @endif

        {{-- FORM --}}
        @if ($showForm)
            <div
                style="background:#242424; border:1px solid #2e2e2e; border-radius:12px; padding:1.25rem; display:flex; flex-direction:column; gap:10px;">
                <input wire:model="title" type="text" placeholder="Title"
                    style="background:#2a2a2a; border:1px solid #3a3a3a; border-radius:8px; padding:10px 14px; color:#f5f5f5; font-size:15px; font-weight:500; outline:none; width:100%;">
                @error('title')
                    <span style="color:#f87171; font-size:12px;">{{ $message }}</span>
                @enderror

                <textarea wire:model="body" placeholder="Write your note here..." rows="4"
                    style="background:#2a2a2a; border:1px solid #3a3a3a; border-radius:8px; padding:10px 14px; color:#e5e5e5; font-size:14px; outline:none; width:100%; resize:none;"></textarea>
                @error('body')
                    <span style="color:#f87171; font-size:12px;">{{ $message }}</span>
                @enderror

                {{-- TAG PILLS --}}
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    <button type="button" wire:click="$set('tag', 'Personal')"
                        style="padding:4px 12px; border-radius:99px; border:none; font-size:12px; font-weight:500; cursor:pointer;
                            background:{{ $tag === 'Personal' ? '#a78bfa' : '#3d2b7a' }};
                            color:{{ $tag === 'Personal' ? '#1a1a1a' : '#a78bfa' }};">
                        Personal
                    </button>
                    <button type="button" wire:click="$set('tag', 'Work')"
                        style="padding:4px 12px; border-radius:99px; border:none; font-size:12px; font-weight:500; cursor:pointer;
                            background:{{ $tag === 'Work' ? '#34d399' : '#1a3d24' }};
                            color:{{ $tag === 'Work' ? '#1a1a1a' : '#34d399' }};">
                        Work
                    </button>
                    <button type="button" wire:click="$set('tag', 'Idea')"
                        style="padding:4px 12px; border-radius:99px; border:none; font-size:12px; font-weight:500; cursor:pointer;
                            background:{{ $tag === 'Idea' ? '#fbbf24' : '#3d2a0d' }};
                            color:{{ $tag === 'Idea' ? '#1a1a1a' : '#fbbf24' }};">
                        Idea
                    </button>
                    <button type="button" wire:click="$set('tag', 'Important')"
                        style="padding:4px 12px; border-radius:99px; border:none; font-size:12px; font-weight:500; cursor:pointer;
                            background:{{ $tag === 'Important' ? '#f87171' : '#3d1c1c' }};
                            color:{{ $tag === 'Important' ? '#1a1a1a' : '#f87171' }};">
                        Important
                    </button>
                    <button type="button" wire:click="$set('tag', 'Study')"
                        style="padding:4px 12px; border-radius:99px; border:none; font-size:12px; font-weight:500; cursor:pointer;
                            background:{{ $tag === 'Study' ? '#60a5fa' : '#122b52' }};
                            color:{{ $tag === 'Study' ? '#1a1a1a' : '#60a5fa' }};">
                        Study
                    </button>
                    <button type="button" wire:click="$set('showCustomTag', true)"
                        style="padding:4px 12px; border-radius:99px; border:none; font-size:12px; font-weight:500; cursor:pointer;
        background:{{ $showCustomTag ? '#525252' : '#2e2e2e' }};
        color:#a3a3a3;">
                        Other
                    </button>

                    @if ($showCustomTag)
                        <div style="display:flex; align-items:center; gap:6px; width:100%; margin-top:4px;">
                            <input wire:model="customTag" type="text" placeholder="Type your tag..."
                                wire:keydown.enter="applyCustomTag"
                                style="background:#2a2a2a; border:1px solid #3a3a3a; border-radius:8px; padding:6px 12px; color:#e5e5e5; font-size:13px; outline:none; flex:1;">
                            <button wire:click="applyCustomTag"
                                style="padding:6px 12px; border-radius:8px; border:none; background:#525252; color:#e5e5e5; font-size:12px; cursor:pointer;">
                                Add
                            </button>
                            <button wire:click="$set('showCustomTag', false)"
                                style="padding:6px 12px; border-radius:8px; border:none; background:#2e2e2e; color:#525252; font-size:12px; cursor:pointer;">
                                ✕
                            </button>
                        </div>
                    @endif
                </div>

                <div style="display:flex; gap:8px;">
                    <button wire:click="save"
                        style="background:#ea580c; color:white; border:none; border-radius:8px; padding:9px 20px; font-size:13px; font-weight:500; cursor:pointer;">
                        {{ $editingId ? 'Update' : 'Save' }}
                    </button>
                    <button wire:click="cancelForm"
                        style="background:#2e2e2e; color:#a3a3a3; border:none; border-radius:8px; padding:9px 20px; font-size:13px; cursor:pointer;">
                        Cancel
                    </button>
                </div>
            </div>
        @else
            {{-- NOTES GRID --}}
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:12px;">
                @forelse($notes as $note)
                    <div wire:key="note-{{ $note->id }}"
                        style="background:#242424; border:1px solid #2e2e2e; border-radius:12px; padding:1rem; display:flex; flex-direction:column; gap:8px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                            <p style="font-size:15px; font-weight:500; color:#f5f5f5;">{{ $note->title }}</p>
                            @if ($activeTab !== 'trash')
                                <button wire:click="toggleFavorite({{ $note->id }})"
                                    wire:key="star-{{ $note->id }}" class="btn-star"
                                    data-tooltip="{{ $note->is_favorite ? 'Remove from favorites' : 'Favorite' }}"
                                    style="color:{{ $note->is_favorite ? '#facc15' : '#525252' }};">
                                    @if ($note->is_favorite)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star"></i>
                                    @endif
                                </button>
                            @endif
                        </div>

                        <p style="font-size:13px; color:#737373; line-height:1.5;">
                            {{ Str::limit($note->body, 80) }}
                        </p>

                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:auto;">
                            @if ($note->tag)
                                <span
                                    style="font-size:11px; padding:3px 10px; border-radius:99px;
                                    background:{{ $note->tag === 'Personal' ? '#3d2b7a' : ($note->tag === 'Work' ? '#1a3d24' : ($note->tag === 'Idea' ? '#3d2a0d' : ($note->tag === 'Important' ? '#3d1c1c' : ($note->tag === 'Study' ? '#122b52' : '#2e2e2e')))) }};
                                    color:{{ $note->tag === 'Personal' ? '#a78bfa' : ($note->tag === 'Work' ? '#34d399' : ($note->tag === 'Idea' ? '#fbbf24' : ($note->tag === 'Important' ? '#f87171' : ($note->tag === 'Study' ? '#60a5fa' : '#a3a3a3')))) }};">
                                    {{ $note->tag }}
                                </span>
                            @else
                                <span></span>
                            @endif

                            @if ($activeTab === 'trash')
                                <div style="display:flex; gap:6px;">
                                    <button wire:click="restore({{ $note->id }})"
                                        style="font-size:11px; padding:4px 10px; border-radius:6px; background:#1a2e1a; color:#4ade80; border:none; cursor:pointer;">Restore</button>
                                    <button wire:click="forceDelete({{ $note->id }})"
                                        wire:confirm="Delete permanently?"
                                        style="font-size:11px; padding:4px 10px; border-radius:6px; background:#2d1515; color:#f87171; border:none; cursor:pointer;">Delete</button>
                                </div>
                            @else
                                <div style="display:flex; gap:8px;">
                                    <button wire:click="openEdit({{ $note->id }})" class="btn-edit"
                                        data-tooltip="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button wire:click="delete({{ $note->id }})" class="btn-delete"
                                        data-tooltip="Remove">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <p style="font-size:11px; color:#3a3a3a;">{{ $note->created_at->format('d M Y') }}</p>
                    </div>
                @empty
                    <div style="grid-column:1/-1; text-align:center; padding:3rem; color:#525252;">
                        <p style="font-size:32px; margin-bottom:8px;"><i class="fa-solid fa-bookmark"></i></p>
                        <p style="font-size:14px;">No notes yet. Create your first note!</p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            @if ($notes->hasPages())
                <div style="display:flex; justify-content:center; align-items:center; gap:6px; margin-top:1rem;">
                    @if ($notes->onFirstPage())
                        <span
                            style="padding:6px 12px; border-radius:8px; background:#2e2e2e; color:#525252; font-size:13px;">←
                            Prev</span>
                    @else
                        <button wire:click="previousPage"
                            style="padding:6px 12px; border-radius:8px; background:#2e2e2e; color:#e5e5e5; font-size:13px; border:none; cursor:pointer;">←
                            Prev</button>
                    @endif

                    <span style="padding:6px 12px; color:#525252; font-size:13px;">
                        {{ $notes->currentPage() }} / {{ $notes->lastPage() }}
                    </span>

                    @if ($notes->hasMorePages())
                        <button wire:click="nextPage"
                            style="padding:6px 12px; border-radius:8px; background:#2e2e2e; color:#e5e5e5; font-size:13px; border:none; cursor:pointer;">Next
                            →</button>
                    @else
                        <span
                            style="padding:6px 12px; border-radius:8px; background:#2e2e2e; color:#525252; font-size:13px;">Next
                            →</span>
                    @endif
                </div>
            @endif

        @endif
    </div>
</div>
