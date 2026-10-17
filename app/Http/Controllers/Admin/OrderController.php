<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('statut', Order::PENDING);
        $q = trim((string) $request->query('q', ''));
        $orders = Order::with(['user', 'items'])
            ->when(array_key_exists($status, Order::STATUS_LABELS), fn ($o) => $o->where('status', $status))
            ->when($q !== '', fn ($o) => $o->where(fn ($w) => $w->where('reference', 'like', "%{$q}%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%")->orWhere('phone', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"))))
            ->latest()->paginate(30)->withQueryString();

        return view('admin.orders.index', ['orders' => $orders, 'status' => $status, 'q' => $q]);
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.course']);

        return view('admin.orders.show', ['order' => $order, 'delivery' => $this->deliveryLink($order)]);
    }

    public function markPaid(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate(['payment_method' => ['required', Rule::in(Order::PAYMENT_METHODS)]]);
        $order->update(['status' => Order::PAID, 'payment_method' => $data['payment_method'], 'paid_at' => now()]);

        return redirect()->route('admin.orders.show', $order)->with('status', 'Paiement validé : le client voit maintenant ses formations dans « Mon compte ». Envoyez-lui le message de livraison.');
    }

    public function cancel(Order $order): RedirectResponse
    {
        $order->update(['status' => Order::CANCELLED]);

        return redirect()->route('admin.orders.show', $order)->with('status', 'Commande annulée.');
    }

    /** Message WhatsApp de livraison, avec les liens Drive, prêt à envoyer au client. */
    private function deliveryLink(Order $order): ?string
    {
        if (! $order->user?->phone || $order->status !== Order::PAID) {
            return null;
        }
        $lines = $order->items->map(fn ($i) => "📘 {$i->course_code} – {$i->course_title}\n".($i->course?->drive_url ?: '(lien à venir)'))->implode("\n\n");
        $text = 'Bonjour '.$order->user->name.', merci pour votre paiement ! Voici vos formations '.setting('brand')." (commande {$order->reference}) :\n\n"
            .$lines
            ."\n\nVous les retrouvez aussi à tout moment dans « Mon compte » sur notre site : ".route('account.dashboard')
            ."\nBonne formation !";

        return wa_link($order->user->phone, $text);
    }
}
