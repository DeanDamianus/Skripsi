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
    public function parameter(Request $request)
    {
        // Get the selected year, default to the current year if not provided
        $year = $request->input('tahun', date('Y'));

        // Fetch the season (musim) based on the selected year
        $musim = DB::table('musim')->where('tahun', $year)->first();

        // If no season is found for the selected year, return a 404 error
        if (!$musim) {
            abort(404, 'Year not found');
        }

        // Fetch the list of all available seasons (years) for the dropdown
        $musimList = DB::table('musim')->get();

        // Fetch the parameters based on the selected year
        $parameter = DB::table('parameter_2024')
            ->where('id_musim', $musim->id)
            ->first();

        // Pass the data to the view
        return view('parameter', [
            'selectedYear' => $year,
            'musim' => $musimList,
            'parameter' => $parameter, // Pass parameter data
            'id_musim' => $musim->id,
        ]);
    }
    public function updateParameter(Request $request)
    {
        // Set the year, or default to the current year if not provided
        $year = $request->input('tahun', date('Y'));

        // Validate input data
        $validatedData = $request->validate([
            'biaya_jual' => 'required|numeric',
            'naik_turun' => 'required|numeric',
        ]);

        // Update the parameter in the database
        DB::table('parameter_2024')
            ->where('id', $request->input('id'))
            ->update([
                'biaya_jual' => $request->input('biaya_jual'),
                'naik_turun' => $request->input('naik_turun'),
            ]);

        // Redirect back with success message, using a query parameter for 'tahun'
        return redirect()
            ->route('parameter')
            ->with(['success' => 'Parameter berhasil diubah!'])
            ->withInput(['tahun' => $year]);
    }


    public function input(Request $request)
    {
        // Retrieve the year from the request; default to the current year if not provided
        $year = $request->input('year', date('Y'));

        // Fetch the year id from the musim table based on the selected year
        $musim = DB::table('musim')->where('tahun', $year)->first();

        if (!$musim) {
            // Handle the case where no matching year is found in the musim table
            abort(404, 'Year not found');
        }

        // Build the table name based on the retrieved id_year
        $tableName = 'users';

        // Fetch data from the dynamically named table
        $data = DB::table($tableName)
            ->leftJoin('rekap_2024', 'users.id', '=', 'rekap_2024.id_petani') // Left join to include all users
            ->where('users.role', 'petani') // Filter by role 'petani'
            ->where(function ($query) use ($musim) {
                $query
                    ->where('rekap_2024.id_musim', $musim->id) // Filter by id_musim if there is data
                    ->orWhereNull('rekap_2024.id_musim'); // Include users without matching rekap_2024 data
            })
            ->select('users.*', 'rekap_2024.*') // Select users and rekap_2024 columns
            ->get();

        // Fetch seasons for the dropdown menu
        $musimList = DB::table('musim')->get();

        // Calculate totals
        $total_netto = $data->sum('netto');
        $total_harga = $data->sum('harga');
        $total_jual_luar = $data->sum('jual_luar');

        // Return the view with the necessary data
        return view('input', [
            'data' => $data,
            'musim' => $musimList,
            'selectedYears' => $year,
            'id_musim' => $musim->id,
            'total_netto' => $total_netto,
            'total_harga' => $total_harga,
            'total_jual_luar' => $total_jual_luar,
        ]);
    }

    public function dashboard(Request $request)
    {
        // Ambil tahun yang dipilih dari request
        $year = $request->input('tahun', date('Y'));

        // Ambil id musim berdasarkan tahun yang dipilih
        $musim = DB::table('musim')->where('tahun', $year)->first();

        if (!$musim) {
            abort(404, 'Year not found');
        }

        $musimList = DB::table('musim')->get();

        $totalNetto = DB::table('rekap_2024')
            ->where('id_musim', $musim->id)
            ->sum('netto');

        $totalHarga = DB::table('rekap_2024')
            ->where('id_musim', $musim->id)
            ->sum(DB::raw('netto * harga'));

        $jualLuar = DB::table('rekap_2024')
            ->where('id_musim', $musim->id)
            ->sum('jual_luar');

        $jumlahPetani = DB::table('users')->where('role', 'petani')->count('id'); // Pastikan menggunakan id_petani dari rekap_2024

        $biayaParam = DB::table('parameter_2024')
            ->where('id_musim', $musim->id)
            ->sum('biaya_jual');

        // Ambil data untuk ditampilkan berdasarkan id_musim
        $data = DB::table('rekap_2024')
            ->join('users', 'rekap_2024.id_petani', '=', 'users.id')
            ->select('rekap_2024.*', 'users.name')
            ->where('rekap_2024.id_musim', $musim->id)
            ->get();

        // Kembalikan view dengan data yang diperlukan
        return view('dashboard-admin', [
            'data' => $data,
            'selectedYear' => $year,
            'musim' => $musimList,
            'id_musim' => $musim->id,
            'totalNetto' => $totalNetto,
            'totalHarga' => $totalHarga,
            'jualLuar' => $jualLuar,
            'jumlahPetani' => $jumlahPetani,
            'biayaParam' => $biayaParam,
        ]);
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
        $existingRecord = DB::table('hutang_2024')->where('id_petani', $request->input('id_petani'))->whereNotNull('tanggal_lunas')->first();

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
