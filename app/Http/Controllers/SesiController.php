<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
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

    public function register(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();
        return view('register', [
            'selectedYear' => $year,
            'musim' => $musim,
            'currentMusim' => $musimList,
        ]);
    }

    public function postfoto(Request $request)
    {
        $userId = $request->input('id');
        $request->validate([
            'id' => 'required|integer',
            'name' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $updateData = [
            'name' => $request->input('name'),
        ];

        // Handle the file upload if a new image is provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName(); // Generate a unique name for the file
            $file->move(public_path('uploads'), $filename); // Move the file to the uploads directory

            // Add the new photo filename to the update data
            $updateData['image'] = $filename;
        }

        // Update the user's name and photo in the users table
        DB::table('users')->where('id', $userId)->update($updateData);

        // Redirect with a success message
        return redirect('/datapetani')->with('success', 'Data berhasil diperbaharui!');
    }

    public function uploadfoto(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $userId = $request->input('id');

        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();

        $data = DB::table('users')->where('id', $userId)->first();

        return view('upload-foto', [
            'selectedYear' => $year,
            'user' => $data,
            'musim' => $musim,
            'currentMusim' => $musimList,
        ]);
    }

    public function create(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:operator,petani',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Prepare user data
        $userData = [
            'name' => $validated['name'],
            'role' => $validated['role'],
            // We will set the image after moving it
        ];

        // Create a new user
        $user = User::create($userData);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName(); // Generate a unique name for the file
            $file->move(public_path('uploads'), $filename); // Move the file to the uploads directory

            // Update user image
            $user->update(['image' => $filename]);
        }

        // Redirect to login with a success message
        return redirect('/datapetani')->with('success', 'Registrasi berhasil! Silakan login.');
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

    public function rekap(Request $request)
    {
        // Get the selected year, default to the current year if not provided
        $year = $request->input('year', date('Y')); // Ensure 'tahun' is being set correctly
        $userId = $request->input('id');
        $idMusim = $request->input('id_musim');

        // Fetch the season (musim) based on the selected year
        $musim = DB::table('musim')->where('tahun', $year)->first();

        // If no season is found for the selected year, return a 404 error
        if (!$musim) {
            abort(404, 'Year not found');
        }

        // Get the username based on user ID
        $username = DB::table('users')->where('id', $userId)->pluck('name')->first();

        // Fetch data for rekap based on the current id_musim and selected year
        $data = DB::table('rekap_2024')
            ->join('parameter_2024', 'rekap_2024.id_musim', '=', 'parameter_2024.id_musim')
            ->join('users', 'rekap_2024.id_petani', '=', 'users.id') // Join with users table
            ->where('rekap_2024.id_petani', $userId)
            ->where('rekap_2024.id_musim', $idMusim) // Filter by id_musim from the request
            ->select('rekap_2024.*', 'parameter_2024.*', 'users.image') // Select the image field from users table
            ->get();

        // Fetch parameter data
        $parameter = DB::table('parameter_2024')->where('id', $year)->first();

        // Get netting and pricing information
        $netto = DB::table('rekap_2024')->where('id_petani', $userId)->pluck('netto')->first();
        $harga = DB::table('rekap_2024')->where('id_petani', $userId)->pluck('harga')->first();
        $petani = DB::table('users')->where('role', 'petani')->get();

        // Calculate KJ and other fields dynamically
        foreach ($data as $rekap) {
            $rekap->kj = $rekap->harga <= 50000 ? 1000 * $rekap->netto : ($rekap->harga <= 75000 ? 2000 * $rekap->netto : ($rekap->harga <= 100000 ? 3000 * $rekap->netto : ($rekap->harga <= 125000 ? 4000 * $rekap->netto : ($rekap->harga <= 150000 ? 5000 * $rekap->netto : 6000 * $rekap->netto))));

            $rekap->jumlah = $rekap->netto * $rekap->harga;
            $rekap->jumlahkotor = $rekap->jumlah - $rekap->kj - $rekap->biaya_jual - $rekap->naik_turun;
            $rekap->komisi = $rekap->jumlahkotor * $rekap->kepala_petani;
            $rekap->bersih = $rekap->jumlahkotor - $rekap->komisi;
        }

        // Get the list of musim
        $musimList = DB::table('musim')->get();
        foreach ($data as $rekap) {
            $rekap->indicator = $rekap->jual_luar == 1 ? '<span class="badge badge-warning">Jual Luar</span>' : '';
        }

        foreach ($data as $rekap) {
            $rekap->cek = $rekap->bruto - $rekap->berat_gudang;
        }

        //calculate all total
        $totalnetto = $data->sum('netto');
        $totalbruto = $data->sum('bruto');
        $totaljumlahharga = $data->sum('jumlah');
        $totaljumlahbersih = $data->sum('bersih');
        $cektotal = $data->sum('cek');

        // Pass the data to the view
        return view('input_data', [
            'id' => $musim->id,
            'idPetani' => $userId,
            'petani' => $petani,
            'harga' => $harga,
            'parameter' => $parameter,
            'totaljumlahharga' => $totaljumlahharga,
            'totaljumlahbersih' => $totaljumlahbersih,
            'data' => $data,
            'netto' => $netto,
            'cektotal' => $cektotal,
            'totalnetto' => $totalnetto,
            'totalbruto' => $totalbruto,
            'username' => $username,
            'selectedYear' => $year,
            'musim' => $musimList,
        ]);
    }

    public function updateParameter(Request $request)
    {
        $year = $request->input('tahun', date('Y'));
        $id = $request->input('id'); // Get the ID for the specific row to update

        // Update the bunga_hutang for all rows
        DB::table('parameter_2024')->update([
            'bunga_hutang' => $request->input('bunga_hutang') / 100,
        ]);

        // Optionally update biaya_jual and naik_turun for the specific row if provided
        if ($id) {
            DB::table('parameter_2024')
                ->where('id', $id)
                ->update([
                    'biaya_jual' => $request->input('biaya_jual'),
                    'naik_turun' => $request->input('naik_turun'),
                ]);
        }

        return redirect()
            ->route('parameter', ['tahun' => $year])
            ->with('success', 'Parameter berhasil diubah!');
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

        // Fetch data from the dynamically named table
        $data = DB::table('users')
            ->leftJoin('rekap_2024', function ($join) use ($musim) {
                $join->on('users.id', '=', 'rekap_2024.id_petani')->where('rekap_2024.id_musim', $musim->id); // Filter by id_musim in the join
            })
            ->where('users.role', 'petani') // Filter users by role 'petani'
            ->select('users.id', 'users.name', DB::raw('SUM(rekap_2024.netto) as netto'), DB::raw('MAX(rekap_2024.harga) as harga'), DB::raw('SUM(rekap_2024.jual_luar) as jual_luar'))
            ->groupBy('users.id', 'users.name') // Group by user ID and name to avoid duplicates
            ->get();

        $nama = DB::table('users')->where('role', 'petani')->get();
        // Fetch seasons for the dropdown menu
        $musimList = DB::table('musim')->get();

        // Calculate totals
        $total_netto = $data->sum('netto');
        $total_harga = $data->sum('harga');
        $total_jual_luar = $data->sum('jual_luar');

        foreach ($data as $rekap) {
            $rekap->jumlahtotal = $rekap->harga * $rekap->netto; // secara dinamis mennghitung jumlahnya.
        }

        foreach ($data as $rekap) {
            $rekap->jumlahtotal = $rekap->harga * $rekap->netto; // secara dinamis mennghitung jumlahnya.
        }

        $totaljumlahharga = $data->sum('jumlahtotal');

        // Return the view with the necessary data
        return view('input', [
            'data' => $data,
            'musim' => $musimList,
            'petani' => $nama,
            'selectedYears' => $year,
            'id_musim' => $musim->id,
            'total_netto' => $total_netto,
            'totaljumlahharga' => $totaljumlahharga,
            'total_harga' => $total_harga,
            'total_jual_luar' => $total_jual_luar,
        ]);
    }

    //post controller
    public function inputDistribusi(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id_rekap' => 'required|integer',
            'id_musim' => 'required|integer',
            'mobil_berangkat' => 'required|integer',
            'mobil_pulang' => 'required|integer',
            'status' => 'required|string|max:255',
            'grade' => 'required|string|in:A,B,C,D',
        ]);

        // Get the year from the request or default to current year
        $year = $request->input('year', date('Y'));

        // Prepare the date fields based on status
        $tgl_diterima = $request->input('status') === 'Diterima' ? date('Y-m-d') : null;
        $tgl_diproses = $request->input('status') === 'Diproses' ? date('Y-m-d') : null;
        $tgl_ditolak = $request->input('status') === 'Dikembalikan' ? date('Y-m-d') : null;

        // Prepare the data for insertion/update in distribusi_2024 table
        $distribusiData = [
            'id_rekap' => $request->input('id_rekap'),
            'id_musim' => $request->input('id_musim'),
            'tgl_diterima' => $tgl_diterima,
            'tgl_diproses' => $tgl_diproses,
            'tgl_ditolak' => $tgl_ditolak,
            'n_gudang' => $request->input('n_gudang', 5000),
            'nt_pabrik' => $request->input('nt_pabrik', 10000),
            'kasut' => $request->input('kasut', 10000),
            'transport_gudang' => $request->input('transport_gudang', 5000),
            'mobil_berangkat' => $request->input('mobil_berangkat'),
            'mobil_pulang' => $request->input('mobil_pulang'),
            'status' => $request->input('status'),
        ];

        // Use the upsert method for automatic insert or update based on id_rekap and id_musim
        DB::table('distribusi_2024')->upsert([$distribusiData], ['id_rekap', 'id_musim'], array_keys($distribusiData));

        // Update the grade in rekap_2024 table for the corresponding id_rekap
        DB::table('rekap_2024')
            ->where('id_rekap', $request->input('id_rekap'))
            ->update(['grade' => $request->input('grade')]);

        // Redirect back with success message
        return redirect()
            ->to('http://127.0.0.1:8000/distribusi?year=' . $year)
            ->with('success', 'Data updated successfully!');
    }

    //untuk dashboard input distribusi get
    public function formdistribusi(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $userId = $request->input('id');
        $idMusim = $request->input('id_musim');

        $username = DB::table('users')->where('id', $userId)->pluck('name')->first();

        $data = DB::table('rekap_2024')->join('parameter_2024', 'rekap_2024.id_musim', '=', 'parameter_2024.id_musim')->where('rekap_2024.id_petani', $userId)->where('rekap_2024.id_musim', $idMusim)->select('rekap_2024.*', 'parameter_2024.*')->first();

        $mobil_berangkat = DB::table('distribusi_2024')
            ->where('id_rekap', $userId) // Adjust the condition if id_petani belongs to distribusi_2024 // Adjust the condition if id_musim belongs to distribusi_2024
            ->select('mobil_berangkat')
            ->first();

        $mobil_pulang = DB::table('distribusi_2024')
            ->where('id_rekap', $userId) // Adjust the condition if id_petani belongs to distribusi_2024 // Adjust the condition if id_musim belongs to distribusi_2024
            ->select('mobil_pulang')
            ->first();

        $status = DB::table('distribusi_2024')
            ->where('id_rekap', $userId) // Adjust the condition if id_petani belongs to distribusi_2024 // Adjust the condition if id_musim belongs to distribusi_2024
            ->select('status')
            ->first();

        $grade = DB::table('rekap_2024')
            ->where('id_rekap', $userId) // Adjust the condition if id_petani belongs to distribusi_2024 // Adjust the condition if id_musim belongs to distribusi_2024
            ->select('grade')
            ->first(); // Retrieve the first record

        return view('input_distribusi', [
            'data' => $data,
            'status' => $status ? $status->status : null,
            'mobil_pulang' => $mobil_pulang ? $mobil_pulang->mobil_pulang : null,
            'mobil_berangkat' => $mobil_berangkat ? $mobil_berangkat->mobil_berangkat : null,
            'username' => $username,
            'selectedYear' => $year,
            'userId' => $userId,
            'idMusim' => $idMusim,
            'grade' => $grade ? $grade->grade : null,
        ]);
    }

    public function dashboardindividual(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $idMusim = $request->input('id_musim');
        $userId = $request->input('id');

        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();

        $data = DB::table('users')->where('role', 'petani')->get();

        $rekap = DB::table('rekap_2024')->where('id_petani', $userId)->get();

        foreach ($data as $user) {
            $user->formatted_created_at = \Carbon\Carbon::parse($user->created_at)->format('d-m-Y');
        }

        return view('dashboard-Petanidata', [
            'selectedYear' => $year,
            'rekap' => $rekap,
            'userId' => $userId,
            'idmusim' => $idMusim,
            'data' => $data,
            'musim' => $musim,
            'currentMusim' => $musimList,
        ]);
    }

    public function dashboardpetani(Request $request)
    {
        $year = $request->input('tahun', date('Y')); // Ensure 'tahun' is being set correctly
        $userId = $request->input('id');

        // Fetch the musim based on the selected year
        $musim = DB::table('musim')->where('tahun', $year)->first();
        $idMusim = $musim->id;

        //mengambil netto dari tiap grade.
        $netto_d_a = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%d%')->where('periode', 'LIKE', '%A%')->where('id_musim', $idMusim)->sum('netto');

        $netto_d_b = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%d%')->where('periode', 'LIKE', '%B%')->where('id_musim', $idMusim)->sum('netto');

        $netto_c_a = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%c%')->where('periode', 'LIKE', '%A%')->where('id_musim', $idMusim)->sum('netto');

        $netto_c_b = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%c%')->where('periode', 'LIKE', '%B%')->where('id_musim', $idMusim)->sum('netto');

        $netto_b_a = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%b%')->where('periode', 'LIKE', '%A%')->where('id_musim', $idMusim)->sum('netto');

        $netto_b_b = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%b%')->where('periode', 'LIKE', '%B%')->where('id_musim', $idMusim)->sum('netto');

        $netto_a_a = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%A%')->where('periode', 'LIKE', '%A%')->where('id_musim', $idMusim)->sum('netto');

        $netto_a_b = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%A%')->where('periode', 'LIKE', '%B%')->where('id_musim', $idMusim)->sum('netto');

        //mengambil tiap grade
        $gradeA = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%A%')->where('id_musim', $idMusim)->count();

        $gradeB = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%B%')->where('id_musim', $idMusim)->count();

        $gradeC = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%C%')->where('id_musim', $idMusim)->count();

        $gradeD = DB::table('rekap_2024')->where('id_petani', $userId)->where('grade', 'LIKE', '%D%')->where('id_musim', $idMusim)->count();

        //mengambil data jual luar
        $jualLuar = DB::table('rekap_2024')
            ->where('id_petani', $userId)
            ->where('id_musim', $musim->id)
            ->where('jual_luar', '1')
            ->count('jual_luar');

        $jualDalam = DB::table('rekap_2024')
            ->where('id_petani', $userId)
            ->where('id_musim', $musim->id)
            ->where('jual_luar', '0')
            ->count('jual_luar');

        // Get the username based on user ID
        $username = DB::table('users')->where('id', $userId)->pluck('name')->first();

        $foto = DB::table('users')->where('id', $userId)->pluck('image')->first();

        $rekapcount = DB::table('rekap_2024')->where('id_petani', $userId)->count();

        // Fetch data for rekap based on the current id_musim and selected year
        $data = DB::table('rekap_2024')
            ->join('parameter_2024', 'rekap_2024.id_musim', '=', 'parameter_2024.id_musim')
            ->join('users', 'rekap_2024.id_petani', '=', 'users.id') // Join with users table
            ->where('rekap_2024.id_petani', $userId)
            ->where('rekap_2024.id_musim', $idMusim) // Filter by id_musim
            ->select('rekap_2024.*', 'parameter_2024.*', 'users.image') // Select the image field from users table
            ->get();

        // Fetch parameter data
        $parameter = DB::table('parameter_2024')->select('biaya_jual', 'naik_turun', 'kepala_petani')->where('id_musim', $idMusim)->first();

        $biaya_jual = $parameter->biaya_jual;
        $naik_turun = $parameter->naik_turun;

        // Get netting and pricing information
        $nettoValues = DB::table('rekap_2024')
            ->where('id_petani', $userId)
            ->where('id_musim', $idMusim) // Filter by id_musim
            ->pluck('netto'); // Get all netto values

        $hargaValues = DB::table('rekap_2024')
            ->where('id_petani', $userId)
            ->where('id_musim', $idMusim) // Filter by id_musim
            ->pluck('harga'); // Get all harga values

        $totalValues = [];
        $kjValues = []; // Array to store kj values
        $jumlahKotorValues = []; // Array to store jumlahkotor values
        $komisiValues = []; // Array to store komisi values
        $jumlahBersihValues = []; // Array to store jumlah bersih values

        foreach ($nettoValues as $index => $netto) {
            $harga = $hargaValues[$index]; // Assuming both arrays have the same length

            // Calculate netto * harga for each row
            $total = $netto * $harga;
            $totalValues[] = $total;

            // Calculate kj based on harga
            if ($harga <= 50000) {
                $kj = 1000 * $netto;
            } elseif ($harga <= 75000) {
                $kj = 2000 * $netto;
            } elseif ($harga <= 100000) {
                $kj = 3000 * $netto;
            } elseif ($harga <= 125000) {
                $kj = 4000 * $netto;
            } elseif ($harga <= 150000) {
                $kj = 5000 * $netto;
            } else {
                $kj = 6000 * $netto;
            }

            // Store kj value
            $kjValues[] = $kj;

            // Calculate jumlahkotor
            $jumlahKotor = $total - $kj - $parameter->biaya_jual - $parameter->naik_turun;
            $jumlahKotorValues[] = $jumlahKotor;

            // Calculate komisi
            $komisi = $jumlahKotor * $parameter->kepala_petani;
            $komisiValues[] = $komisi;

            // Calculate jumlahbersih
            $jumlahBersih = $jumlahKotor - $komisi;
            $jumlahBersihValues[] = $jumlahBersih;
        }

        // Calculate totals
        $sumTotal = array_sum($totalValues);
        $sumKj = array_sum($kjValues);
        $sumJumlahKotor = array_sum($jumlahKotorValues);
        $sumJumlahBersih = array_sum($jumlahBersihValues);

        // Get the list of musim
        $musimList = DB::table('musim')->get();
        foreach ($data as $rekap) {
            $rekap->indicator = $rekap->jual_luar == 1 ? '<span class="badge badge-warning">Jual Luar</span>' : '';
        }

        foreach ($data as $rekap) {
            $rekap->cek = $rekap->bruto - $rekap->berat_gudang;
        }

        // Calculate all total
        $totalnetto = $data->sum('netto');
        $totalbruto = $data->sum('bruto');
        $totaljumlahharga = $data->sum('jumlah');
        $totaljumlahbersih = $data->sum('bersih');

        //hutang
        $hutang = DB::table('hutang_2024')->select('bon', 'cicilan', 'tanggal_hutang', 'tanggal_lunas')->where('id_petani', $userId)->first();
        $bon = 0;
        $cicilan = 0;
        $formatted_tanggal_hutang = '-';
        $tanggal_lunas = '-';
        $totalbon = 0;
        $sisahutang = 0;

        // Proceed with calculations only if hutang is found
        if ($hutang) {
            // Extract values from the retrieved record
            $bon = $hutang->bon;
            $cicilan = $hutang->cicilan;

            // Calculate the bunga hutang
            $tanggal_hutang = Carbon::createFromFormat('Y-m-d', $hutang->tanggal_hutang);
            $current_tanggal = Carbon::now(); // tanggal hari ini
            $bunga = 0.25; // 25%

            // Calculate the difference in years and the interest (bunga hutang)
            $diff_in_years = $tanggal_hutang->diffInDays($current_tanggal) / 365;
            $bunga_hutang = $diff_in_years * $bunga * $bon; // Assuming interest applies to the 'bon' amount

            // Calculate bunga hutang as a percentage
            $bunga_hutang_percentage = ($bunga_hutang / $bon) * 100;

            // Formatting the dates
            $formatted_tanggal_hutang = $tanggal_hutang->format('d-m-Y');
            $tanggal_lunas = !empty($hutang->tanggal_lunas) ? Carbon::createFromFormat('Y-m-d', $hutang->tanggal_lunas)->format('d-m-Y') : '-';

            // Calculate total bunga (including original 'bon' amount)
            $totalbon = $bon + $bon * ($bunga_hutang_percentage / 100); // Convert percentage to decimal for calculation
            $sisahutang = $totalbon - $cicilan;
        }
        //ini diperbaiki, karena remainign adalah sisa, dan ga dynamis

        return view('dashboardpetani', [
            'selectedYear' => $year,
            'jualLuar' => $jualLuar,
            'jualDalam' => $jualDalam,
            'netto_d_a' => $netto_d_a,
            'sisahutang' => $sisahutang,
            'netto_d_b' => $netto_d_b,
            'netto_c_a' => $netto_c_a,
            'netto_c_b' => $netto_c_b,
            'netto_b_a' => $netto_b_a,
            'netto_b_b' => $netto_b_b,
            'netto_a_a' => $netto_a_a,
            'netto_a_b' => $netto_a_b,
            'totalnetto' => $nettoValues,
            'rekap' => $rekapcount,
            'biayajual' => $biaya_jual,
            'naikturun' => $naik_turun,
            'harga' => $sumTotal, // Use sumTotal here
            'kj' => $sumKj, // Use sumKj here
            'totalnetto' => $totalnetto,
            'totalbruto' => $totalbruto,
            'foto' => $foto,
            'totalharga' => $totaljumlahharga,
            'totalbersih' => $sumJumlahBersih,
            'parameter' => $parameter,
            'remainingHutang' => $hutang->remaining_hutang ?? 0,
            'userId' => $userId,
            'username' => $username,
            'musim' => $idMusim,
            'currentMusim' => $musimList,
            'gradeA' => $gradeA,
            'gradeB' => $gradeB,
            'gradeC' => $gradeC,
            'gradeD' => $gradeD,
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

        $sisa = DB::table('rekap_2024')
            ->leftJoin('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('rekap_2024.id_musim', $musim->id)
            ->whereNull('distribusi_2024.id_rekap')
            ->select('rekap_2024.*')
            ->count();

        $rekapcount = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'LIKE', '%Diterima%')
            ->where('rekap_2024.id_musim', $musim->id)
            ->count();

        $gradeA = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('rekap_2024.id_musim', $musim->id)
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.grade', 'LIKE', '%A%')
            ->count();

        $gradeB = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('rekap_2024.id_musim', $musim->id)
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.grade', 'LIKE', '%B%')
            ->count();

        $gradeC = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('rekap_2024.id_musim', $musim->id)
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.grade', 'LIKE', '%C%')
            ->count();

        $gradeD = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('rekap_2024.id_musim', $musim->id)
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.grade', 'LIKE', '%D%')
            ->count();

        $data = DB::table('rekap_2024')
            ->join('users', 'rekap_2024.id_petani', '=', 'users.id')
            ->select('rekap_2024.id_petani', 'users.name', DB::raw('SUM(rekap_2024.netto) as total_netto'))
            ->where('rekap_2024.id_musim', $musim->id)
            ->groupBy('rekap_2024.id_petani', 'users.name')
            ->orderByDesc('total_netto') // Sort by highest total_netto
            ->get();

        //total omset + hasill bersih
        $jumlahkotor = DB::table('rekap_2024')
            ->join('users', 'rekap_2024.id_petani', '=', 'users.id')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->whereNotNull('distribusi_2024.tgl_diterima')
            ->where('rekap_2024.id_musim', $musim->id)
            ->select('rekap_2024.id_petani', 'users.name', DB::raw('SUM(rekap_2024.netto * rekap_2024.harga) as omset'))
            ->groupBy('rekap_2024.id_petani', 'users.name')
            ->get();

            $bon = DB::table('hutang_2024')
            ->select('id_petani', 'bon', 'tanggal_hutang','cicilan') // Include tanggal_hutang for each entry
            ->groupBy('id_petani', 'bon', 'tanggal_hutang','cicilan')
            ->get()
            ->toArray();

        $tanggal_hutang = DB::table('hutang_2024')->select('tanggal_hutang')->get()->toArray();

        $bungahutang = DB::table('parameter_2024')->select('bunga_hutang')->first();

        // dd($bon);
        $current_tanggal = Carbon::now(); // Get the current date

        $bonhutang_with_bunga = [];

        // Loop through each bon entry and calculate the bunga hutang for each one
        $bunga = (float) $bungahutang->bunga_hutang;

        $sisahutangPerPetani = [];

        // Loop through each bon entry and calculate the sisahutang
        foreach ($bon as $entry) {
            // Convert the tanggal_hutang for each entry to a Carbon date
            $tanggal_hutang = Carbon::createFromFormat('Y-m-d', $entry->tanggal_hutang);
            
            // Ensure that 'bon' is accessed as a numeric value (not an object)
            $bon_value = (float) $entry->bon;
            
            // Calculate the difference in years
            $diff_in_years = $tanggal_hutang->diffInDays($current_tanggal) / 365;
            
            // Calculate bunga hutang
            $bunga_hutang = $diff_in_years * $bunga * $bon_value; 
            $bunga_hutang_percentage = ($bunga_hutang / $bon_value) * 100;
            
            // Calculate total bon including bunga
            $totalbon = $bon_value + $bon_value * ($bunga_hutang_percentage / 100);
            
            // Access cicilan from the entry
            $cicilan = (float) $entry->cicilan;
            
            // Calculate sisahutang
            $sisahutang = $totalbon - $cicilan;
            
            // Store the result in the array using id_petani as the key
            $sisahutangPerPetani[$entry->id_petani] = $sisahutang; // Store sisahutang for each petani
        }     
        

        // Fetch harga and netto values together from rekap_2024
        $parameter = DB::table('parameter_2024')
            ->select('biaya_jual', 'naik_turun', 'kepala_petani')
            ->where('id_musim', $musim->id)
            ->first();

        $harganetto = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->join('users', 'rekap_2024.id_petani', '=', 'users.id') // Join users to get the name
            ->where('rekap_2024.id_musim', $musim->id)
            ->whereNotNull('distribusi_2024.tgl_diterima')
            ->select('rekap_2024.id_rekap', 'rekap_2024.harga', 'rekap_2024.netto', 'users.name') // Select the necessary fields, including users.name
            ->get();

        // Define arrays to store the calculated values per user
        $userJumlahBersih = [];
        $userNames = [];

        // Iterate through each data row to calculate values for each user
        foreach ($harganetto as $item) {
            $id_petani = $item->id_rekap; // Assuming 'id_petani' corresponds to 'id_rekap'
            $netto = $item->netto;
            $harga = $item->harga;

            // Calculate netto * harga for each row
            $total = $netto * $harga;

            // Calculate kj based on harga
            if ($harga <= 50000) {
                $kj = 1000 * $netto;
            } elseif ($harga <= 75000) {
                $kj = 2000 * $netto;
            } elseif ($harga <= 100000) {
                $kj = 3000 * $netto;
            } elseif ($harga <= 125000) {
                $kj = 4000 * $netto;
            } elseif ($harga <= 150000) {
                $kj = 5000 * $netto;
            } else {
                $kj = 6000 * $netto;
            }

            // Calculate jumlahKotor
            $jumlahKotor = $total - $kj - $parameter->biaya_jual - $parameter->naik_turun;

            // Calculate komisi
            $komisi = $jumlahKotor * $parameter->kepala_petani;

            // Calculate jumlahBersih
            $jumlahBersih = $jumlahKotor - $komisi;

            // Use the petani's name instead of id_petani for the keys
            $petaniName = $item->name; // Get the petani's name

            // Add jumlahBersih to the corresponding petani name
            if (!isset($userJumlahBersih[$petaniName])) {
                $userJumlahBersih[$petaniName] = []; // Initialize an array for each petani
            }

            // Push each jumlahBersih value for this petani into the array
            $userJumlahBersih[$petaniName][] = $jumlahBersih;
        }

        // Calculate the total of all jumlahBersih values for each petani
        $totalBersihPerPetani = [];
        foreach ($userJumlahBersih as $bersihArray) {
            $totalBersihPerPetani[] = array_sum($bersihArray); // Just push the total value
        }

        $dataOmset = [];
        foreach ($jumlahkotor as $data) {
            $dataOmset[$data->name] = $data->omset;
        }


        $petani = array_keys($dataOmset);
        $dataOmset = array_values($dataOmset);
        

    
        //NOTA A
        $diterima = DB::table('distribusi_2024')
            ->join('rekap_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.periode', 'LIKE', '%A%') // Replace 'periode' with the appropriate column name from rekap_2024
            ->where('rekap_2024.id_musim', $musim->id)
            ->count();

        $diproses = DB::table('distribusi_2024')
            ->join('rekap_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'Diproses')
            ->where('rekap_2024.periode', 'LIKE', '%A%') // Replace 'periode' with the appropriate column name from rekap_2024
            ->where('rekap_2024.id_musim', $musim->id)
            ->count();

        $ditolak = DB::table('distribusi_2024')
            ->join('rekap_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'Dikembalikan')
            ->where('rekap_2024.periode', 'LIKE', '%A%') // Replace 'periode' with the appropriate column name from rekap_2024
            ->where('rekap_2024.id_musim', $musim->id)
            ->count();

        $belumproses = DB::table('rekap_2024')
            ->where('id_musim', $musim->id)
            ->whereNotIn('id_rekap', function ($query) use ($musim) {
                $query
                    ->select('id_rekap')
                    ->from('distribusi_2024')
                    ->where('id_musim', $musim->id);
            })
            ->where('periode', 'LIKE', '%A%')
            ->count();

        //NOTA B

        $diterima_B = DB::table('distribusi_2024')
            ->join('rekap_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.periode', 'LIKE', '%B%') // Replace 'periode' with the appropriate column name from rekap_2024
            ->where('rekap_2024.id_musim', $musim->id)
            ->count();

        $diproses_B = DB::table('distribusi_2024')
            ->join('rekap_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'Diproses')
            ->where('rekap_2024.periode', 'LIKE', '%B%') // Replace 'periode' with the appropriate column name from rekap_2024
            ->where('rekap_2024.id_musim', $musim->id)
            ->count();

        $ditolak_B = DB::table('distribusi_2024')
            ->join('rekap_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'Dikembalikan')
            ->where('rekap_2024.periode', 'LIKE', '%B%') // Replace 'periode' with the appropriate column name from rekap_2024
            ->where('rekap_2024.id_musim', $musim->id)
            ->count();

        $belumproses_B = DB::table('rekap_2024')
            ->where('id_musim', $musim->id)
            ->whereNotIn('id_rekap', function ($query) use ($musim) {
                $query
                    ->select('id_rekap')
                    ->from('distribusi_2024')
                    ->where('id_musim', $musim->id);
            })
            ->where('periode', 'LIKE', '%B%')
            ->count();

        $musimList = DB::table('musim')->get();

        $totalNetto = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'LIKE', '%Diterima%')
            ->where('rekap_2024.id_musim', $musim->id)
            ->sum('rekap_2024.netto');

        $totalHarga = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap') // Join condition corrected here
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.id_musim', $musim->id)
            ->sum(DB::raw('rekap_2024.netto * rekap_2024.harga'));

        $totalHargaditerima = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.id_musim', $musim->id)
            ->sum(DB::raw('rekap_2024.netto * rekap_2024.harga'));

        $periode12b = DB::table('rekap_2024')->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')->where('rekap_2024.periode', '12-B')->where('distribusi_2024.status', 'Diterima')->sum(DB::raw('rekap_2024.netto * rekap_2024.harga'));

        $jualLuar = DB::table('rekap_2024')
            ->where('id_musim', $musim->id)
            ->where('jual_luar', '1')
            ->count('jual_luar');

        $jualDalam = DB::table('rekap_2024')
            ->join('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('distribusi_2024.status', 'Diterima')
            ->where('rekap_2024.id_musim', $musim->id)
            ->where('rekap_2024.jual_luar', '0')
            ->count('rekap_2024.jual_luar');

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

        return view('dashboard-admin', [
            'data' => $data,
            'diterima' => $diterima,
            'jualLuar' => $jualLuar,
            'jualDalam' => $jualDalam,
            'petani' => $petani,
            'gradeA' => $gradeA,
            'gradeB' => $gradeB,
            'gradeC' => $gradeC,
            'gradeD' => $gradeD,
            'dataomset' => $dataOmset,
            'hargaditerima' => $totalHargaditerima,
            'belumproses' => $belumproses,
            'ditolak' => $ditolak,
            'diproses' => $diproses,
            'diterima_B' => $diterima_B,
            'belumproses_B' => $belumproses_B,
            'ditolak_B' => $ditolak_B,
            'diproses_B' => $diproses_B,
            'selectedYear' => $year,
            'musim' => $musimList,
            'id_musim' => $musim->id,
            'totalNetto' => $totalNetto,
            'totalHarga' => $totalHarga,
            'jualLuar' => $jualLuar,
            'jumlahPetani' => $jumlahPetani,
            'biayaParam' => $biayaParam,
            'rekapcount' => $rekapcount,
            'sisa' => $sisa,
            'userJumlahBersih' => $userJumlahBersih,
            'totalBersihPerPetani' => $totalBersihPerPetani,
            'sisahutangPerPetani' => $sisahutangPerPetani,
        ]);
        
    }

    //input registrasi petani baru
    public function inputpetani(Request $request)
    {
        //checker
        // dd($request->all());
        $request->validate([
            'berat_gudang' => 'required|numeric',
            'harga' => 'required|numeric',
            'seri' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'grade' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'bruto' => 'required|numeric', // Include bruto in validation
            'netto' => 'required|numeric',
            'periode' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'id_petani' => 'required|integer',
            'id_musim' => 'required|integer',
        ]);

        // Retrieve necessary data from the request
        $idMusim = $request->input('id_musim');
        $year = $request->input('tahun', date('Y'));
        $id_petani = $request->input('id_petani');

        // Insert a new record in the rekap_2024 table
        DB::table('rekap_2024')->insert([
            'id_petani' => $id_petani,
            'id_musim' => $idMusim,
            'netto' => $request->input('netto'),
            'jual_luar' => $request->input('jual_luar_value', 0),
            'harga' => $request->input('harga'),
            'berat_gudang' => $request->input('berat_gudang'),
            'grade' => $request->input('grade'),
            'periode' => $request->input('periode'),
            'seri' => $request->input('seri'),
            'bruto' => $request->input('bruto'),
        ]);

        // Redirect after successful insertion
        return redirect()
            ->to(url('/dataInput?id=' . $id_petani . '&id_musim=' . $idMusim . '&year=' . $year))
            ->with('success', 'Data successfully created!');
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
        $idhutang = $request->id_hutang;

        // Insert a new hutang record for the user, without checking for existing records
        $id_hutang = DB::table('hutang_2024')->insertGetId([
            'id_petani' => $id_petani,
            'tanggal_hutang' => $tanggal_hutang,
            'bon' => $bon,
            // 'cicilan' and 'tanggal_lunas' can be left null or default based on your database schema
        ]);

        // Now insert into hutang_history with the retrieved id_hutang
        DB::table('hutang_history')->insert([
            'id_hutang' => $id_hutang, // Use the retrieved id_hutang here
            'tanggal_hutang' => $tanggal_hutang,
            'bon' => $bon,
        ]);

        return redirect()->back()->with('success', 'Hutang berhasil ditambah!');
    }

    public function hutangdashboard(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $idMusim = $request->input('id_musim');
        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();
        $petaniInHutang = DB::table('hutang_2024')
            ->whereNull('tanggal_lunas') // Ensure only records with null tanggal_lunas are retrieved
            ->get();

        return view('hutang_admin', [
            'idmusim' => $idMusim,
            'selectedYear' => $year,
            'musim' => $musim,
            'currentMusim' => $musimList,
            'petaniInHutang' => $petaniInHutang,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->query('search');
        $data = User::where('name', 'LIKE', "%{$search}%")->get();
        $year = $request->input('year', date('Y'));

        return view('datapetani', compact('data'));
    }

    public function datapetani(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();

        $data = DB::table('users')->where('role', 'petani')->get();

        foreach ($data as $user) {
            $user->formatted_created_at = \Carbon\Carbon::parse($user->created_at)->format('d-m-Y');
        }

        return view('datapetani', [
            'selectedYear' => $year,
            'data' => $data,
            'musim' => $musim,
            'currentMusim' => $musimList,
        ]);
    }

    public function inputform(Request $request)
    {
        $year = $request->input('year', date('Y')); // Ensure 'tahun' is being set correctly
        $userId = $request->input('id');
        $idMusim = $request->input('id_musim');
        $idrekap = $request->input('id_rekap');
        $username = DB::table('users')->where('id', $userId)->pluck('name')->first();

        $data = DB::table('rekap_2024')
            ->join('parameter_2024', 'rekap_2024.id_musim', '=', 'parameter_2024.id_musim')
            ->where('rekap_2024.id_petani', $userId)
            ->where('rekap_2024.id_musim', $idMusim) // Filter by id_musim from the request
            ->select('rekap_2024.*', 'parameter_2024.*')
            ->get();

        return view('input_petani', [
            'data' => $data,
            'username' => $username,
            'selectedYear' => $year,
            'userId' => $userId,
            'idMusim' => $idMusim,
        ]);
    }
    //get untuk dashboard distribusi
    public function distribusidashboard(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();

        // Get sorting parameters with default values for 'status' and 'asc'
        $sort = $request->input('sort', 'rekap_2024.periode'); // Default sort by status
        $direction = $request->input('direction', 'asc'); // Default direction is ascending

        $data = DB::table('users')
            ->leftJoin('rekap_2024', function ($join) use ($musim) {
                $join->on('users.id', '=', 'rekap_2024.id_petani')->where('rekap_2024.id_musim', $musim->id);
            })
            ->leftJoin('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('users.role', 'petani')
            ->select('users.id', 'users.name', DB::raw('SUM(rekap_2024.netto) as netto'), DB::raw('MAX(rekap_2024.harga) as harga'), DB::raw('SUM(rekap_2024.jual_luar) as jual_luar'), 'rekap_2024.id_rekap', 'rekap_2024.periode', 'distribusi_2024.tgl_diterima', 'distribusi_2024.tgl_diproses', 'distribusi_2024.tgl_ditolak', 'distribusi_2024.status', 'distribusi_2024.n_gudang', 'distribusi_2024.mobil_berangkat', 'distribusi_2024.mobil_pulang', 'distribusi_2024.nt_pabrik', 'distribusi_2024.kasut', 'distribusi_2024.transport_gudang', 'distribusi_2024.rekap_lama', 'rekap_2024.id_petani', 'rekap_2024.id_musim')
            ->where('rekap_2024.jual_luar', '!=', '1')
            ->groupBy('users.id', 'users.name', 'rekap_2024.id_rekap', 'rekap_2024.periode', 'distribusi_2024.tgl_diterima', 'distribusi_2024.tgl_diproses', 'distribusi_2024.tgl_ditolak', 'distribusi_2024.status', 'distribusi_2024.n_gudang', 'distribusi_2024.mobil_berangkat', 'distribusi_2024.mobil_pulang', 'distribusi_2024.nt_pabrik', 'distribusi_2024.kasut', 'distribusi_2024.transport_gudang', 'distribusi_2024.rekap_lama', 'rekap_2024.id_petani', 'rekap_2024.id_musim')
            ->orderBy($sort, $direction)
            ->get();

        // Calculate the pengeluaran for each rekap
        foreach ($data as $rekap) {
            $rekap->pengeluaran = $rekap->n_gudang + $rekap->mobil_berangkat + $rekap->mobil_pulang + $rekap->nt_pabrik + $rekap->kasut + $rekap->transport_gudang;
        }

        $totalpengeluaran = $data->sum('pengeluaran');

        $diterima = $data->filter(fn($rekap) => $rekap->status == 'Diterima')->count();
        $diproses = $data->filter(fn($rekap) => $rekap->status == 'Diproses')->count();
        $ditolak = $data->filter(fn($rekap) => $rekap->status == 'Dikembalikan')->count();
        $dikirim = $data->filter(fn($rekap) => $rekap->status == '')->count();
        $ulang = $data->filter(fn($rekap) => $rekap->status == 'Distribusi Ulang')->count();
        $belumproses = $dikirim + $ulang;

        // Format the status values with badges
        foreach ($data as $rekap) {
            $rekap->status = match ($rekap->status) {
                'Diterima' => '<span class="badge badge-success">Diterima</span>',
                'Diproses' => '<span class="badge badge-warning">Dikirim</span>',
                'Dikembalikan' => '<span class="badge badge-danger">Dikembalikan</span>',
                'Distribusi Ulang' => '<span class="badge badge-dark">Distribusi Ulang</span>',
                default => '<span class="badge badge-info">Belum Dikirim</span>',
            };
        }

        return view('distribusi', [
            'data' => $data,
            'musimList' => $musimList,
            'dikirim' => $dikirim,
            'belumproses' => $belumproses,
            'diterima' => $diterima,
            'diproses' => $diproses,
            'ditolak' => $ditolak,
            'totalpengeluaran' => $totalpengeluaran,
            'selectedYear' => $year,
            'musim' => $musimList,
            'currentMusim' => $musim,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    public function pelunasan(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id_hutang' => 'required|exists:hutang_2024,id_hutang', // Ensure id_hutang exists in hutang_2024
            'jumlah_bayar' => 'required|numeric',
        ]);

        $id_hutang = $request->id_hutang;
        $jumlah_bayar = $request->jumlah_bayar;

        // Fetch the current hutang entry by id_hutang
        $hutang = DB::table('hutang_2024')->where('id_hutang', $id_hutang)->first();

        if ($hutang) {
            // Check if tanggal_lunas is already filled
            if ($hutang->tanggal_lunas !== null) {
                return redirect()->back()->with('error', 'Hutang ini sudah lunas dan tidak dapat diproses.');
            }

            // Calculate interest and total bon
            $tanggal_hutang = Carbon::createFromFormat('Y-m-d', $hutang->tanggal_hutang);
            $current_tanggal = Carbon::now(); // tanggal hari ini
            $bunga = 0.25; // 25%

            $diff_in_years = $tanggal_hutang->diffInDays($current_tanggal) / 365;
            $bunga_hutang = $diff_in_years * $bunga * $hutang->bon;
            $bunga_hutang_percentage = ($bunga_hutang / $hutang->bon) * 100;
            $totalbon = $hutang->bon + $hutang->bon * ($bunga_hutang_percentage / 100);

            // Calculate the new cicilan amount
            $newCicilan = $hutang->cicilan + $jumlah_bayar;

            // Check if hutang is fully paid and set tanggal_lunas
            $tanggalLunas = $newCicilan >= $totalbon ? now()->format('Y-m-d') : null;
            $tanggal_cicilan = now(); // Use current date or modify as needed

            // Insert a new record into hutang_history
            DB::table('hutang_history')->insert([
                'id_hutang' => $id_hutang,
                'tanggal_cicilan' => $tanggal_cicilan,
                'bon' => $jumlah_bayar, // Insert the amount paid
                'tanggal_lunas' => $tanggalLunas, // Auto-insert the same tanggal_lunas if fully paid
            ]);

            // Update the hutang entry
            DB::table('hutang_2024')
                ->where('id_hutang', $id_hutang)
                ->update([
                    'cicilan' => $newCicilan,
                    'tanggal_lunas' => $tanggalLunas,
                ]);

            return redirect()->back()->with('success', 'Pelunasan berhasil!');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    public function history_hutang($id_hutang)
    {
        // Fetch the history data along with the petani's name
        $history = DB::table('hutang_history')
            ->join('hutang_2024', 'hutang_history.id_hutang', '=', 'hutang_2024.id_hutang') // Join hutang_2024 to get id_petani
            ->join('users', 'hutang_2024.id_petani', '=', 'users.id') // Join users to get the name
            ->where('hutang_history.id_hutang', $id_hutang)
            ->select('hutang_history.*', 'users.name') // Select fields you want
            ->get();

        // Return the view with the retrieved data
        return view('history_hutang', [
            'history' => $history, // Pass the history data to the view
        ]);
    }

    public function destroy($id)
    {
        // Delete the record from the hutang_2024 table
        DB::table('hutang_2024')->where('id_petani', $id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
    public function destroyrekap($id)
    {
        // Find the record by ID and delete it
        DB::table('rekap_2024')->where('id_rekap', $id)->delete();

        // Optionally, add a flash message for success
        return redirect()->back()->with('success', 'Record deleted successfully!');
    }

    public function error(Request $request)
    {
        return view('error');
    }

    public function distribusitolak(Request $request)
    {
        $year = $request->input('year', date('Y')); // Ensure 'tahun' is being set correctly
        $userId = $request->input('id');
        $idMusim = $request->input('id_musim');
        $idrekap = $request->input('id_rekap');
        $id_petani = $request->input('id_petani');
        $grade = DB::table('rekap_2024')
            ->where('id_rekap', $userId) // Adjust the condition if id_petani belongs to distribusi_2024 // Adjust the condition if id_musim belongs to distribusi_2024
            ->select('grade')
            ->first();
        $data = DB::table('rekap_2024')->where('id_rekap', $userId)->first();

        return view('distribusi_tolak', [
            'selectedYear' => $year,
            'idpetani' => $id_petani,
            'grade' => $grade,
            'data' => $data,
            'userId' => $userId,
            'idMusim' => $idMusim,
            'idrekap' => $idrekap,
        ]);
    }
    public function distribusiulang(Request $request)
    {
        // Validate incoming data

        $request->validate([
            'berat_gudang' => 'required|numeric',
            'harga' => 'required|numeric',
            'seri' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'grade' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'bruto' => 'required|numeric',
            'netto' => 'required|numeric',
            'periode' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'id_musim' => 'required|integer',
            'status' => 'required|string',
            'rekap_lama' => 'required|numeric',
        ]);
        $year = $request->input('year', date('Y')); // Ensure 'tahun' is being set correctly
        $userId = $request->input('id');
        $idMusim = $request->input('id_musim');
        $id_petani = $request->input('id_petani');

        // Insert a new record into the 'rekap_2024' table and get the inserted id
        $id_rekap = DB::table('rekap_2024')->insertGetId([
            'id_musim' => $idMusim,
            'netto' => $request->input('netto'),
            'jual_luar' => $request->input('jual_luar_value', 0), // Assuming this is a value you want to include
            'harga' => $request->input('harga'),
            'berat_gudang' => $request->input('berat_gudang'),
            'grade' => $request->input('grade'),
            'periode' => $request->input('periode'),
            'seri' => $request->input('seri'),
            'bruto' => $request->input('bruto'), // Assuming this is also included
        ]);

        // Insert a new record into the 'distribusi_2024' table
        DB::table('distribusi_2024')->insert([
            'id_rekap' => $id_rekap,
            'status' => $request->input('status'),
            'rekap_lama' => $request->input('rekap_lama'), // Make sure this key matches the database column name
        ]);

        // Redirect after successful insertion with a success message
        return redirect()
            ->to(url('/distribusi?year=' . $year))
            ->with('success', 'Data successfully created in rekap_2024 and status in distribusi_2024!');
    }

    public function distribusibulk(Request $request)
    {
        // Retrieve input values with default values if not provided
        $year = $request->input('year', date('Y'));
        $userId = $request->input('id');
        $idMusim = $request->input('id_musim');
        $periode = $request->query('periode'); // Default to '1-A' if not provided

        // Retrieve status from `rekap_2024` where `periode` matches
        $status = DB::table('rekap_2024')->where('periode', $periode)->where('id_musim', $idMusim)->select('status')->first();

        // Retrieve relevant data from `rekap_2024` for the specified `periode` and `id_musim`
        $data = DB::table('rekap_2024')->where('periode', $periode)->where('id_musim', $idMusim)->get();

        // Extract the unique grades and `id_rekap`
        $grade = $data->pluck('grade')->unique();
        $idrekap = $data->pluck('id_rekap');

        // Pass data to the view
        return view('input_distribusi_bulk', [
            'selectedYear' => $year,
            'status' => $status,
            'grade' => $grade,
            'data' => $data,
            'userId' => $userId,
            'idMusim' => $idMusim,
            'idrekap' => $idrekap,
            'periode' => $periode,
        ]);
    }

    public function inputbulk(Request $request)
    {
        $request->validate([
            'records' => 'required|array',
            'records.*.id_rekap' => 'required|integer',
            'records.*.id_musim' => 'required|integer',
            'records.*.mobil_berangkat' => 'required|integer',
            'records.*.mobil_pulang' => 'required|integer',
            'records.*.status' => 'required|string|max:255',
            'records.*.grade' => 'required|string|in:A,B,C,D',
        ]);

        // Prepare data for bulk insertion and grade updates
        $bulkData = [];
        $gradeUpdates = [];
        $periode = $request->query('periode');

        foreach ($request->input('records') as $record) {
            $tgl_diterima = $record['status'] === 'Diterima' ? date('Y-m-d') : null;
            $tgl_diproses = $record['status'] === 'Diproses' ? date('Y-m-d') : null;
            $tgl_ditolak = $record['status'] === 'Dikembalikan' ? date('Y-m-d') : null;

            $bulkData[] = [
                'id_rekap' => $record['id_rekap'],
                'id_musim' => $record['id_musim'],
                'tgl_diterima' => $tgl_diterima,
                'tgl_diproses' => $tgl_diproses,
                'tgl_ditolak' => $tgl_ditolak,
                'n_gudang' => $record['n_gudang'] ?? 5000,
                'nt_pabrik' => $record['nt_pabrik'] ?? 10000,
                'kasut' => $record['kasut'] ?? 10000,
                'transport_gudang' => $record['transport_gudang'] ?? 5000,
                'mobil_berangkat' => $record['mobil_berangkat'],
                'mobil_pulang' => $record['mobil_pulang'],
                'status' => $record['status'],
                'periode' => $periode,
            ];

            // Prepare grade updates for each `id_rekap`
            $gradeUpdates[$record['id_rekap']] = ['grade' => $record['grade']];
        }

        // Perform bulk upsert for `distribusi_2024` table
        DB::table('distribusi_2024')->upsert($bulkData, ['id_rekap', 'id_musim'], array_keys($bulkData[0]));

        // Perform bulk updates for grades in `rekap_2024` table
        foreach ($gradeUpdates as $id_rekap => $update) {
            DB::table('rekap_2024')->where('id_rekap', $id_rekap)->update($update);
        }

        // Redirect back with a success message
        return redirect()
            ->to('http://127.0.0.1:8000/distribusi-bulk?periode=' . $request->query('periode') . '&id_musim=' . $request->input('id_musim'))
            ->with('success', 'Bulk data updated successfully!');
    }
}
