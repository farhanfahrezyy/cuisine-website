<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Validator;

class UserPreferenceController extends Controller
{
    public function store(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('user.login.form')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat detail resep');
        }



        $validator = Validator::make($request->all(), [
            'country' => 'required|array|max:3',
            'primary_ingredient' => 'required|array|max:3',
            'secondary_ingredient' => 'required|array|max:3',
            'spiciness' => 'required|string', // Single value since it's a radio button
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $userPreference = new UserPreference();
            $userPreference->users = Auth::id(); // Assuming you're using authentication
            $userPreference->country = json_encode($request->country);
            $userPreference->primary_ingredient = json_encode($request->primary_ingredient);
            $userPreference->secondary_ingredient = json_encode($request->secondary_ingredient);
            $userPreference->spiciness = json_encode([$request->spiciness]); // Wrap in array for consistency
            $userPreference->save();

            // Return JSON response for AJAX handling


            return redirect()->route('home')->with('status', 'Preferences saved successfully!');
        } catch (\Throwable $th) {
            return back()->withErrors([
                'message' => 'An error occurred: ' . $th->getMessage(),
            ])->withInput();
        }
    }
}
