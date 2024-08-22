<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function operatorDashboard()
    {
        if (Auth::user()->role === 'operator') {
            return view('dashboardadmin');
        }

        return redirect('/')->withErrors('Access Denied');
    }

    public function petaniDashboard()
    {
        if (Auth::user()->role === 'petani') {
            return view('dashboardPetani');
        }

        return redirect('/')->withErrors('Access Denied');
    }
}
