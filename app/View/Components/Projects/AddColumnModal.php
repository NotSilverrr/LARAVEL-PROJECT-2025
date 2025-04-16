<?php

namespace App\View\Components\Projects;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddColumnModal extends Component
{
    public $project;
    /**
     * Create a new component instance.
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.projects.add-column-modal');
    }
}
