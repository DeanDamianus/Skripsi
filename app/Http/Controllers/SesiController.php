<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SesiController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email tidak boleh kosong.',
                'password.required' => 'Password tidak boleh kosong.',
            ],
        );

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            switch ($user->role) {
                case 'operator':
                    return redirect('/owner');
                case 'petani':
                    return redirect('/petani');
                default:
                    Auth::logout();
                    return redirect('/')->withErrors('Unauthorized role');
            }
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function register()
    {
        return view('register');
    }

    public function create(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:operator,petani',
        ]);

        // Create a new user
        User::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
        ]);

        // Redirect to login with a success message
        return redirect('/owner')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'biaya_jual' => 'required|numeric',
            'naik_turun' => 'required|numeric',
        ]);

        // Update the record
        $id = $request->input('id');
        $biaya_jual = $request->input('biaya_jual');
        $naik_turun = $request->input('naik_turun');

        // Perform update
        DB::table('parameter_2024')
            ->where('id', $id)
            ->update([
                'biaya_jual' => $biaya_jual,
                'naik_turun' => $naik_turun,
            ]);

        return redirect()->back()->with('message', 'Record updated successfully!');
    }
    public function input(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'netto' => 'required|numeric',
            'harga' => 'required|numeric',
            'berat_gudang' => 'required|numeric',
            'grade' => 'required|string|max:255',
            'id_petani' => 'required|integer',
        ]);

        // Insert the data into the rekap_2024 table
        DB::table('rekap_2024')->insert([
            'id_petani' => $validated['id_petani'],
            'netto' => $validated['netto'],
            'harga' => $validated['harga'],
            'berat_gudang' => $validated['berat_gudang'],
            'grade' => $validated['grade'],
        ]);

        // Redirect or return a response
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }
    
}
