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
        // Validate the incoming request data
        $validated = $request->validate([
            'netto' => 'required|numeric',
            'harga' => 'required|numeric',
            'berat_gudang' => 'required|numeric',
            'grade' => 'required|string',
            'id_rekap' => 'required|integer',
            'redirect_url' => 'required|url',
        ]);

        // Extract validated data
        $id_rekap = $validated['id_rekap'];
        $netto = $validated['netto'];
        $harga = $validated['harga'];
        $berat_gudang = $validated['berat_gudang'];
        $grade = $validated['grade'];
        $redirect_url = $validated['redirect_url'];

        // Update the data in the database
        $affected = DB::table('rekap_2024')
            ->where('id_rekap', $id_rekap)
            ->update([
                'netto' => $netto,
                'harga' => $harga,
                'berat_gudang' => $berat_gudang,
                'grade' => $grade,
            ]);

        if ($affected) {
            // Redirect back to the previous URL
            return redirect($redirect_url)->with('success', 'Data berhasil diubah!');
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau tidak ada perubahan!');
        }
    }
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'netto' => 'required|numeric',
            'harga' => 'required|numeric',
            'berat_gudang' => 'required|numeric',
            'grade' => 'required|string',
            'id_rekap' => 'required|integer',
        ]);

        // Collect data from the request
        $id_rekap = $request->input('id_rekap');
        $netto = $request->input('netto');
        $harga = $request->input('harga');
        $berat_gudang = $request->input('berat_gudang');
        $grade = $request->input('grade');

        // Update the existing data in the rekap_2024 table
        DB::table('rekap_2024')
            ->where('id_rekap', $id_rekap)
            ->update([
                'netto' => $netto,
                'harga' => $harga,
                'berat_gudang' => $berat_gudang,
                'grade' => $grade,
            ]);

        // Redirect with success message
        return redirect('/input')->with('success', 'Data berhasil diubah!');
    }

    public function hutangLunas(Request $request)
    {
        $request->validate([
            'id_hutang' => 'required|exists:users,id',
            'cicilan' => 'required|numeric',
        ]);

        $petaniId = $request->input('petani_id');
        $jumlahBayar = $request->input('cicilan');

        // Fetch the outstanding debt for this petani
        $debt = DB::table('hutang_2024')->where('id_hutang', $petaniId)->select(DB::raw('bon - cicilan AS outstanding_debt'))->first();

        if ($debt && $jumlahBayar == $debt->outstanding_debt) {
            $tanggalLunas = now()->format('Y-m-d'); // Set today's date

            // Update the database to set the `tanggal_lunas`
            DB::table('hutang_2024')
                ->where('id_hutang', $petaniId)
                ->update(['tanggal_lunas' => $tanggalLunas]);

            return redirect()->back()->with('success', 'Payment successful and date updated.');
        }

        return redirect()->back()->with('error', 'Payment failed or amount does not match outstanding debt.');
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
        $existingHutang = DB::table('hutang_2024')->where('id_hutang', $id_petani)->first();

        if ($existingHutang) {
            // If record exists, update it by adding the new bon to the existing bon
            $newBon = $existingHutang->bon + $bon;

            DB::table('hutang_2024')
                ->where('id_hutang', $id_petani)
                ->update([
                    'tanggal_hutang' => $tanggal_hutang,
                    'bon' => $newBon,
                    'cicilan' => $existingHutang->cicilan, // Retain existing cicilan
                    'tanggal_lunas' => $existingHutang->tanggal_lunas, // Retain existing tanggal_lunas
                ]);
        } else {
            // If no record exists, insert a new one
            DB::table('hutang_2024')->insert([
                'id_hutang' => $id_petani,
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
            'id_petani' => 'required|exists:hutang_2024,id_hutang', // Ensure id_petani exists in hutang_2024
            'jumlah_bayar' => 'required|numeric',
        ]);

        $id_petani = $request->id_petani;
        $jumlah_bayar = $request->jumlah_bayar;

        // Fetch the current hutang entry
        $hutang = DB::table('hutang_2024')->where('id_hutang', $id_petani)->first();

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
                ->where('id_hutang', $id_petani)
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
        DB::table('hutang_2024')->where('id_hutang', $id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
