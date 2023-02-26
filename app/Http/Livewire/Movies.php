<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Genre;
use Livewire\WithPagination;

class Movies extends Component
{
    use WithPagination;
    public $box_office;

    public function render()
    {
        $movies = Movie::where('user_id', auth()->user()->id)
            ->when($this->box_office, function ($query) {
                return $query->boxOffice();
            });

        $movies = $movies->paginate(10);
        $genres = Genre::where('user_id', auth()->user()->id);

        return view('livewire.movies', [
            'movies' => $movies,
            'genres' => $genres
        ]);
    }

    public function updatingBoxOffice()
    {
        $this->resetPage();
    }
}
