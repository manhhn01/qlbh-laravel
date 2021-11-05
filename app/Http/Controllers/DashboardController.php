<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        switch (Auth::user()->role) {
            case 0:
                return view('admin.dashboard');
                break;
            case 1:
                return view('employee.dashboard');
            default:
                die('Unauthorized');
                break;
        }
    }
}
