<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->page === 'buy') {
            $items = Item::with('order')
                ->whereHas('order', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();
        } else {
            $items = Item::with('order')
                ->where('user_id', $user->id)
                ->get();
        }

        return view('mypage.index', compact('user', 'items'));
    }
}