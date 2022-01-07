<?php

namespace App\Http\Controllers;

use App\Repositories\Dashboard\DashboardRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardRepo;
    protected $orderRepo;
    public function __construct(DashboardRepositoryInterface $dashboardRepo, OrderRepositoryInterface $orderRepo)
    {
        $this->middleware(['auth']);
        $this->dashboardRepo = $dashboardRepo;
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        switch (Auth::user()->role) {
            case 0:
                $orders = $this->orderRepo->latest(5);
                return view('admin.dashboard', compact('orders'));
                break;
            case 1:
                return view('employee.dashboard');
            default:
                die('Unauthorized');
                break;
        }
    }

    public function report(Request $request)
    {
        try{
            switch($request->option){
                case 'last_week':
                    $response = $this->dashboardRepo->getReportByWeek();
                    break;
                case 'this_month':
                    $response = $this->dashboardRepo->getReportByMonth(0);
                    break;
                case 'last_month':
                    $response = $this->dashboardRepo->getReportByMonth(1);
                    break;
                case 'two_month':
                    $response = $this->dashboardRepo->getReportByMonth(2);
                    break;
                case 'range':
                    $response = $this->dashboardRepo->getReportByRange($request->from, $request->to);
                    break;
                default:
                    abort(500);
                break;
            }
            return response()->json([
                'data' => $response
            ]);
        }
        catch(Exception $ex){
            throw $ex;
        }
    }
}
