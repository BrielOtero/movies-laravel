<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Genre;

class Genres extends Component
{
    use WithPagination;

    public $search;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $genre;
    public $confirmingGenreDeletion = false;
    public $confirmingGenreAdd = false;

    protected $rules =[
        'genre.name' =>'required|string|min:4'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    public function render()
    {
        $genres = Genre::where('user_id', auth()->user()->id)
            ->when($this->search, function ($query) {
                return $query->where(
                    function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        }
                );
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $genres = $genres->paginate(10);
        return view('livewire.genres', [
            'genres' => $genres,
        ]);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }
    public function confirmGenreDeletion($id)
    {
        $this->confirmingGenreDeletion = $id;
    }
    public function deleteGenre(Genre $genre)
    {
        $genre->delete();
        $this->confirmingGenreDeletion = false;
    }
    public function confirmGenreAdd()
    {
        $this->reset(['genre']);
        $this->confirmingGenreAdd = true;
    }
    public function addGenre()
    {
        $this->validate();
        if (isset($this->genre->id)) {
            $this->genre->save();
        } else {
            auth()->user()->genres()->create([
                'name' => $this->genre['name']
            ]);
        }
        $this->confirmingGenreAdd = false;
    }
    public function confirmGenreEdit(Genre $genre)
    {
        $this->genre = $genre;
        $this->confirmingGenreAdd = true;
    }
}
