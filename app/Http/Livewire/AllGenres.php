<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Genre;

class AllGenres extends Component
{
    public $search;
    public $sortBy = 'id';
    public $sortAsc = true;
    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];
    public function render()
    {
        $genres = Genre::select('*')->groupBy('name')
            ->when($this->search, function ($query) {
                return $query->where(
                    function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        }
                );
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');

        $genres = $genres->paginate(10);
        return view('livewire.all-genres', [
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
}
