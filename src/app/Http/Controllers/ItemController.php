<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        if ($request->page === 'mylist') {
            if (!Auth::check()) {
                $items = collect();
            } else {
                $items = Item::with(['order', 'likes'])
                    ->whereHas('likes', function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->when($keyword, function ($query, $keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->get();
            }
        } else {
            $items = Item::with(['order', 'likes'])
                ->when($keyword, function ($query, $keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->get();
        }

        return view('items.index', compact('items'));
    }

    public function show($item_id)
    {
        $item = Item::with(['user', 'condition', 'categories', 'comments.user', 'likes'])
            ->findOrFail($item_id);

        return view('items.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $imagePath = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'user_id' => Auth::id(),
            'condition_id' => $request->condition_id,
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        $item->categories()->attach($request->categories);

        return redirect('/');
    }
}