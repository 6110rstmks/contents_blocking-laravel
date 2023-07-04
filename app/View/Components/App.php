<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{

    public $cnt;
    public $lists;
    public $export;
    public $import;
    /**
     * Create a new component instance.
     */
    public function __construct($cnt, $lists, $export, $import)
    {
        $this->cnt = $cnt;
        $this->lists = $lists;
        $this->export = $export;
        $this->import = $import;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.app');
    }
}
