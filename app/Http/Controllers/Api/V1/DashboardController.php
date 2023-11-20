<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Evaluatee;

// use Illuminate\Support\Collection;
// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalUsers = User::count();
        $totalEvaluatees = Evaluatee::count();

        $collections = collect(['total_users' => $totalUsers, 'total_evaluatees' => $totalEvaluatees]);
        return response()->json($collections);
    }

    public function user()
    {
        return response()->json(['test'=> 'user'],200);
    }
}
