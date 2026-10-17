<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'pending' => Order::where('status', Order::PENDING)->with('user')->latest()->take(8)->get(),
            'stats' => [
                'pending' => Order::where('status', Order::PENDING)->count(),
                'revenue_month' => Order::where('status', Order::PAID)->where('paid_at', '>=', now()->startOfMonth())->sum('total'),
                'clients' => User::where('is_admin', false)->count(),
                'courses' => Course::count(),
                'missing_links' => Course::whereNull('drive_url')->count(),
            ],
        ]);
    }
}
