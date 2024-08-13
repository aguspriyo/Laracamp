<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
  function dashboard()
  {
    $checkouts = Checkout::with('Camp')->whereUserId(Auth::id())->get();

    return view('user.dashboard', [
      'checkouts' => $checkouts
    ]);
  }
}