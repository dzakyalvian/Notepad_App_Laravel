<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NoteList extends Component
{
    public string $title = '';
    public string $body = '';
    public string $tag = '';
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

    public function openCreate()
    {
        $this->reset(['title', 'body', 'tag', 'editingId']);
        $this->showForm = true;
    }

    public function openEdit(int $id)
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $this->editingId = $note->id;
        $this->title = $note->title;
        $this->body = $note->body;
        $this->tag = $note->tag ?? '';
        $this->showForm = true;
    }

    public function save()
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

    public function toggleFavorite(int $id)
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $note->is_favorite = !$note->is_favorite;
        $note->save();
    }

    public function delete(int $id)
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $note->update(['is_deleted' => true]);
    }

    public function restore(int $id)
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $note->update(['is_deleted' => false]);
    }

    public function forceDelete(int $id)
    {
        $note = Note::findOrFail($id);
        abort_if($note->user_id !== Auth::id(), 403);
        $note->delete();
    }

    public function render()
    {
        $query = Note::where('user_id', Auth::id());

        if ($this->activeTab === 'favorites') {
            $query->where('is_favorite', true)->where('is_deleted', false);
        } elseif ($this->activeTab === 'trash') {
            $query->where('is_deleted', true);
        } else {
            $query->where('is_deleted', false);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('body', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.notes.note-list', [
            'notes' => $query->latest()->get(),
            'tags'  => Note::where('user_id', Auth::id())
                ->where('is_deleted', false)
                ->whereNotNull('tag')
                ->pluck('tag')
                ->unique()
                ->values(),
            'availableTags' => $this->availableTags,
        ]);
    }
}
