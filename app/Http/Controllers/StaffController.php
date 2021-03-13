<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class StaffController extends Controller
{
    
    public function index()
    {
        $staff = User::all();

        return view('users.index')->with('staff', $staff);
    }

}
