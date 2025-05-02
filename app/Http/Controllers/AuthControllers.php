<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Facades\Activity;
use Illuminate\Support\Str;


class AuthControllers extends Controller // Perbaiki nama kelas (Controllers -> Controller)
{
    public function dashboard()
    {
        $articles = Article::latest()->take(5)->paginate(5);

        // / Contoh query untuk mendapatkan resep yang sudah dibeli



        $recipes = Recipe::with('category')->latest()->paginate(9);
        $categories = Category::all();
        return view('main.index', [
            'articles' => $articles,
            'recipes' => $recipes,
            'categories' => $categories
        ]);
    }
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showAdminLoginForm()
    {
        return view('admin.Auth.login');
    }

    // Menampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request)
{
    // Implement throttling to prevent brute force attacks
    $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        $seconds = RateLimiter::availableIn($throttleKey);

        return redirect()->route('user.login.form')
            ->withErrors(['email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik."])
            ->withInput();
    }

    // Get validated data (already validated by LoginRequest)
    $credentials = $request->only('email', 'password');

    // Attempt authentication
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        // Reset rate limiter on successful login
        RateLimiter::clear($throttleKey);

        // Regenerate session for security
        $request->session()->regenerate();

        // Strict role checking
        if (Auth::user()->role === 'user') {
            // Log successful login
            Log::info('User logged in successfully: ' . Auth::user()->email);

            return redirect()->route('home')
                ->with('success', 'Login berhasil!');
        }

        // Logout if not a user role
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login.form')
            ->withErrors(['email' => 'Akun admin tidak dapat login di halaman user'])
            ->withInput();
    }

    // Increment rate limiter on failed login
    RateLimiter::hit($throttleKey, 60 * 5); // 5 minutes timeout

    // Handle failed login
    return redirect()->route('user.login.form')
        ->withErrors(['email' => 'Email atau password salah.'])
        ->withInput();
}

    public function loginAdmin(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Mencoba autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek role terlebih dahulu
            if ($user->role !== 'admin') {
                // Logout user dan tampilkan pesan error
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')->withErrors([
                    'role' => 'Only admins can use this login form. Please use the user login.',
                ])->withInput($request->except('password'));
            }

            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome to the Admin Dashboard, ' . $user->name . '!');
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }



    public function register(RegisterRequest $request)
{
    try {
        // Data already validated through RegisterRequest

        // Create a new user
        $user = new User();
        $user->name = trim($request->first_name . ' ' . $request->last_name);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'user'; // Set default role as 'user'
        $user->save();

        // Log successful registration
        Log::info('User registered successfully: ' . $user->email);

        // Automatically log in the user
        Auth::login($user);

        // Regenerate session for security
        $request->session()->regenerate();

        // Redirect to user profile page after successful registration and login
        return redirect()->route('user.user-p')
            ->with('success', 'Akun berhasil dibuat dan Anda telah masuk.');
    } catch (\Throwable $th) {
        // Log the error
        Log::error('Registration error: ' . $th->getMessage());

        // Handle errors and display error message
        return redirect()->route('user.register.form')
            ->withErrors(['message' => 'Terjadi kesalahan: ' . $th->getMessage()])
            ->withInput();
    }
}

    public function logout(Request $request)
    {
        // Simpan informasi role sebelum logout
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';

        // Proses logout pengguna
        Auth::logout();

        // Invalidasi sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect berdasarkan role sebelum logout
        if ($isAdmin) {
            return redirect()->route('admin.login')
                ->with('message', 'Anda telah berhasil logout');
        }

        return redirect()->route('home')
            ->with('message', 'Anda telah berhasil logout');
    }

    
}
