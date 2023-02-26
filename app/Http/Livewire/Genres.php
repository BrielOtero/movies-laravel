<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Genre;
use Livewire\WithPagination;

class Genres extends Component
{
    use WithPagination;

    public $search;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $genres = Genre::where('user_id', auth()->user()->id)
            ->when($this->search, function ($query) {
                return $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                }
                );
            });

        $genres = $genres->paginate(10);
        return view('livewire.genres', [
            'genres' => $genres,
        ]);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
