<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            // Get the authenticated user
            $user = Auth::user();

            // Set user ID in session
            session(['id' => $user->id]);
            session(['name' => $user->name]);
            
            // Redirect to dashboard or desired route
            return redirect()->route('/polls');
        } else {
            // Authentication failed
            return back()->with('error', 'Invalid credentials');
        }
    }

    function signup_view(){

        return view('signup');
    }
    
    function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:20|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'is_voted' => 0,
            'password' => Hash::make($validatedData['password']), // Hash the password
        ]);
        return redirect()->route('login')->with('success', 'Account created successfully!');
    }
    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();
        
        // Regenerate the CSRF token (optional but recommended for security)
        $request->session()->regenerateToken();
        return redirect('/');
    } 
}
