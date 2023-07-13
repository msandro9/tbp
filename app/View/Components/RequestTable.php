<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RequestTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $title = '',
                                public array $requests = [],
                                public bool $showUser = false,
                                public bool $finished = true
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.request-table');
    }
}
