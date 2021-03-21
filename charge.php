<?php

require_once('vendor/autoload.php');
require_once('config/db.php');
require_once('lib/pdo_db.php');
require_once('models/Customers.php');
require_once('models/Transactions.php');

// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_51IWaksDzFpbE9UOcM4DOCvdjiz7Xxi8xxbiafp0mKbbGPaO4qqtIdq8xc2zN5UJx8Sf7mJsShc7TT2CHrVPVCaeQ00429xpScu');


//Sanitiuze the Arrays
$POST = filter_var_array($_POST,FILTER_SANITIZE_STRING);

$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$email = $POST['email'];
$token = $_POST['stripeToken'];

//Create Customer In Stripe
$customer = \Stripe\Customer::create([
    'email'=> $email,
    'source'=>$token
]);

//Charge Customer

$charge = \Stripe\Charge::create([
  'amount' => 5000,
  'currency' => 'usd',
  'description' => 'Intro to React Course',
  'customer' => $customer->id,
]);

//Customer Data
$customerData = [
  'id'=> $charge->customer,
  'first_name'=> $first_name,
  'last_name'=> $last_name,
  'email'=> $email
];

//Init Customer
$customer = new Customer();

//Add Cutomer to DB
$customer->addCustomer($customerData);


//Transaction Data
$transactionData = [
  'id'=> $charge->id,
  'customer_id'=> $charge->customer,
  'product'=> $charge->description,
  'amount'=> $charge->amount,
  'currency'=>$charge->currency,
  'status'=>$charge->status
];

//Init Transactiton
$transations = new Transactions();

//Add Cutomer to DB
$transations->addTransactions($transactionData);



//  print_r($charge);

//Redirect to Success
header('Location:Success.php?tid='.$charge->id.'&product='.$charge->description);