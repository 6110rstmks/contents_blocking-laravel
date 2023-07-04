<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{

    public $cnt;
    public $lists;
    public $export_route;
    public $import_route;
    /**
     * Create a new component instance.
     */
    public function __construct($cnt, $lists, $export_route, $import_route)
    {
        $this->cnt = $cnt;
        // $this->lists = $lists;
        // $this->export_route = $export_route;
        // $this->import_route = $import_route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.app');
    }
}
