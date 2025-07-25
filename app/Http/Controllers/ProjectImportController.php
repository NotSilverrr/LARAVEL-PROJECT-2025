<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\Project;

class ProjectImportController extends Controller
{
    public function show(Project $project)
    {
        return view('projects.import', compact('project'));
    }

    public function import(\App\Http\Requests\ImportProjectRequest $request, Project $project)
    {
        // Les données sont déjà validées

        $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $headers = array_map('strtolower', array_map('trim', array_values(array_shift($rows))));

        $firstColumn = $project->columns()->orderBy('id')->first();
        $firstColumnId = $firstColumn ? $firstColumn->id : null;

        foreach ($rows as $row) {
            $taskData = array_combine($headers, array_values($row));
            if (empty($taskData['priority']) || empty($taskData['title'])) {
                continue;
            }
            \App\Models\Task::create([
                'title' => $taskData['title'] ?? '',
                'description' => $taskData['description'] ?? null,
                'priority' => $taskData['priority'] ?? null,
                'finished_at' => $taskData['finished_at'] ?? null,
                'date_start' => $taskData['date_start'] ?? null,
                'date_end' => $taskData['date_end'] ?? null,
                'created_by' => $taskData['created_by'] ?? null,
                'project_id' => $project->id,
                'column_id' => $firstColumnId,
                'category_id' => $taskData['category_id'] ?? null,
                'status' => $taskData['status'] ?? null,
            ]);
        }

        return redirect()->route('projects.view.kanban', $project)->with('success', 'Importation réussie !');
    }
}
