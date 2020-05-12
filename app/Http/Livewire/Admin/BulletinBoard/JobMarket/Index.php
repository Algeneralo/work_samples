<?php

namespace App\Http\Livewire\Admin\BulletinBoard\JobMarket;

use App\Http\Traits\HasFiltersWithPagination;
use App\Http\Traits\Sortable;
use Carbon\Carbon;
use Livewire\Component;
use App\Http\Traits\WithPagination;

class Index extends Component
{
    use WithPagination, Sortable,HasFiltersWithPagination;

    public $lastMonth = 3;
    public $search = '';
    public $filters = ["lastMonth"];
    protected $listeners = ['deleteItem' => 'delete'];


    public function delete($id)
    {

    }

    public function render()
    {
        return view('livewire.admin.bulletin-board.job-market.index',
            [
                "jobs" => \App\User::search($this->search)
                    ->where("created_at", ">=", Carbon::now()->subMonths($this->lastMonth))
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage),
            ]
        );
    }
}
