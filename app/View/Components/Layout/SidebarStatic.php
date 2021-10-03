<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class SidebarStatic extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $links
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Closure|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.layout.sidebar-static');
    }
}
