<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;


class ProjectViewController extends Controller
{
    public function list(Project $project)
    {
        $tasks = $project->tasks()->with('column', 'category', 'creator', 'groups', 'users')->get();
        //($tasks);
        $categories = $project->categories()->get();

        return view('projects.views.list', compact('project', 'tasks', 'categories'));
    }

    public function kanban(Project $project)
    {
        // Tu peux charger ici les colonnes et tâches si besoin
        $columns = $project->columns()->with('tasks')->get();
        $categories = $project->categories()->get();

        // dd($columns, $categories); // Pour déboguer et voir les données

        return view('projects.views.kanban', compact('project', 'columns', 'categories'));
    }

    public function calendar(Request $request, Project $project)
    {
        $months = [
            ["name"=>"January","days"=>31],
            ["name"=>"February","days"=>28],
            ["name"=>"March","days"=>31],
            ["name"=>"April","days"=>30],
            ["name"=>"May","days"=>31],
            ["name"=>"June","days"=>30],
            ["name"=>"July","days"=>31],
            ["name"=>"August","days"=>31],
            ["name"=>"September","days"=>30],
            ["name"=>"October","days"=>31],
            ["name"=>"November","days"=>30],
            ["name"=>"December","days"=>31],
        ];
        $today = [
            "year" => (int)date("Y"),
            "month" => (int)date("m"),
            "day" => (int)date("d"),
        ];

        $selected_month = $today["month"];
        $selected_year = $today["year"];
        
        if(isset($request->month)){
            $selected_month = $request->month;
        }
        
        if(isset($request->year)){
            $selected_year = $request->year;
        }
        
        if($selected_year % 4 == 0 && ($selected_year % 100 != 0 || $selected_year % 400 == 0)){
            $months[1]["days"] = 29;
        }

        $first_day_of_month = $this->getFirstDayOfMonth($selected_month, $selected_year);
        $totalDays = $months[$selected_month-1]['days'];
        $monthName = $months[$selected_month-1]['name'];
        $prevMonth = $selected_month - 1;
        $prevYear = $selected_year;
        if ($prevMonth < 1) {
            $prevMonth = 12;
            $prevYear--;
        }
        $nextMonth = $selected_month + 1;
        $nextYear = $selected_year;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }
        $totalCells = $totalDays + $first_day_of_month;
        $totalWeeks = ceil($totalCells / 7);

        $tasks = $project->tasks()->get();

        return view('projects.views.calendar', [
            'today' => $today,
            'months' => $months,
            'selected_month' => $selected_month,
            'selected_year' => $selected_year,
            'first_day_of_month' => $first_day_of_month,
            'project' => $project,
            'tasks' => $tasks,
            'totalDays' => $totalDays,
            'monthName' => $monthName,
            'prevMonth' => $prevMonth,
            'prevYear' => $prevYear,
            'nextMonth' => $nextMonth,
            'nextYear' => $nextYear,
            'totalCells' => $totalCells,
            'totalWeeks' => $totalWeeks,
        ]);
    }

    private function getFirstDayOfMonth($month, $year) {
        return (int)date('w', strtotime("{$year}-{$month}-01")) - 1;
    }
}
