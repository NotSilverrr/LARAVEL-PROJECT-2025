<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's projects
        $userProjects = $user->projects()->pluck('id');
        
        // Basic statistics
        $stats = [
            'total_projects' => $user->projects()->count(),
            'active_tasks' => Task::whereIn('project_id', $userProjects)
                ->where('status', '!=', 'done')
                ->count(),
            'pending_tasks' => Task::whereIn('project_id', $userProjects)
                ->where('status', 'in_progress')
                ->count(),
            'completed_tasks' => Task::whereIn('project_id', $userProjects)
                ->where('status', 'done')
                ->count(),
        ];

        // Chart data
        $chartData = [
            'tasks_by_status' => $this->getTasksByStatus($userProjects),
            'projects_labels' => $this->getProjectsLabels($userProjects),
            'projects_progress' => $this->getProjectsProgress($userProjects),
            'timeline_labels' => $this->getTimelineLabels(),
            'timeline_data' => $this->getTimelineData($userProjects),
        ];

        return view('dashboard', compact('stats', 'chartData'));
    }

    private function getTasksByStatus($projectIds)
    {
        $tasks = Task::whereIn('project_id', $projectIds)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        return [
            'todo' => $tasks->get('pending', 0) + $tasks->get('todo', 0),
            'in_progress' => $tasks->get('in_progress', 0),
            'done' => $tasks->get('completed', 0) + $tasks->get('done', 0),
        ];
    }

    private function getProjectsLabels($projectIds)
    {
        return Project::whereIn('id', $projectIds)
            ->limit(10)
            ->pluck('name')
            ->toArray();
    }

    private function getProjectsProgress($projectIds)
    {
        $projects = Project::whereIn('id', $projectIds)
            ->limit(10)
            ->get();

        $progress = [];
        foreach ($projects as $project) {
            $totalTasks = $project->tasks()->count();
            $completedTasks = $project->tasks()->where('status', 'completed')->count();
            
            if ($totalTasks > 0) {
                $progress[] = round(($completedTasks / $totalTasks) * 100, 1);
            } else {
                $progress[] = 0;
            }
        }

        return $progress;
    }

    private function getTimelineLabels()
    {
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subDays($i)->format('M j');
        }
        return $labels;
    }

    private function getTimelineData($projectIds)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->startOfDay();
            $count = Task::whereIn('project_id', $projectIds)
                ->whereDate('created_at', $date)
                ->count();
            $data[] = $count;
        }
        return $data;
    }
}
