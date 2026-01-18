<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $isSeller = $request->input('role') === 'seller';
        $request->validate([
            'role' => ['required', 'in:customer,seller'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            'business_name' => ['exclude_unless:role,seller', 'required', 'string', 'max:100'],
            'phone'         => ['exclude_unless:role,seller', 'required', 'string', 'max:30'],
        ]);


        // Resolve role ID via model
        $role = Role::where('name', $request->role)->firstOrFail();

        $user = User::create([
            'role_id' => $role->id,
            'name' => $request->name,
            'business_name' => $request->role === 'seller' ? $request->business_name : null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return $isSeller
            ? redirect(route('seller.dashboard'))
            : redirect(route('home'));
    }
}
