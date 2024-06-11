<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class validatePaystacks extends Controller
{
    //

    public function validateP($reference) {

        $s = 1;

        if(!empty($reference)) {

            try {
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://api.paystack.co/transaction/verify/' . $reference,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 60,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // Fix typo in CURLOPT_HTTP_VERSION
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_SSL_VERIFYHOST => false, // Fix typo in CURLOPT_SSL_VERIFYHOST
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTPHEADER => ["accept: application/json", "Authorization: Bearer sk_test_781228e934e26d21f523197e85daaac548ebca86", "Cache-Control: no-cache"]
                ]);
        
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                $output = [];
        
                if ($err) {
                    $m =  "Something went wrong";
                } else {
                    $output = json_decode($response, true);
                    if (array_key_exists('data', $output) && array_key_exists('status', $output['data']) && $output['data']['status'] === 'success') {
                        $data = json_decode($response , true);  

                        
                        $payment = new \App\Models\MainModel\Payment;
                        $pay = $payment::where('reference', $reference)->first();

                        if($pay) {

                            $pay->status = 1;
                            $pay->verify = 1;
                            $pay->save();
                            $m = $data['message'];
                            $s = 1;
                        } else {
                            $s = 0;
                            $m = "Unable to update the payment pls contact support";
                        }
                        
                    } else {
                        $m = "Your payment is unsuccessfull but if you are debited pls contact us with your refence id $reference ";
                    }
                }
            } catch (\Exception $e) {
                $m = $e->getMessage();
            }
        } else {
            $m = "Payment refuse to validate contact us if you are being debited";
        }
        
        return ['s' => $s, 'm' => $m];
    } 
}
