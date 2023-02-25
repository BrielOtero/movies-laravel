<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Genre;
use Livewire\WithPagination;

class Movies extends Component
{
    use WithPagination;

    public function render()
    {
        $movies = Movie::where('user_id', auth()->user()->id)->paginate(10);
        $genres = Genre::where('user_id', auth()->user()->id);

        return view('livewire.movies', [
            'movies' => $movies,
            'genres' => $genres
        ]);
    }
}
