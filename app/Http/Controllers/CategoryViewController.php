<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
class CategoryViewController extends Controller
{
    public function showByCategory(Request $request, $name)
{
    $name = str_replace('-', ' ', $name);
    $category = Category::where('name', $name)->firstOrFail();

    $servicesQuery = $category->services()->with('serviceProvider.user');

    if ($request->filled('search')) {
        $servicesQuery->whereHas('serviceProvider.user', function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
        });
    }

    $services = $servicesQuery->paginate(6)->withQueryString();

    
    $appointments = Appointment::whereIn('service_id', $services->pluck('id'))
        ->get(['service_id', 'date', 'time']);

    $bookedSlots = [];

    foreach ($appointments as $appointment) {
        $bookedSlots[$appointment->service_id][$appointment->date][] = $appointment->time;
    }

    
    return view('user.categories', compact('category', 'services', 'bookedSlots'));
}



    public function showDetails($id)
    {
        $provider = ServiceProvider::with(['user', 'services', 'reviews.user'])->findOrFail($id);

    return view('user.providerDetails', compact('provider'));
    }


    public function addAppointment(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'location' => 'required|string|max:255',
        ]);

        $alreadyBooked = Appointment::where('service_id', $request->service_id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()->with('error', 'This time slot is already booked. Please choose another.');
        }
        Appointment::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
        ]);


        return redirect()->route('appointments.show')
            ->with('success', 'Booked successfully. Check your appointments details below.');
    }

    public function myAppointments()
    {
        $appointments = Appointment::with('service')->where('user_id', Auth::id())->orderBy('date')->get();
        return view('user.appointments', compact('appointments'));
    }
}
