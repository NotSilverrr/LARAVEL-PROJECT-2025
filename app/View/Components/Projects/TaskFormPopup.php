<?php

namespace App\View\Components\Projects;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TaskFormPopup extends Component
{
    public $project;
    public $categories;

    public function __construct($project, $categories)
    {
        $this->project = $project;
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.projects.task-form-popup');
    }
}
