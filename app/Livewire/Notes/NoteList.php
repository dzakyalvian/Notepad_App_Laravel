<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class NoteList extends Component
{
    use WithPagination;

    public string $title = '';
    public string $body = '';
    public string $tag = '';
    public string $customTag = '';
    public bool $showCustomTag = false;
    public array $availableTags = [
        ['name' => 'Personal',  'color' => '#a78bfa'],
        ['name' => 'Work',      'color' => '#34d399'],
        ['name' => 'Idea',      'color' => '#fbbf24'],
        ['name' => 'Important', 'color' => '#f87171'],
        ['name' => 'Study',     'color' => '#60a5fa'],
    ];
    public ?int $editingId = null;
    public bool $showForm = false;
    public string $search = '';
    public string $activeTab = 'all';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedActiveTab(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->reset(['title', 'body', 'tag', 'editingId']);
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $this->editingId = $note->id;
        $this->title     = $note->title;
        $this->body      = $note->body;
        $this->tag       = $note->tag ?? '';
        $this->showForm  = true;
    }

    public function save(): void
    {
        $this->validate([
            'title' => 'required',
            'body'  => 'required',
        ]);

        if ($this->editingId) {
            $note = Note::findOrFail($this->editingId);
            abort_if($note->user_id !== Auth::id(), 403);
            $note->update([
                'title' => $this->title,
                'body'  => $this->body,
                'tag'   => $this->tag,
            ]);
        } else {
            Note::create([
                'user_id' => Auth::id(),
                'title'   => $this->title,
                'body'    => $this->body,
                'tag'     => $this->tag,
            ]);
        }

        $this->reset(['title', 'body', 'tag', 'editingId', 'showForm']);
    }

    public function toggleFavorite(int $id): void
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $note->is_favorite = !$note->is_favorite;
        $note->save();
    }

    public function delete(int $id): void
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $note->update(['is_deleted' => true]);
    }

    public function cancelForm(): void
    {
        $this->reset(['title', 'body', 'tag', 'editingId', 'showForm']);
        $this->activeTab = 'all';
    }

    public function restore(int $id): void
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $note->update(['is_deleted' => false]);
    }

    public function forceDelete(int $id): void
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $note->delete();
    }

    public function applyCustomTag(): void
    {
        if (trim($this->customTag) !== '') {
            $this->tag = trim($this->customTag);
            $this->customTag = '';
            $this->showCustomTag = false;
        }
    }

    public function render()
    {
        $query = Note::forUser(Auth::id())
            ->select('id', 'title', 'body', 'tag', 'is_favorite', 'is_deleted', 'created_at');

        if ($this->activeTab === 'favorites') {
            $query->favorites();
        } elseif ($this->activeTab === 'trash') {
            $query->trashed();
        } else {
            $query->active();
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('body', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.notes.note-list', [
            'notes'         => $query->latest()->paginate(12),
            'tags' => Note::forUser(Auth::id())->active()->whereNotNull('tag')->where('tag', '!=', '')->select('tag')->distinct()->pluck('tag'),
            'availableTags' => $this->availableTags,
            'totalNotes'    => Note::forUser(Auth::id())->active()->count(),
        ]);
    }
}
