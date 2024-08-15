<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\Checkout\Store;
use App\Http\Controllers\Controller;
use App\Mail\Checkout\AfterCheckout;
use Illuminate\Http\Request;
use PharIo\Manifest\Email;
use App\Models\Checkout;
use App\Models\Camps;
use Auth;
use Mail;
class CheckoutController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Camps $camp, Request $request)
  {
    //return $camp;

    if ($camp->isRegistered) {
      $request->session()->flash('error', "You already registered on {$camp->title} camp.");

      return redirect(route('dashboard'));
    }


    return view('checkout.create', [
      'camp' => $camp
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Store $request, Camps $camp)
  {
    //mapping request data
    $data = $request->all();
    $data['user_id'] = Auth::id();
    $data['camp_id'] = $camp->id;

    //update user data
    $user = Auth::user();
    $user->email = $data['email'];
    $user->name = $data['name'];
    $user->occupation = $data['occupation'];
    $user->save();

    //create table checkout
    $checkout = Checkout::create($data);

    //sending email
    Mail::to(Auth::user()->email)->send(new AfterCheckout($checkout));

    return redirect(route('checkout.success'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Checkout $checkout)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Checkout $checkout)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Checkout $checkout)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Checkout $checkout)
  {
    //
  }

  public function success()
  {
    return view('checkout.success');
  }

  function invoice(Checkout $checkout)
  {
    return $checkout;
  }
}
