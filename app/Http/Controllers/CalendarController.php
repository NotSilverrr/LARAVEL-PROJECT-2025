<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
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

        return view('project_views.calendar', [
            'today' => $today,
            'months' => $months,
            'selected_month' => $selected_month,
            'selected_year' => $selected_year,
            'first_day_of_month' => $first_day_of_month,
        ]);
    }
    
    private function getFirstDayOfMonth($month, $year) {
        return (int)date('w', strtotime("{$year}-{$month}-01"))-1;
    }
}
