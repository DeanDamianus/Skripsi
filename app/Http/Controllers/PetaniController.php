<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PetaniController extends Controller
{
    public function delete(Request $request)
    {
        $userId = $request->input('user_id');

        // Check if the user with the given ID has the 'petani' role
        $user = DB::table('users')->where('id', $userId)->where('role', 'petani')->first();

        if ($user) {
            // User exists and has the 'petani' role, proceed to delete
            DB::table('users')->where('id', $userId)->delete();
            return Redirect::back()->with('success', 'User with ID ' . $userId . ' has been deleted.');
        } else {
            // User not found or does not have 'petani' role
            return Redirect::back()->with('error', 'User not found or does not have the role petani.');
        }
    }
}
