<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;


class ContactController extends Controller
{
    // Prikaz kontakt stranice sa mapom i formom
    public function show()
    {
        // Možeš ovde poslati neke kontakt podatke ako želiš
        $contactData = [
            'phone' => '+381 65 123 4567',
            'email' => 'misterwang@gmail.com',
            'address' => 'Borska 45i',
        ];

        // Uzmi sve recenzije da ih prikažeš ako želiš (nije obavezno)
        $reviews = Review::latest()->take(5)->get();

        return view('contact.contact', compact('contactData', 'reviews'));
    }

    // Čuvanje recenzije poslata kroz formu
    public function submitReview(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('message'),
        ]);

        return redirect()->back()->with('success', 'Hvala na recenziji!');
    }   
}
