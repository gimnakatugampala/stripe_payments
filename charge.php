<?php

require_once('vendor/autoload.php');

// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_51IWaksDzFpbE9UOcM4DOCvdjiz7Xxi8xxbiafp0mKbbGPaO4qqtIdq8xc2zN5UJx8Sf7mJsShc7TT2CHrVPVCaeQ00429xpScu');


//Sanitiuze the Arrays
$POST = filter_var_array($_POST,FILTER_SANITIZE_STRING);

$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$email = $POST['email'];
$token = $POST['StripeToken'];

// Token is created using Stripe Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];
$charge = \Stripe\Charge::create([
  'amount' => 999,
  'currency' => 'usd',
  'description' => 'Example charge',
  'source' => $token,
]);