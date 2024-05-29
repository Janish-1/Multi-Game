<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WithdrawForm extends Controller
{
    public function showWithdrawForm()
    {
        return view('withdraw');
    }
}
