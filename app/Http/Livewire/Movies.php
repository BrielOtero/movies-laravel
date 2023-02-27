<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Movie;
use App\Models\Genre;

class Movies extends Component
{
    use WithPagination;
    public $box_office;
    public $search;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $movie;
    public $confirmingMovieDeletion = false;
    public $confirmingMovieAdd = false;

    protected $rules = [
        'movie.genre_id' => 'required|int|min:1',
        'movie.name' => 'required|string|min:4',
        'movie.duration' => 'required|int|between:1,1000',
        'movie.director' => 'required|string|min:4',
        'movie.box_office' => 'boolean',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'box_office' => ['except' => false],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    public function render()
    {
        $movies = Movie::where('user_id', auth()->user()->id)
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
        $genres = Genre::where('user_id', auth()->user()->id)->get();

        return view('livewire.movies', [
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
    public function confirmMovieDeletion($id)
    {
        $this->confirmingMovieDeletion = $id;
    }
    public function deleteMovie(Movie $movie)
    {
        $movie->delete();
        $this->confirmingMovieDeletion = false;
    }
    public function confirmMovieAdd()
    {
        $this->reset(['movie']);
        $this->confirmingMovieAdd = true;
    }
    public function addMovie()
    {
        $this->validate();
        if (isset($this->movie->id)) {
            $this->movie->save();
        } else {
            auth()->user()->movies()->create([
                'genre_id' => $this->movie['genre_id'],
                'name' => $this->movie['name'],
                'duration' => $this->movie['duration'],
                'director' => $this->movie['director'],
                'box_office' => $this->movie['box_office'] ?? 0
            ]);
        }
        $this->confirmingMovieAdd = false;
    }

    public function confirmMovieEdit(Movie $movie)
    {
        $this->movie = $movie;
        $this->confirmingMovieAdd = true;
    }
}
