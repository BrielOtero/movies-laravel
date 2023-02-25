<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Movie;
use Livewire\WithPagination;

class Movies extends Component
{
    use WithPagination;
    public function render()
    {
        $movies = Movie::where('user_id', auth()->user()->id);
        $query = $movies->toSql();
        $movies = $movies->paginate(10);

        return view('livewire.movies', [
            'movies' => $movies,
            'query' => $query
        ]);
    }
}
