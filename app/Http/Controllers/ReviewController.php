<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Appointment;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'provider_id' => 'required|exists:service_providers,id',
        'stars' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    $user = Auth::user();

    // Ensure user booked with this provider
    $hasBooked = Appointment::where('user_id', $user->id)
        ->whereHas('service.serviceProvider', function ($query) use ($request) {
            $query->where('id', $request->provider_id);
        })->exists();

    if (!$hasBooked) {
        return redirect()->back()->with('error', 'You can only review providers you have booked.');
    }

    Review::create([
        'user_id' => $user->id,
        'provider_id' => $request->provider_id,
        'stars' => $request->stars,
        'comment' => $request->comment,
    ]);

    return redirect()->back()->with('success', 'Review submitted successfully.');
}

public function destroy(Review $review)
{
    // Only allow owner to delete their review
    if (auth()->id() !== $review->user_id) {
        abort(403, 'Unauthorized action.');
    }

    $review->delete();

    return redirect()->back()->with('success', 'Review deleted successfully.');
}

}
