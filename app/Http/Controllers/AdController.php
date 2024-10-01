<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Ad;
use App\Models\Branch;
use App\Models\Image;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function index()
    {
        $brands = Ad::all();
        $userId = auth()->id();
        $ads = Ad::query()->withCount([
            'bookmarkedByUser as bookmark' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
            }
        ])->get();
        return view('ads.index', compact('ads', 'brands'));
    }
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $action = route('ads.store');
        $branches = Branch::all();
        $ads=Ad::all();
        $ad  = new Ad();
        return view('ads.create', compact('action', 'ads', 'branches', 'ad'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required | min:5',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            'title'=>['required'=>'Title ni kiritish majburiy'],
            'description'=>['required'=>'Izoh ni kiritish majburiy'],
        ]);

        $ad = Ad::query()->create([
           'title'=>$request->input('title'),
            'description'=>$request->input('description'),
            'user_id'=>auth()->id(),
            'image'=>$request->input('image'),
            'branch_id'=>$request->input('branch_id'),
            'statuses_id'=>Status::ACTIVE,
            'price'=>$request->input('price'),
            'rooms'=>$request->input('rooms'),
            'gender'=>$request->input('gender'),
        ]);

        if ($request->hasFile('image')) {
            $file = Storage::disk('public')->put('/',$request->image);

            Image::query()->create([
                'ad_id'=>$ad->id,
                'name'=>$file,
            ]);
        }
        return redirect(route('home'))->with('message', "E'lon Yaratildi");
    }

    public function show(string $id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $ad = Ad::with('branch')->find($id);
        return view('components.single-ad', ['ad'=>$ad]);
    }
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function find(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $searchPhrase = $request->input('searchPhrase');
        $branchId = $request->input('branch_id');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $ads = Ad::query();
        if ($searchPhrase) {
            $ads->where('title', 'LIKE', "%{$searchPhrase}%");
        }
        if ($branchId) {
            $ads->where('branches_id', $branchId);
        }
        if ($minPrice) {
            $ads->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $ads->where('price', '<=', $maxPrice);
        }
        $ads = $ads->with('branch')->get();
        $branches = Branch::all();
        return view('ads.index', compact('ads', 'branches'));
    }
    public function contact(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view("components.contact");
    }
}
