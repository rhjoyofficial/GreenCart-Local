@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
    <div class="space-y-6">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <i class="fas fa-envelope text-green-600 text-xl"></i>
            </div>
            <h2 class="mt-4 text-2xl font-bold text-gray-900">Verify Your Email</h2>
            <p class="mt-2 text-sm text-gray-600">
                @if (session('resent'))
                    A fresh verification link has been sent to your email address.
                @else
                    Thanks for signing up! Before getting started, please verify your email address by clicking on the link
                    we just emailed to you.
                @endif
            </p>
        </div>

        <div class="text-center space-y-4">
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Sign Out
                </button>
            </form>
        </div>
    </div>
@endsection
