<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Category;

class ProjectViewController extends Controller
{
    public function kanban(Project $project)
    {
        // Tu peux charger ici les colonnes et tâches si besoin
        $columns = $project->columns()->with(['tasks' => function($q) use ($project) {
            $q->visibleForUser(auth()->user(), $project->id);
        }])->get();
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

        $selected_day = $today["day"];
        if (isset($request->day)) {
            $selected_day = (int)$request->day;
        }

        $selected_month = $today["month"];
        $selected_year = $today["year"];
        if (isset($request->month)) {
            $selected_month = $request->month;
        }
        if (isset($request->year)) {
            $selected_year = $request->year;
        }

        $selectedDate = new \DateTime("{$selected_year}-{$selected_month}-{$selected_day}");
        $selected_week = (int)$selectedDate->format("W");
        
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

        $tasks = \App\Models\Task::visibleForUser(auth()->user(), $project->id)->get();
        $categories = $project->categories()->get();

        return view('projects.views.calendar', [
            'today' => $today,
            'months' => $months,
            'selected_day' => $selected_day,
            'selected_week' => $selected_week,
            'selected_month' => $selected_month,
            'selected_year' => $selected_year,
            'first_day_of_month' => $first_day_of_month,
            'project' => $project,
            'tasks' => $tasks,
            'categories' => $categories,
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

    public function week(Request $request, Project $project)
    {
        $today = [
            "year" => (int)date("Y"),
            "month" => (int)date("m"),
            "day" => (int)date("d"),
        ];

        $selected_year = $today["year"];
        $selected_week = (int)date("W");
        if (isset($request->year)) {
            $selected_year = (int)$request->year;
        }
        if (isset($request->week)) {
            $selected_week = (int)$request->week;
        }

        $prevWeek = $selected_week - 1;
        $prevYear = $selected_year;
        $nextWeek = $selected_week + 1;
        $nextYear = $selected_year;
        $weeksInYear = (int) (new \DateTime("{$selected_year}-12-28"))->format("W");
        if ($prevWeek < 1) {
            $prevYear--;
            $prevWeek = (int) (new \DateTime("{$prevYear}-12-28"))->format("W");
        }
        if ($nextWeek > $weeksInYear) {
            $nextWeek = 1;
            $nextYear++;
        }

        $tasks = \App\Models\Task::visibleForUser(auth()->user(), $project->id)->get();
        $categories = $project->categories()->get();

        return view('projects.views.week', [
            'today' => $today,
            'selected_week' => $selected_week,
            'selected_year' => $selected_year,
            'project' => $project,
            'tasks' => $tasks,
            'categories' => $categories,
            'prevWeek' => $prevWeek,
            'prevWeekYear' => $prevYear,
            'nextWeek' => $nextWeek,
            'nextWeekYear' => $nextYear,
        ]);
    }

    public function three_days(Request $request, Project $project)
    {
        $today = [
            "year" => (int)date("Y"),
            "month" => (int)date("m"),
            "day" => (int)date("d"),
        ];

        $selected_year = $today["year"];
        $selected_month = $today["month"];
        $selected_day = $today["day"];

        if ($request->has('year')) {
            $selected_year = (int)$request->year;
        }
        if ($request->has('month')) {
            $selected_month = (int)$request->month;
        }
        if ($request->has('day')) {
            $selected_day = (int)$request->day;
        }

        $centerDate = new \DateTime();
        $centerDate->setDate($selected_year, $selected_month, $selected_day);
        $centerDate->setTime(0, 0, 0);

        $dates = [
            (clone $centerDate)->modify('-1 day'),
            (clone $centerDate),
            (clone $centerDate)->modify('+1 day'),
        ];

        $prevPeriod = (clone $centerDate)->modify('-2 days');
        $nextPeriod = (clone $centerDate)->modify('+2 days');

        $tasks = \App\Models\Task::visibleForUser(auth()->user(), $project->id)->get();
        $categories = $project->categories()->get();

        return view('projects.views.three_days', [
            'today' => $today,
            'selected_year' => $selected_year,
            'selected_month' => $selected_month,
            'selected_day' => $selected_day,
            'project' => $project,
            'tasks' => $tasks,
            'categories' => $categories,
            'dates' => $dates,
            'prevPeriodDay' => (int)$prevPeriod->format('d'),
            'prevPeriodMonth' => (int)$prevPeriod->format('m'),
            'prevPeriodYear' => (int)$prevPeriod->format('Y'),
            'nextPeriodDay' => (int)$nextPeriod->format('d'),
            'nextPeriodMonth' => (int)$nextPeriod->format('m'),
            'nextPeriodYear' => (int)$nextPeriod->format('Y'),
        ]);
    }

    public function day(Request $request, Project $project)
    {
        $today = [
            "year" => (int)date("Y"),
            "month" => (int)date("m"),
            "day" => (int)date("d"),
        ];

        $selected_year = $today["year"];
        $selected_month = $today["month"];
        $selected_day = $today["day"];

        if ($request->has('year')) {
            $selected_year = (int)$request->year;
        }
        if ($request->has('month')) {
            $selected_month = (int)$request->month;
        }
        if ($request->has('day')) {
            $selected_day = (int)$request->day;
        }

        $currentDate = new \DateTime();
        $currentDate->setDate($selected_year, $selected_month, $selected_day);
        $currentDate->setTime(0, 0, 0);
        $prevDate = (clone $currentDate)->modify('-1 day');
        $nextDate = (clone $currentDate)->modify('+1 day');

        $tasks = \App\Models\Task::visibleForUser(auth()->user(), $project->id)->get();
        $categories = $project->categories()->get();

        return view('projects.views.day', [
            'today' => $today,
            'selected_year' => $selected_year,
            'selected_month' => $selected_month,
            'selected_day' => $selected_day,
            'project' => $project,
            'tasks' => $tasks,
            'categories' => $categories,
            'prevDay' => (int)$prevDate->format('d'),
            'prevDayMonth' => (int)$prevDate->format('m'),
            'prevDayYear' => (int)$prevDate->format('Y'),
            'nextDay' => (int)$nextDate->format('d'),
            'nextDayMonth' => (int)$nextDate->format('m'),
            'nextDayYear' => (int)$nextDate->format('Y'),
        ]);
    }

    private function getFirstDayOfMonth($month, $year) {
        $day = (int)date('w', strtotime("{$year}-{$month}-01")) - 1;
        return $day == -1 ? 6 : $day;
    }
}