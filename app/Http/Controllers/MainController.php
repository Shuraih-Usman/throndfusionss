<?php

namespace App\Http\Controllers;
use App\Models\UserModel\Conversation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserModel\Service;
use App\Models\UserModel\Wishe;
use App\Models\UserModel\Campaign;
use App\Models\UserModel\Message;
use App\Models\AdminModel\Donation;
use App\Models\AdminModel\Investing;
class MainController extends Controller
{
    //

    public function index() {
        $service = Service::query()
        ->where('services.status', 1)
                    ->join('service_cats', 'services.service_cat_id', '=', 'service_cats.id')
                    ->join('users', 'services.user_id', '=', 'users.id')
                    ->select('services.*', 'service_cats.title as cat_title', 'service_cats.id as cat_id', 'users.username', 'users.image_folder as user_folder', 'users.image as user_image', 'users.role')
                    ->limit(8)
                    ->get();
        $wishes = Wishe::query()
        ->where('wishes.status', 1)
                    ->join('wishlists_types', 'wishes.wish_cat', '=', 'wishlists_types.id')
                    ->join('users', 'wishes.user_id', '=', 'users.id')
                    ->select('wishes.*', 'wishlists_types.title as cat_title', 'wishlists_types.id as cat_id', 'users.username', 'users.image_folder as user_folder', 'users.image as user_image')
                    ->limit(8)
                    ->get();
                    
     $campaigns = Campaign::query()
        ->where('campaigns.status', 1)
                    ->join('campaign_type as c', 'campaigns.campaign_type_id', '=', 'c.id')
                    ->join('users', 'campaigns.user_id', '=', 'users.id')
                    ->select('campaigns.*', 'c.title as cat_title', 'c.id as cat_id', 'users.username', 'users.image_folder as user_folder', 'users.image as user_image')
                    ->limit(10)
                    ->get(); 

        return view('main.index', ['services' => $service, 'wishes' => $wishes, 'campaigns' => $campaigns]);
    }

    public function log(Request $request, $log) {
        if($log == 'register') {
            $s = 0;
            $val = validator::make($request->all(), [
                'name' => 'required|string',
                'username' => 'required|alpha_num|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'confirmpassword' => 'required|same:password',
            ],
            [
                'password.min' => 'The password must be at least 8 characters.',
                'confirmpassword.same' => 'The confirmation password does not match the password.',
            ]
        );

        if($val->fails()) {
            $m = $val->errors()->first();
        } else {


            try {
                $user = new User();
                $user->fullname = $request->input('name');
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                $user->password = bcrypt($request->password);
                $user->role = $request->input('role');
                $user->save();
                Auth::login($user);
                $s = 1;
                $m = "Successfully registered You would be redirected to your dashboard";
            } catch(\Exception $e) {
                $m = "Error :".$e->getMessage();
            }
        }

        return response()->json(['m' => $m, 's' => $s]);

        } else if($log == 'mainlogin') {
            $s = 0;
            $cred = $request->only('email', 'password');

            if(empty($request->email) && empty($request->password)) {
                $m = "All fields are required";
            } else {
                
                if(Auth::attempt($cred)) {
                    $m = "Successfully Login";
                    $s = 1;
                } else {
                    $m = "Invalid Credentials";
                    $s = 0;   
                }
            }


            $check = ['m' => $m, 's' => $s];
            return response()->json($check);

        }
    }

    public function serviceView($id) 
    {

        
        $service = Service::find($id);

        if(!$service) {
            return view('404');
        } else {
            $service = $service->join('service_cats', 'services.service_cat_id', 'service_cats.id')
                ->where('services.id', $id)
                ->join('users', 'services.user_id', '=', 'users.id')
                ->select('services.*', 'service_cats.title as cat_title', 'users.username', 'users.image_folder as user_i_folder', 'users.image as u_image', 'users.role')
                ->first();
        
            return view('main.view.service', ['service' => $service]);
        }
        
    }

