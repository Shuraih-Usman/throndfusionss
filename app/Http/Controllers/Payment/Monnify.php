<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class Monnify extends Controller
{
    //

    protected $authH; 
    protected $accessToken;
    
    // this function is called everytime this class is instantiated		
    public function __construct( ){

        try{
            $auth = $this->authH = base64_encode(MONNIFY_API_KEY.":".MONNIFY_SECRET);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://sandbox.monnify.com/api/v1/auth/login/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',

                ));
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(

                "Authorization: Basic $auth"

                ));
                $response = json_decode(curl_exec($curl), true);
                curl_close($curl);

                if(!isset($response['responseBody']['accessToken'])) {
                    return false;
                } else {

                 $access_token = $this->accessToken = $response['responseBody']['accessToken'];
                }
                
        } catch(\Exception $e){
         Log::error($e->getMessage());   
        }			
        
    }

    public function initTrans($data = []){
        $newData = json_encode($data);
        $curl = curl_init();
        $auth = $this->authH;
        try{
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://sandbox.monnify.com/api/v1/merchant/transactions/init-transaction',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $newData,
                CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.$auth.'',
                'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response, true);
            return($res);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());   
        }	
    }

    public function verifyTrans($transRef){
        $ref = urlencode($transRef);
        $accessToken = $this->accessToken;
        try{
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://sandbox.monnify.com/api/v2/transactions/'.$ref.'',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET'
                ));
            //Use bearer when dealing with oauth 2
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer $accessToken"
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response, true);
            return($res['responseBody']);
        }catch(\Exception $e){
            Log::error($e->getMessage());    
        }	
    }



    public function index($ref)
        {
            $ref = urlencode($ref);
            $accessToken = $this->getAccessToken();
            $curl = curl_init();
            curl_setopt_array($curl, array(CURLOPT_URL => 'https://sandbox.monnify.com/api/v2/transactions/' . $ref . '', 
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => '', 
            CURLOPT_MAXREDIRS => 10, 
            CURLOPT_TIMEOUT => 0, 
            CURLOPT_FOLLOWLOCATION => true, 
            CURLOPT_HTTP_VERSION => 
            CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => 'GET'));
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array("Authorization: Bearer $accessToken")
            );
            $response = curl_exec($curl);
            curl_close($curl);
            $res = json_decode($response, true);
            $responseBody = $res['responseBody'];

            return $responseBody;
        }


   public  function getAccessToken()
        {
            $auth = base64_encode(MONNIFY_API_KEY.":".MONNIFY_SECRET);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://sandbox.monnify.com/api/v1/auth/login/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
            ));
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic $auth"));
            $response = json_decode(curl_exec($curl), true);
            curl_close($curl);
            //Assign accessToken to var
            $access_token = $response['responseBody']['accessToken'];
            return $access_token;
        }


}
