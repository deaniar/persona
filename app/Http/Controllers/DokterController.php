<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'title' => 'Dashboard',
            'user' => $user
        ];
        return view('admin.dashboard', $data);
    }
}
