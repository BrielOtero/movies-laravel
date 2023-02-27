<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Genre;
use App\Models\Movie;

class AllMovies extends Component
{
    use WithPagination;

    public $box_office;
    public $search;
    public $sortBy = 'id';
    public $sortAsc = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'box_office' => ['except' => false],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    public function render()
    {
        $movies = Movie::select('*')->groupBy('name')
            ->when($this->search, function ($query) {
                return $query->where(
                    function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('director', 'like', '%' . $this->search . '%');
                        }
                );
            })
            ->when($this->box_office, function ($query) {
                return $query->boxOffice();
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $movies = $movies->paginate(10);
        $genres = Genre::select('*')->get();

        return view('livewire.all-movies', [
            'movies' => $movies,
            'genres' => $genres,
        ]);
    }
    public function updatingBoxOffice()
    {
        $this->resetPage();
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

}
