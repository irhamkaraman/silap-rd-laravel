<?php

namespace App\Http\Controllers;

use App\Actions\StoreComplaintAction;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\TrackComplaintRequest;
use App\Models\Category;
use App\Models\Complaint;
use Illuminate\View\View;

class GuestComplaintController extends Controller
{
    public function create(): View
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('complaints.create', compact('categories'));
    }

    public function store(StoreComplaintRequest $request, StoreComplaintAction $action): View
    {
        $complaint = $action->execute($request);

        return view('complaints.create', [
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'trackingCode' => $complaint->tracking_code,
        ]);
    }

    public function track(): View
    {
        return view('complaints.track');
    }

    public function show(TrackComplaintRequest $request): View
    {
        $complaint = Complaint::with([
            'category',
            'responses.user',
        ])
            ->where('tracking_code', $request->input('tracking_code'))
            ->first();

        return view('complaints.track', compact('complaint'));
    }
}