    public function ajax(Request $request, $type) {
        if($type == 'pay') {
            $s = 0;
            $m = "";
            $action = $request->action;

            if($action == 'services') {
              
                if($request->payment == 'paystack') {

                    $payment = new \App\Http\Controllers\MainController\Payments;
                    $vaildate = $payment->validatePaystackService($request);    
                    return response()->json($vaildate);
                } else if($request->payment == 'monnify') {

                    $payment = new \App\Http\Controllers\MainController\Payments;
                    $vaildate = $payment->validateMonnifyService($request);    
                    return response()->json($vaildate);
                }

              
            } else if($action == 'insert_payment') {
                $payment = new \App\Http\Controllers\MainController\Payments;

                $check =  $payment->add($request);
                return response()->json($check);
            } else if($action == 'addwallets') {

                if($request->payment == 'paystack') {

                    $payment = new \App\Http\Controllers\MainController\Payments;
                    $vaildate = $payment->validatePaystackWallets($request);    
                    return response()->json($vaildate);

                } else if($request->payment == 'monnify') {

                    $payment = new \App\Http\Controllers\MainController\Payments;
                    $vaildate = $payment->validateMonnifyWallets($request);    
                    return response()->json($vaildate);
                }

            } else if($action == "user_withdraw") {

                    $payment = new \App\Http\Controllers\UserModelController\Wallets;
                    $vaildate = $payment->withdraw($request);    
                    return response()->json($vaildate);
            }

        } else if($type == 'select_project') {
            $s = 0;
            $id = $request->id;
            $project = Campaign::find($id);

            if($project->type == 1) {
                $add = new Donation();
                
                try {
                    DB::beginTransaction();

                    $add->user_id = Admin('id');
                    $add->campaign_id = $id;
                    $add->amount = $request->amount;
                    $add->status = 1;
                    $add->save();

                    try  {
                        $project->current_amount += $request->amount;
                        $project->save();
                        DB::commit();
                        $s = 1;
                        $m = "You successfully donate $request->amount to this project";
                    } catch (\Exception $e) {
                        $m = "Error 1 :".$e->getMessage();
                        DB::rollBack();
                    }

                } catch (\Exception $e) {
                    $m = "Error 2 :".$e->getMessage();
                    DB::rollBack();
                }
                

            } else if($project->type == 2) {
                $add = new Investing();
                
                try {
                    DB::beginTransaction();

                    $add->user_id = Admin('id');
                    $add->campaign_id = $id;
                    $add->amount = $request->amount;
                    $add->shared = $project->shared_amount;
                    $add->stop_date = $project->invest_stop_date;
                    $add->status = 1;
                    $add->save();

                    try  {
                        $project->current_amount += $request->amount;
                        $project->save();
                        DB::commit();
                        $s = 1;
                        $m = "You successfully Invest $request->amount to this project";
                    } catch (\Exception $e) {
                        $m = "Error 1 :".$e->getMessage();
                        DB::rollBack();
                    }

                } catch (\Exception $e) {
                    $m = "Error 2 :".$e->getMessage();
                    DB::rollBack();
                }
            } 

            return response()->json(['m' => $m, 's' => $s]);

        } else if($type == 'action') {
            $action = $request->action;

            switch($action) {
                case 'service_send_message':
                    $s = 0;
                    $user_id = $request->user_id;
                    $creator_id = $request->creator_id;
                    

                    // Check if a conversation already exists between the two users
                    $conversation = Conversation::where(function($query) use ($user_id, $creator_id) {
                        $query->where('user_id_1', $user_id)
                            ->where('user_id_2', $creator_id);
                    })->orWhere(function($query) use ($user_id, $creator_id) {
                        $query->where('user_id_1', $creator_id)
                            ->where('user_id_2', $user_id);
                    })->first();

                    // If no conversation exists, create a new one
                    if(!$conversation) {
                        $conversation = new Conversation();
                        $conversation->user_id_1 = $user_id;
                        $conversation->user_id_2 = $creator_id;
                        $conversation->save();
                    }


                    

                    $converID = Conversation::where([
                        ['user_id_1', '=', $user_id],
                        ['user_id_2', '=',  $creator_id],
                    ])->orWhere([
                        ['user_id_1', '=', $creator_id],
                        ['user_id_2', '=',  $user_id],
                    ])->first();
                    
                    try {
                        $message = new Message();

                        $message->conversation_id = $converID->id;
                        $message->sender_id = $user_id;
                        $message->content = $request->message;
                        $message->save();
                        $m = "Message sent successfully";
                        $s = 1; 
                    } catch (\Exception $e) {
                        $m = $e->getMessage();
                    }
                    

                    
                    break;
                default:
                    $m = "Action not define";
                    $s = 0;
                    break;



            }

            return response()->json(['m' => $m, 's' => $s]);
        } else if($type == 'main') {
            $action = $request->action;

            switch($action) {
                case 'mainlogin':
                    $cred = $request->onlye('email', 'password');

                    if(Auth::attempt($cred)) {
                        $m = "Successfully Login";
                        $s = 1;
                    } else {
                        $m = "Invalid Credentials";
                        $s = 0;   
                    }
                    $check = ['m' => $m, 's' => $s];
                    break;
                default:
                    $check = ['m' => "Invalid Action", 's' => 0];
                    break;
            }

            return response()->json($check);
        }
    }
}
