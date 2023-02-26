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
    public $confirmingGenreDeletion = false;


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
    public function confirmGenreDeletion($id){
        $this->confirmingGenreDeletion = $id;
    }
    public function deleteGenre(Genre $genre){
        $genre->delete();
        $this->confirmingGenreDeletion = false;
    }
}
