<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $users = User::where('is_admin', false)
            ->withCount(['orders as paid_orders_count' => fn ($o) => $o->where('status', 'paid')])
            ->when($q !== '', fn ($u) => $u->where(fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%")->orWhere('phone', 'like', "%{$q}%")))
            ->latest()->paginate(40)->withQueryString();

        return view('admin.users', ['users' => $users, 'q' => $q]);
    }
}
