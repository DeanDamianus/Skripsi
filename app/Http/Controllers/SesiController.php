<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Rekap2024;
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
        'jual_luar_value' => 'nullable|in:0,1',
        'harga' => 'required|numeric',
        'berat_gudang' => 'required|numeric',
        'grade' => 'nullable|string',  // Nullable fields
        'periode' => 'nullable|string',
        'seri' => 'nullable|string',
        'no_gg' => 'nullable|numeric',
        'id_petani' => 'required|integer',
    ]);

    $id_petani = $validated['id_petani'];
    $jual_luar = $validated['jual_luar_value'] === '1';

    // Prepare the data for insertion, use null if fields are missing
    $data = [
        'id_petani' => $id_petani,
        'netto' => $validated['netto'],
        'jual_luar' => $jual_luar,
        'harga' => $validated['harga'],
        'berat_gudang' => $validated['berat_gudang'],
        'grade' => $validated['grade'] ?? null, // Check for nullable fields
        'periode' => $validated['periode'] ?? null,
        'seri' => $validated['seri'] ?? null,
        'no_gg' => $validated['no_gg'] ?? null,
    ];

    // Insert the data into the rekap_2024 table
    DB::table('rekap_2024')->insert($data);

    // Redirect to the specified route with the 'id' parameter
    return redirect()
            ->to('http://127.0.0.1:8000/dataInput?id=' . urlencode($id_petani))
            ->with('success', 'Data successfully updated!');
}



    public function update(Request $request)
    {
        // Validate the data
        $request->validate([
            'netto' => 'required|numeric',
            'jual_luar' => 'nullable|in:0,1',
            'harga' => 'required|numeric',
            'berat_gudang' => 'required|numeric',
            'grade' => 'required|string',
            'periode' => 'required|string',
            'seri' => 'required|string',
            'no_gg' => 'required|numeric',
            'id_petani' => 'required|integer',
        ]);

        // Fetch the current id_rekap from the request
        $id_rekap = $request->input('id_rekap');
        $id_petani = $request->input('id_petani');
        $jual_luar = $request->input('jual_luar_value') === '1';

        // Find the existing rekap_2024 entry by id_rekap
        $rekap = DB::table('rekap_2024')->where('id_rekap', $id_rekap)->first();

        if (!$rekap) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        // Update the rekap_2024 entry
        DB::table('rekap_2024')
            ->where('id_rekap', $id_rekap)
            ->update([
                'netto' => $request->input('netto'),
                'jual_luar' => $jual_luar,
                'harga' => $request->input('harga'),
                'berat_gudang' => $request->input('berat_gudang'),
                'grade' => $request->input('grade'),
                'periode' => $request->input('periode'),
                'seri' => $request->input('seri'),
                'no_gg' => $request->input('no_gg'),
            ]);
        return redirect()
            ->to('http://127.0.0.1:8000/dataInput?id=' . urlencode($id_petani))
            ->with('success', 'Data successfully updated!');
    }

    public function hutangLunas(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric', // Assuming this is some kind of identifier or primary key
            'id_petani' => 'required|exists:users,id',
            'tanggal_hutang' => 'required|date',
            'bon' => 'required|numeric',
            'cicilan' => 'required|numeric',
            'tanggal_lunas' => 'nullable|date',
        ]);
    
        // Check if there is an existing record with the same id_petani and a non-null tanggal_lunas
        $existingRecord = DB::table('hutang_2024')
            ->where('id_petani', $request->input('id_petani'))
            ->whereNotNull('tanggal_lunas')
            ->first();
    
        if ($existingRecord) {
            // Create a new entry if the existing record has a tanggal_lunas
            DB::table('hutang_2024')->insert([
                'id' => $request->input('id'), // Include the id in the new record
                'id_petani' => $request->input('id_petani'),
                'tanggal_hutang' => $request->input('tanggal_hutang'),
                'bon' => $request->input('bon'),
                'cicilan' => $request->input('cicilan'),
                'tanggal_lunas' => $request->input('tanggal_lunas'),
            ]);
    
            return redirect()->back()->with('success', 'Data added successfully!');
        } else {
            // Update the existing record if no tanggal_lunas
            DB::table('hutang_2024')
                ->where('id_petani', $request->input('id_petani'))
                ->update([
                    'tanggal_hutang' => $request->input('tanggal_hutang'),
                    'bon' => $request->input('bon'),
                    'cicilan' => $request->input('cicilan'),
                    'tanggal_lunas' => $request->input('tanggal_lunas'),
                ]);
    
            return redirect()->back()->with('success', 'Data updated successfully!');
        }
    }

    public function edit($id)
    {
        $data = DB::table('rekap_2024')->where('id_rekap', $id)->first();
        if (!$data) {
            return redirect()->route('inputPetani.store')->with('error', 'Data not found!');
        }

        return view('edit-form', [
            'data' => $data,
            'id_rekap' => $id,
        ]);
    }

    public function hutang(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id_petani' => 'required|exists:users,id', // Assuming the 'petani' table is 'users'
            'tanggal_hutang' => 'required|date',
            'bon' => 'required|numeric',
        ]);

        $id_petani = $request->id_petani;
        $tanggal_hutang = $request->tanggal_hutang;
        $bon = $request->bon;

        // Check if there is already a record for this petani
        $existingHutang = DB::table('hutang_2024')->where('id_petani', $id_petani)->first();

        if ($existingHutang) {
            // If record exists, update it by adding the new bon to the existing bon
            $newBon = $existingHutang->bon + $bon;

            DB::table('hutang_2024')
                ->where('id_petani', $id_petani)
                ->update([
                    'tanggal_hutang' => $tanggal_hutang,
                    'bon' => $newBon,
                    'cicilan' => $existingHutang->cicilan, // Retain existing cicilan
                    'tanggal_lunas' => $existingHutang->tanggal_lunas, // Retain existing tanggal_lunas
                ]);
        } else {
            // If no record exists, insert a new one
            DB::table('hutang_2024')->insert([
                'id_petani' => $id_petani,
                'tanggal_hutang' => $tanggal_hutang,
                'bon' => $bon,
                // cicilan and tanggal_lunas are not included in this insertion
            ]);
        }

        return redirect()->route('hutang-admin')->with('success', 'Hutang berhasil ditambahkan atau diperbarui!');
    }

    public function pelunasan(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id_petani' => 'required|exists:hutang_2024,id_petani', // Ensure id_petani exists in hutang_2024
            'jumlah_bayar' => 'required|numeric',
        ]);

        $id_petani = $request->id_petani;
        $jumlah_bayar = $request->jumlah_bayar;

        // Fetch the current hutang entry
        $hutang = DB::table('hutang_2024')->where('id_petani', $id_petani)->first();

        if ($hutang) {
            // Check if tanggal_lunas is already filled
            if ($hutang->tanggal_lunas !== null) {
                return redirect()->back()->with('error', 'Hutang ini sudah lunas dan tidak dapat diproses.');
            }

            // Calculate the new cicilan amount
            $newCicilan = $hutang->cicilan + $jumlah_bayar;

            // Determine tanggal_lunas based on new cicilan amount
            $tanggalLunas = $newCicilan >= $hutang->bon ? now()->format('Y-m-d') : null;

            // Update the hutang entry
            DB::table('hutang_2024')
                ->where('id_petani', $id_petani)
                ->update([
                    'cicilan' => $newCicilan,
                    'tanggal_lunas' => $tanggalLunas,
                ]);

            return redirect()->back()->with('success', 'Pelunasan berhasil!');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }
    public function destroy($id)
    {
        // Delete the record from the hutang_2024 table
        DB::table('hutang_2024')->where('id_petani', $id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
