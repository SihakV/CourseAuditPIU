<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index()
    {
        $logs = Activity::latest()->get();

        return view('logs.index', [
            'logs' => $logs
        ]);
    }
}
