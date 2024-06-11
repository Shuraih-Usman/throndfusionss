<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use \App\Http\Controllers\Payment\Monnify;
class payMonnify extends Controller
{
    //

    public function verify($reference, $detect_reference) {

        $monnify = new Monnify();
        $s = 0;
        $m = "";
        $verify = $monnify->verifyTrans($reference);

        

        if($verify['paymentStatus'] == 'PAID'){

            $payment = new \App\Models\MainModel\Payment;
            $pay = $payment::where('reference', $detect_reference)->first();

            if($pay) {

                $pay->status = 1;
                $pay->verify = 1;
                $pay->monnify_reference = $reference;
                $pay->save();
                $m = "You successfully make this payment";
                $s = 1;
            } else {
                $s = 0;
                $m = "Unable to update the payment pls contact support";
            }
    
        } else if($verify['paymentStatus'] == 'PENDING') {
            $m = "Your Transaction is pending Contact us if you have been debited with your Payment Reference $reference";
        } else{
            $m = "Failed verifying The Transaction Contact us if you have been debited with your Payment Reference $reference ";
            
        }

        return ['m' => $m, 's' => $s];
    }
}
