<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        // dd($user);
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $user->update($request->only([
            'name',
            'email',
            'phone',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'postal_code',
            'country'
        ]));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }

    public function seller()
    {
        return view('profile.seller');
    }

    public function updateBusiness(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_description' => 'nullable|string',
            'business_phone' => 'nullable|string|max:30',
            'business_address' => 'nullable|string|max:255',
        ]);

        // Update business info (store in user meta or separate table)

        return back()->with('success', 'Business information updated successfully.');
    }

    public function addresses()
    {
        return view('profile.addresses');
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'boolean',
        ]);

        // Add address logic

        return back()->with('success', 'Address added successfully.');
    }

    public function updateAddress(Request $request, $addressId)
    {
        // Update address logic
        return back()->with('success', 'Address updated successfully.');
    }

    public function deleteAddress($addressId)
    {
        // Delete address logic
        return back()->with('success', 'Address deleted successfully.');
    }

    public function setDefaultAddress($addressId)
    {
        // Set default address logic
        return back()->with('success', 'Default address updated successfully.');
    }
}
