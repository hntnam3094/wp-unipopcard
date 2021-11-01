<?php
class TwoCheckoutApi {
    function __construct()
    {
        include_once 'libary/lib/Twocheckout.php';

        Twocheckout::privateKey('DE7ED2F7-8C0A-4C9F-B551-C5CEBAB354C7');
        Twocheckout::sellerId('251761074825');

    }

    public function createCharge($post_data, $token)
    {
        if (!$token) {
            return '<p>Token error</p>';
        }

        $merchantOrderId = 'KN0123987';
        try {
            $charge = Twocheckout_Charge::auth(array(
                "merchantOrderId" => $merchantOrderId,
                "token" => $token,
                "currency" => 'USD',
                "total" => '10.00',
                "billingAddr" => array(
                    "name" => 'Testing Tester',
                    "addrLine1" => '123 Test St',
                    "city" => 'Columbus',
                    "state" => 'OH',
                    "zipCode" => '43123',
                    "country" => 'USA',
                    "email" => 'testingtester@2co.com',
                    "phoneNumber" => '555-555-5555'
                ),
                "shippingAddr" => array(
                    "name" => 'Testing Tester',
                    "addrLine1" => '123 Test St',
                    "city" => 'Columbus',
                    "state" => 'OH',
                    "zipCode" => '43123',
                    "country" => 'USA',
                    "email" => 'testingtester@2co.com',
                    "phoneNumber" => '555-555-5555'
                ),
                "demo" => true
            ));

            if ($charge['response']['responseCode'] == 'APPROVED') {
                echo "Thanks for your Order!";
            }
        } catch (Twocheckout_Error $e) {
            var_dump($e);
        }
    }
}
