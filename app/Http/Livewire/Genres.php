<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Genre;
use Livewire\WithPagination;

class Genres extends Component
{
    use WithPagination;
    public function render()
    {
        $genres = Genre::where('user:id', auth()->user()->id);
        $query = $genres->toSql();
        $genres=$genres->paginate(10);

        return view('livewire.genres',[
            'genres' =>$genres,
            'query' => $query
        ]);
    }
}
