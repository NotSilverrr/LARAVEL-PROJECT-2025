<?php

namespace App\View\Components\Projects;

use App\Models\Column;
use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteColumnModal extends Component
{
    public Column $column;
    public Project $project;
    /**
     * Create a new component instance.
     */
    public function __construct($column, $project)
    {
        $this->project = $project;
        $this->column = $column;
    }
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.projects.delete-column-modal');
    }
}
