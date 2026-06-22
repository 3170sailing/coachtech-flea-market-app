<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item = Item::findOrFail($item_id);
        $profile = Auth::user()->profile;
        $purchaseAddress = session('purchase_address_' . $item_id);

        return view('purchase.index', compact('item', 'profile', 'purchaseAddress'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $address = session('purchase_address_' . $item_id);

        if (!$address) {
            $profile = Auth::user()->profile;

            $address = [
                'postal_code' => $profile->postal_code ?? '',
                'address' => $profile->address ?? '',
                'building' => $profile->building ?? '',
            ];
        }

        session([
            'order_data_' . $item_id => [
                'user_id' => Auth::id(),
                'item_id' => $item_id,
                'postal_code' => $address['postal_code'],
                'address' => $address['address'],
                'building' => $address['building'],
                'payment_method' => $request->payment_method,
            ],
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = Session::create([
            'payment_method_types' => [
                $request->payment_method,
            ],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/purchase/success/' . $item->id),
            'cancel_url' => url('/purchase/' . $item->id),
        ]);

        return redirect($checkoutSession->url);
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $purchaseAddress = session('purchase_address_' . $item_id);

        return view('purchase.address', compact('item', 'purchaseAddress'));
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        session([
            'purchase_address_' . $item_id => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ],
        ]);

        return redirect('/purchase/' . $item_id);
    }

    public function success($item_id)
    {
        $orderData = session('order_data_' . $item_id);

        if ($orderData) {
            Order::create($orderData);

            session()->forget('order_data_' . $item_id);
            session()->forget('purchase_address_' . $item_id);
        }

        return redirect('/');
    }
}