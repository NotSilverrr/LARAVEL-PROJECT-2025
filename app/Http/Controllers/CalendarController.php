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
        
        if(isset($request->month)){
            $selected_month = $request->month;
        }

        return view('project_views.calendar', [
            'today' => $today,
            'months' => $months,
            'selected_month' => $selected_month,
        ]);
    }

    private function monthStartDay($month, $year) {
        return (int)date("w", mktime(0, 0, 0, $month, 1, $year));
    }
}
