<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $courses = Course::published()->whereIn('id', session('cart', []))->get()
            ->reject(fn (Course $c) => $user->owns($c));

        if ($courses->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Votre sélection est vide.');
        }

        $order = DB::transaction(function () use ($user, $courses) {
            $order = Order::create([
                'user_id' => $user->id,
                'reference' => Order::newReference(),
                'total' => $courses->sum('price'),
                'status' => Order::PENDING,
            ]);
            foreach ($courses as $course) {
                $order->items()->create([
                    'course_id' => $course->id,
                    'course_code' => $course->code,
                    'course_title' => $course->title,
                    'price' => $course->price,
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('orders.show', $order);
    }

    public function show(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 404);
        $order->load('items');

        $message = 'Bonjour '.setting('brand').", je viens de passer la commande {$order->reference} :\n"
            .$order->items->map(fn ($i) => "- {$i->course_code} {$i->course_title} (".gnf($i->price).')')->implode("\n")
            ."\nTotal : ".gnf($order->total)."\nComment je paie ?";

        return view('orders.show', ['order' => $order, 'whatsapp' => wa_link(setting('whatsapp'), $message)]);
    }
}
