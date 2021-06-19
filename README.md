# PayMobClass
this is sample class descripe how to integrate your website with egyptian payment gateway ( paymob ) only first three steps to get payment key and after you can choose any method like valu or wallet or vodafone cashe and another methods its maintainable and readable now lets start know how to use.



# FIRST INCLUDE CLASS FILE IN OUR SCOPE
include 'PayMobClass.php';


# SOME VARIABLES WE WILL USE IT ALWAYS YOU CAN MAKE IT DEFINES
$api_key = ['api_key' => 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0N'];
$headers = ['Content-Type: application/json'];
$integration_id = 224873;
$iframe_id = 215898;



# NOTE BEFORE START 
to integrate with any method of payment gateway you should pass this three steps we will describe under 
So these are the three basic steps.




# OK LETS START WITH FIRST STEP TARGET FROM THIS STEP ( GET TOKEN )

$FirstUrlToGetToken = 'https://accept.paymob.com/api/auth/tokens';  => first url we must call in doc paymob to get token
$payMobObject = new PayMobClass();                                  => new instance from our class
$payMobObject->prepareConnect($FirstUrlToGetToken);                 => connect to url by Curl 
$payMobObject->setHeaders($headers);                                => set some header to our request 
$payMobObject->sendRequestPostToGetToken($api_key);                 => send post request by Curl to get token you must send param ( api_key ) inside your dashboard paymob getway $auth_token =  $payMobObject->getToken();                           => this function return token we can save it inside variable to use it at second step  



# OK LETS START WITH SECOND STEP TARGET FROM THIS STEP ( SEND ORDER DETAILS AND ORDER ID FROM RESPONSE )

$SecondUrlSendOrder = 'https://accept.paymob.com/api/ecommerce/orders';  => second url we must call in doc paymob to send order details
$payMobObject->prepareConnect($SecondUrlSendOrder);                      => connect to url by Curl 
$orderDetails = [
    'auth_token' => $auth_token,
    'delivery_needed' => 'false',
    'amount_cents' => '100000',
    'items' => [],
    ];
$payMobObject->setHeaders($headers);                                     => set some header to our request 
$payMobObject->setOrderDetails($orderDetails);                           => initialize your order details
$payMobObject->sendOrderDetails();                                       => send our odrder details by Curl post request 
$order_id = $payMobObject->getOrderID();                                 => this function return order id we can save it inside variable to use it at third step   



# OK LETS START WITH THIRD STEP TARGET FROM THIS STEP ( GET PAYMENT KEY )

$ThirdUrlSendOrder = 'https://accept.paymob.com/api/acceptance/payment_keys';  => third url we must call in doc paymob to send billing data details to get payment key
$payMobObject->prepareConnect($ThirdUrlSendOrder);
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

$payMobObject->setHeaders($headers);                                            => set some header to our request 
$payMobObject->sendRequestPostToGetPaymentKey($data);                           => send our billing details by Curl post request to get payment key
$payment_key =  $payMobObject->getPaymentKey();                                 => this function return payment key we can save it inside variable to use it at last step
  


# THIS IS LAST URL WE SHOULD PRINT IT FOR USER TO CLICK PAY NOW 
# THIS ID YOUR IFRAME YOU SHOULD FOUND IT INSIDE YOUR DASHBOARD PAYMOB

$payUrlWithFrame = "https://accept.paymob.com/api/acceptance/iframe/$iframe_id?token=$auth_token";

echo '<a href="'.$payUrlWithFrame.'" target="_blank"> PAY NOW </a>';





