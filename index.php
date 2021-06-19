<?php
use Pay\PayMobClass;
include 'Pay/PayMobClass.php';

$api_key = ['api_key' => 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SndjbTltYVd4bFgzQnJJam81TVRNd05pd2lZMnhoYzNNaU9pSk5aWEpqYUdGdWRDSXNJbTVoYldVaU9pSnBibWwwYVdGc0luMC5UN09iUm9sZEhMSnc3N2tPWFdJVjBkV1llUUNuTWRvbDFBb0FXMk15Y1k5VUNaSlh4aDd0VS03NENUbENwUzFXZFgzZ2ItNWFvSW4xSDhsZksyNm1DZw=='];
$headers = ['Content-Type: application/json'];
$integration_id = 224873;
$iframe_id = 215898;




/** first step to get auth_token  @var  $payMobObject  */

$FirstUrlToGetToken = 'https://accept.paymob.com/api/auth/tokens';

$payMobObject = new PayMobClass();
$payMobObject->prepareConnect($FirstUrlToGetToken);
$payMobObject->setHeaders($headers);
$payMobObject->sendRequestPostToGetToken($api_key);
$auth_token =  $payMobObject->getToken();



/** second step to get order_id */

$SecondUrlSendOrder = 'https://accept.paymob.com/api/ecommerce/orders';

$payMobObject->prepareConnect($SecondUrlSendOrder);

$orderDetails = [
    'auth_token' => $auth_token,
    'delivery_needed' => 'false',
    'amount_cents' => '100000',
    'items' => [],
    ];

$payMobObject->setHeaders($headers);
$payMobObject->setOrderDetails($orderDetails);
$payMobObject->sendOrderDetails();
$order_id = $payMobObject->getOrderID();


/** third step to get payment key @var  $SecondUrlSendOrder */

$SecondUrlSendOrder = 'https://accept.paymob.com/api/acceptance/payment_keys';

$data = [

 "auth_token" => $auth_token,
  "amount_cents" => "100000",
  "expiration" => 3600,
  "order_id" => $order_id,
  "billing_data" => [

    "apartment"=> "803",
    "email"=> "claudette09@exa.com",
    "floor"=> "42",
    "first_name"=> "Clifford",
    "street"=> "Ethan Land",
    "building"=> "8028",
    "phone_number"=> "+86(8)9135210487",
    "shipping_method"=> "PKG",
    "postal_code"=> "01898",
    "city"=> "Jaskolskiburgh",
    "country"=> "CR",
    "last_name"=> "Nicolas",
    "state"=> "Utah"  ,
    ],

  "currency" => "EGP",
  "integration_id" => $integration_id,

    ];

$payMobObject->setHeaders($headers);
$payMobObject->sendRequestPostToGetPaymentKey($data);
$payment_key =  $payMobObject->getPaymentKey();




$payUrlWithFrame = "https://accept.paymob.com/api/acceptance/iframe/215898?token=$auth_token";

echo '<a href="'.$payUrlWithFrame.'" target="_blank"> pay now</a>';
