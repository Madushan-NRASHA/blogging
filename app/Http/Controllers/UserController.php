<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Automatically log in the user after registration
            Auth::login($user);

            return redirect()->route('login-form')->with('success', 'Registration successful! Welcome to your dashboard.');
        } catch (\Exception $e) {
            Log::error("User registration failed: " . $e->getMessage());
            return back()->with('error', 'Something went wrong during registration. Please try again.')->withInput();
        }
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('welcome');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (auth()->attempt($credentials)) {
            $user = auth()->user(); // Get the authenticated user
            return $this->redirectUserByType($user);
        }

        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    protected function redirectUserByType($user)
    {


        if ($user->type == '0') {
//            dd('uhyhh');
            return redirect()->route('BlogPage')->with('success', 'Welcome back!');
        } elseif ($user->type == '1') {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
        } else {
            return redirect()->route('BlogPage');
        }
    }

    /**
     * Show the dashboard.
     */
//    public function dashboard()
//    {
//        $posts=Post::all();
//        return view('admin.dashboard',compact('posts')); // Adjust the path to match your view
//    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('BlogPage')->with('success', 'You have been logged out successfully.');
    }
}
