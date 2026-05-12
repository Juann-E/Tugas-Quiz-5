<?php
namespace App\Http\Controllers;
use App\Models\User;

class DashboardController extends Controller {
    public function index() {
        $user  = User::with('activeLoans')->findOrFail(session('user_id'));
        return view('dashboard', compact('user'));
    }
}
