<div style="display:flex; min-height:100vh; background:#1a1a1a; color:#e5e5e5; font-family:sans-serif;">

    {{-- SIDEBAR --}}
    <div style="width:220px; background:#1f1f1f; border-right:1px solid #2e2e2e; padding:1rem; display:flex; flex-direction:column; gap:6px;">

        <button wire:click="openCreate"
            style="background:#ea580c; color:white; border:none; border-radius:8px; padding:10px; font-size:14px; font-weight:500; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; margin-bottom:8px;">
            + New note
        </button>

        <button wire:click="$set('activeTab', 'all')"
            style="background:{{ $activeTab === 'all' ? '#2e2e2e' : 'transparent' }}; color:{{ $activeTab === 'all' ? '#f5f5f5' : '#a3a3a3' }}; border:none; border-radius:8px; padding:9px 12px; text-align:left; font-size:14px; cursor:pointer; display:flex; align-items:center; gap:8px;">
            ☰ All notes
            <span style="margin-left:auto; font-size:12px; color:#525252;">{{ auth()->user()->notes()->where('is_deleted', false)->count() }}</span>
        </button>

        <button wire:click="$set('activeTab', 'favorites')"
            style="background:{{ $activeTab === 'favorites' ? '#2e2e2e' : 'transparent' }}; color:{{ $activeTab === 'favorites' ? '#f5f5f5' : '#a3a3a3' }}; border:none; border-radius:8px; padding:9px 12px; text-align:left; font-size:14px; cursor:pointer; display:flex; align-items:center; gap:8px;">
            ☆ Favorites
        </button>

        <button wire:click="$set('activeTab', 'trash')"
            style="background:{{ $activeTab === 'trash' ? '#2e2e2e' : 'transparent' }}; color:{{ $activeTab === 'trash' ? '#f5f5f5' : '#a3a3a3' }}; border:none; border-radius:8px; padding:9px 12px; text-align:left; font-size:14px; cursor:pointer; display:flex; align-items:center; gap:8px;">
            🗑 Trash
        </button>

        @if($tags->count() > 0)
        <div style="margin-top:1rem;">
            <p style="font-size:11px; color:#525252; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px; padding:0 4px;">Tags</p>
            <div style="display:flex; flex-wrap:wrap; gap:6px; padding:0 4px;">
                @foreach($tags as $t)
                <span style="font-size:12px; padding:3px 10px; border-radius:99px; background:#2e2e2e; color:#a3a3a3; cursor:pointer;">{{ $t }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- MAIN --}}
    <div style="flex:1; padding:1.5rem; display:flex; flex-direction:column; gap:1rem;">

        {{-- SEARCH --}}
        <div style="display:flex; align-items:center; gap:8px; background:#2a2a2a; border:1px solid #2e2e2e; border-radius:8px; padding:10px 14px;">
            <span style="color:#525252;">🔍</span>
            <input wire:model.live="search" type="text" placeholder="Search notes..."
                style="background:transparent; border:none; outline:none; color:#e5e5e5; font-size:14px; width:100%;">
        </div>

        {{-- FORM --}}
        @if($showForm)
        <div style="background:#242424; border:1px solid #2e2e2e; border-radius:12px; padding:1.25rem; display:flex; flex-direction:column; gap:10px;">
            <input wire:model="title" type="text" placeholder="Title"
                style="background:#2a2a2a; border:1px solid #3a3a3a; border-radius:8px; padding:10px 14px; color:#f5f5f5; font-size:15px; font-weight:500; outline:none; width:100%;">
            @error('title') <span style="color:#f87171; font-size:12px;">{{ $message }}</span> @enderror

            <textarea wire:model="body" placeholder="Write your note here..." rows="4"
                style="background:#2a2a2a; border:1px solid #3a3a3a; border-radius:8px; padding:10px 14px; color:#e5e5e5; font-size:14px; outline:none; width:100%; resize:none;"></textarea>
            @error('body') <span style="color:#f87171; font-size:12px;">{{ $message }}</span> @enderror

            <input wire:model="tag" type="text" placeholder="Tag (e.g. Kuliah, Ide, Tugas)"
                style="background:#2a2a2a; border:1px solid #3a3a3a; border-radius:8px; padding:10px 14px; color:#e5e5e5; font-size:13px; outline:none; width:100%;">

            <div style="display:flex; gap:8px;">
                <button wire:click="save"
                    style="background:#ea580c; color:white; border:none; border-radius:8px; padding:9px 20px; font-size:13px; font-weight:500; cursor:pointer;">
                    {{ $editingId ? 'Update' : 'Save' }}
                </button>
                <button wire:click="$set('showForm', false)"
                    style="background:#2e2e2e; color:#a3a3a3; border:none; border-radius:8px; padding:9px 20px; font-size:13px; cursor:pointer;">
                    Cancel
                </button>
            </div>
        </div>
        @endif

        {{-- NOTES GRID --}}
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:12px;">
            @forelse($notes as $note)
            <div style="background:#242424; border:1px solid #2e2e2e; border-radius:12px; padding:1rem; display:flex; flex-direction:column; gap:8px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <p style="font-size:15px; font-weight:500; color:#f5f5f5;">{{ $note->title }}</p>
                    @if($activeTab !== 'trash')
                    <button wire:click="toggleFavorite({{ $note->id }})" style="background:none; border:none; cursor:pointer; font-size:16px; color:{{ $note->is_favorite ? '#ea580c' : '#525252' }};">
                        {{ $note->is_favorite ? '★' : '☆' }}
                    </button>
                    @endif
                </div>

                <p style="font-size:13px; color:#737373; line-height:1.5;">
                    {{ Str::limit($note->body, 80) }}
                </p>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:auto;">
                    @if($note->tag)
                    <span style="font-size:11px; padding:3px 10px; border-radius:99px; background:#2e2e2e; color:#a3a3a3;">{{ $note->tag }}</span>
                    @else
                    <span></span>
                    @endif

                    @if($activeTab === 'trash')
                    <div style="display:flex; gap:6px;">
                        <button wire:click="restore({{ $note->id }})" style="font-size:11px; padding:4px 10px; border-radius:6px; background:#1a2e1a; color:#4ade80; border:none; cursor:pointer;">Restore</button>
                        <button wire:click="forceDelete({{ $note->id }})" wire:confirm="Delete permanently?" style="font-size:11px; padding:4px 10px; border-radius:6px; background:#2d1515; color:#f87171; border:none; cursor:pointer;">Delete</button>
                    </div>
                    @else
                    <div style="display:flex; gap:8px;">
                        <button wire:click="openEdit({{ $note->id }})" style="background:none; border:none; cursor:pointer; color:#525252; font-size:14px;">✏️</button>
                        <button wire:click="delete({{ $note->id }})" style="background:none; border:none; cursor:pointer; color:#525252; font-size:14px;">🗑</button>
                    </div>
                    @endif
                </div>

                <p style="font-size:11px; color:#3a3a3a;">{{ $note->created_at->format('d M Y') }}</p>
            </div>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:3rem; color:#525252;">
                <p style="font-size:32px; margin-bottom:8px;">📝</p>
                <p style="font-size:14px;">No notes yet. Create your first note!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
