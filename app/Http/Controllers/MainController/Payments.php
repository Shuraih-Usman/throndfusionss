<?php

namespace App\Http\Controllers\MainController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\req;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UserModel\Service;

class Payments extends Controller
{
    //

    public function add($req) {
        $s = 0;
        $r = "";
        $payment = new \App\Models\MainModel\Payment;

        DB::beginTransaction();

        try {
            $payment->user_id = $req->user_id;
            $payment->reference = $req->reference;
            $payment->price = $req->price;
            $payment->payment_type = $req->payment_type;
            $payment->save();
            $s = 1;
            $r = $req->reference;
            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['exception' => $e]);
            throw $e;
        }

        return ['r' => $r, 's' => $s];
    }


    public function validatePaystackService($req) {

        $validate = new \App\Http\Controllers\Payment\validatePaystacks;
        $s = 0;
        $t = "";
        if($validate->validateP($req->reference)['s'] == 1) {
            $id = $req->id;
            $quantity = $req->quantity;
            $user_id = $req->user_id;
            $item = Service::find($id);
    
            if(!$item) {
                $m = "Invalid service or deleted";
            } else {
                $trans = new \App\Models\UserModel\Service_enroll();
                $total = $quantity * $item->price;
                $transaction_id = $req->reference;
                $t = $transaction_id;
                
                try {
                    DB::beginTransaction();
                    $trans->service_id = $id;
                    $trans->buyer_id = $user_id;
                    $trans->transaction_id = $transaction_id;
                    $trans->price = $item->price;
                    $trans->quantity = $quantity;
                    $trans->total = $total;
                    $trans->payment_type = 1;
                    $trans->status = 1;
                    $trans->save();
                    DB::commit();
                    $s = 1;
                    $m = "You successfully paid and acquired this service";
                } catch(\Exception $e) {
                    DB::rollBack();
                    $m = "Error ".$e->getMessage();
                }
        }
        } else {
            $m = $validate->validateP($req->reference)['m'];
        }

        return ['m' => $m, 's' => $s, 't' => $t];

    }

    public function validateMonnifyService($req) {

        $validate = new \App\Http\Controllers\Payment\PayMonnify;
        $s = 0;
        $t = "";
        $monnify_validate = $validate->verify($req->reference, $req->detectref);
        if($monnify_validate['s'] == 1) {
            $id = $req->id;
            $quantity = $req->quantity;
            $user_id = $req->user_id;
            $item = Service::find($id);
    
            if(!$item) {
                $m = "Invalid service or deleted";
            } else {
                $trans = new \App\Models\UserModel\Service_enroll();
                $total = $quantity * $item->price;
                $transaction_id = $req->detectref;
                $t = $transaction_id;
                
                try {
                    DB::beginTransaction();
                    $trans->service_id = $id;
                    $trans->buyer_id = $user_id;
                    $trans->transaction_id = $transaction_id;
                    $trans->price = $item->price;
                    $trans->quantity = $quantity;
                    $trans->total = $total;
                    $trans->payment_type = 2;
                    $trans->status = 1;
                    $trans->save();
                    DB::commit();
                    $s = 1;
                    $m = "You successfully paid and acquired this service";
                } catch(\Exception $e) {
                    DB::rollBack();
                    $m = "Error ".$e->getMessage();
                }
        }
        } else {
            $m = $monnify_validate['m'];
        }

        return ['m' => $m, 's' => $s, 't' => $t];

    }


    public function validatePaystackWallets($req) {

        $validate = new \App\Http\Controllers\Payment\validatePaystacks;
        $s = 0;
        $t = "";
        if($validate->validateP($req->reference)['s'] == 1) {
            $id = $req->user_id;
            $quantity = $req->quantity;
            $user_id = $req->user_id;
            $item = User::find($id);
    
            if(!$item) {
                $m = "Invalid User or deleted user";
            } else {
                $trans = new \App\Models\UserModel\Wallet();
                $transaction_id = $req->reference;
                $t = $transaction_id;
                
                try {
                    DB::beginTransaction();
                    $trans->user_id = $user_id;
                    $trans->reference = $transaction_id;
                    $trans->amount = $req->amount;
                    $trans->type = "funding";
                    $trans->status = 1;
                    $trans->save();

                    try {

                        $user = User::find($id);
                        $amount = $user->balance + $req->amount;
                        $user->balance = $amount;
                        $user->save();
                        $s = 1;
                        $m = "You successfully fund your account with ". CUR.$req->amount;
                        DB::commit();

                    } catch(\Exception $e) {
                        DB::rollBack();
                        $m = "Error in funding ".$e->getMessage();
                    }

                } catch(\Exception $e) {
                    DB::rollBack();
                    $m = "Error ".$e->getMessage();
                }
        }
        } else {
            $m = $validate->validateP($req->reference)['m'];
        }

        return ['m' => $m, 's' => $s, 't' => $t];

    }

    public function validateMonnifyWallets($req) {

        $validate = new \App\Http\Controllers\Payment\PayMonnify;
        $s = 0;
        $t = "";
        $monnify_validate = $validate->verify($req->reference, $req->detectref);
        if($monnify_validate['s'] == 1) {
            $id = $req->user_id;
            $item = User::find($id);
    
            if(!$item) {
                $m = "Invalid user or deleted";
            } else {
                $trans = new \App\Models\UserModel\Wallet();
                $transaction_id = $req->detectref;
                $t = $transaction_id;
                
                try {
                    DB::beginTransaction();
                    $trans->reference = $transaction_id;
                    $trans->user_id = $id;
                    $trans->amount = $req->amount;
                    $trans->type = "funding";
                    $trans->status = 1;
                    $trans->save();

                    try {

                        $user = User::find($id);
                        $amount = $user->balance + $req->amount;
                        $user->balance = $amount;
                        $user->save();
                        $s = 1;
                        $m = "You successfully fund your account with ". CUR.$req->amount;
                        DB::commit();

                    } catch(\Exception $e) {
                        DB::rollBack();
                        $m = "Error in funding ".$e->getMessage();
                    }

                } catch(\Exception $e) {
                    DB::rollBack();
                    $m = "Error ".$e->getMessage();
                }
        }
        } else {
            $m = $monnify_validate['m'];
        }

        return ['m' => $m, 's' => $s, 't' => $t];

    }

}
