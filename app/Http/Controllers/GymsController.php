<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ServiceProvider;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

use App\Models\Service;
use Carbon\Carbon;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 */

class GymsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $gymCategory = Category::where('name', 'Gyms')->first();

        $gyms = ServiceProvider::whereHas('services', function ($query) use ($gymCategory) {
            $query->where('category_id', $gymCategory->id);
        })
            ->whereHas('user', function ($query) use ($search) {
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%")
                            ->orWhere('location', 'like', "%$search%");
                    });
                }
            })
            ->with('user')
            ->paginate(6);

        return view('user.gyms.index', compact('gyms', 'search'));
    }



    public function show($id)
    {
        $gym = ServiceProvider::with('services.category')->findOrFail($id);

        return view('user.gyms.show', compact('gym'));
    }



    public function addSubscription(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'start_date' => 'required|date|after_or_equal:today',
        ]);

        $service = Service::findOrFail($request->service_id);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($service->duration_in_days);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->subscriptions()->create([
            'service_id' => $service->id,
            'status' => 'active',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'details' => 'Auto-created based on selected plan.',
        ]);

        return redirect()->route('subscriptions.show')
            ->with('success', 'Enrollment successful. Check your subscription details below.');
    }


    public function mySubscriptions()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $subscriptions = $user->subscriptions()->with('service')->latest()->get();

        return view('user.gyms.subscriptions', compact('subscriptions'));
    }
}
