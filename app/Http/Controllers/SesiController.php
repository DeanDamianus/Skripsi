<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\ElseIf_;

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
            ->where('rekap_2024.id_petani', $userId)
            ->where('rekap_2024.id_musim', $idMusim) // Filter by id_musim from the request
            ->select('rekap_2024.*', 'parameter_2024.*')
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

        // Update the parameter in the database
        DB::table('parameter_2024')
            ->where('id', $request->input('id'))
            ->update([
                'biaya_jual' => $request->input('biaya_jual'),
                'naik_turun' => $request->input('naik_turun'),
            ]);

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

    public function inputDistribusi(Request $request)
{
    $request->validate([
        'id_rekap' => 'required|integer',
        'id_musim' => 'required|integer',
        'mobil_berangkat' => 'required|integer',
        'mobil_pulang' => 'required|integer',
        'status' => 'required|string|max:255',
    ]);

    // Prepare the data for insertion
    $data = [
        'id_rekap' => $request->input('id_rekap'),
        'id_musim' => $request->input('id_musim'),
        'n_gudang' => $request->input('n_gudang'),
        'nt_pabrik' => $request->input('nt_pabrik'),
        'kasut' => $request->input('kasut'),
        'transport_gudang' => $request->input('transport_gudang'),
        'mobil_berangkat' => $request->input('mobil_berangkat'),
        'mobil_pulang' => $request->input('mobil_pulang'),
        'status' => $request->input('status'),
    ];

    // Insert into the database
    DB::table('distribusi_2024')->insert($data);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Data inserted successfully!');
}



    //untuk dashboard input distribusi
    public function formdistribusi(Request $request)
    {
        $year = $request->input('year', date('Y')); // Ensure 'tahun' is being set correctly
        $userId = $request->input('id');
        $idMusim = $request->input('id_musim');
        $id_rekap = $request->input('id_rekap');
        $n_gudang = $request->input('n_gudang');
        $nt_pabrik= $request->input('nt_pabrik');
        $kasut = $request->input('kasut');
        $transport_gudang = $request->input('transport_gudang');

        $username = DB::table('users')->where('id', $userId)->pluck('name')->first();

        // In Controller
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
            ->first(); // Retrieve the first record

        return view('input_distribusi', [
            'data' => $data,
            'id_rekap' => $id_rekap,
            'status' => $status ? $status->status : null,
            'mobil_pulang' => $mobil_pulang ? $mobil_pulang->mobil_pulang : null,
            'mobil_berangkat' => $mobil_berangkat ? $mobil_berangkat->mobil_berangkat : null,
            'username' => $username,
            'selectedYear' => $year,
            'userId' => $userId,
            'idMusim' => $idMusim,
            'n_gudang'=>$n_gudang,
            'nt_pabrik'=>$nt_pabrik,
            'kasut' => $kasut,
            'transport_gudang' => $transport_gudang,
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

    //input registrasi petani baru
    public function inputpetani(Request $request)
    {
        $request->validate([
            'berat_gudang' => 'required|numeric',
            'harga' => 'required|numeric',
            'seri' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'grade' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'bruto' => 'required|numeric', // Include bruto in validation
            'netto' => 'required|numeric',
            'periode' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
            'no_gg' => $request->input('jual_luar_value') ? 'nullable|string' : 'required|string',
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
            'no_gg' => $request->input('no_gg'),
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

    public function hutangdashboard(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();
        return view('hutang_admin', [
            'selectedYear' => $year,
            'musim' => $musim,
            'currentMusim' => $musimList,
        ]);
    }

    public function datapetani(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();

        $data = DB::table('users')->where('role', 'petani')->get();

        return view('datapetani', [
            'selectedYear' => $year,
            'data' => $data,
            'musim' => $musim,
            'currentMusim' => $musimList,
        ]);
    }

    public function inputform(Request $request)
    {
        return view('input_distribusi', []);
    }
    //get untuk dashboard distribusi
    public function distribusidashboard(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $musim = DB::table('musim')->where('tahun', $year)->first();
        $musimList = DB::table('musim')->get();

        $data = DB::table('rekap_2024')
            ->leftJoin('distribusi_2024', 'rekap_2024.id_rekap', '=', 'distribusi_2024.id_rekap')
            ->where('rekap_2024.id_musim', $musim->id) // Join distribusi_2024 with rekap_2024
            ->select('rekap_2024.id_rekap', 'rekap_2024.periode', 'distribusi_2024.status', 'distribusi_2024.n_gudang', 'distribusi_2024.mobil_berangkat', 'distribusi_2024.mobil_pulang', 'distribusi_2024.nt_pabrik', 'distribusi_2024.kasut', 'distribusi_2024.transport_gudang', 'rekap_2024.id_petani', 'rekap_2024.id_musim')
            ->get();

        foreach ($data as $rekap) {
            $rekap->pengeluaran = $rekap->n_gudang + $rekap->mobil_berangkat + $rekap->mobil_pulang + $rekap->nt_pabrik + $rekap->kasut + $rekap->transport_gudang;
        }

        $totalpengeluaran = $data->sum('pengeluaran');

        $diterima = $data
            ->filter(function ($rekap) {
                return $rekap->status == 'Diterima';
            })
            ->count();

        $diproses = $data
            ->filter(function ($rekap) {
                return $rekap->status == 'Diproses';
            })
            ->count();

        $ditolak = $data
            ->filter(function ($rekap) {
                return $rekap->status == 'Ditolak';
            })
            ->count();

        $dikirim = $data
            ->filter(function ($rekap) {
                return $rekap->status == '';
            })
            ->count();

        foreach ($data as $rekap) {
            if ($rekap->status == 'Diterima') {
                $rekap->status = '<span class="badge badge-success">Diterima</span>';
            } elseif ($rekap->status == 'Diproses') {
                $rekap->status = '<span class="badge badge-warning">Diproses</span>';
            } elseif ($rekap->status == 'Ditolak') {
                $rekap->status = '<span class="badge badge-danger">Ditolak</span>';
            } elseif ($rekap->status == '') {
                $rekap->status = '<span class="badge badge-info">Belum Diproses</span>';
            }
        }

        return view('distribusi', [
            'data' => $data,
            'dikirim' => $dikirim,
            'diterima' => $diterima,
            'diproses' => $diproses,
            'ditolak' => $ditolak,
            'totalpengeluaran' => $totalpengeluaran,
            'selectedYear' => $year,
            'musim' => $musimList,
            'currentMusim' => $musim,
        ]);
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
    public function destroyrekap($id)
    {
        // Find the record by ID and delete it
        DB::table('rekap_2024')->where('id_rekap', $id)->delete();

        // Optionally, add a flash message for success
        return redirect()->back()->with('success', 'Record deleted successfully!');
    }
}
