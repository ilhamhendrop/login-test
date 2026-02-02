<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.index');
    }

    public function dashboardData() {
        return response()->json([
            'user' => Auth::user()
        ], Response::HTTP_OK);
    }
}
