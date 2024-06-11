<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    //

    public function loginPage() {
        return view('user.login');
    }

     public function Register() {
        return view('main.auth.register');
    }

    public function Campaigns() {
        return view('user.campaigns-project');
    }

     public function Services() {
        return view('user.services.index');
    }

      public function Wishes() {
        return view('user.wish.index');
    }

        public function Wallet() {
        return view('user.wallet.add');
    }

    Public function Messages() {
        $id = Admin('id');

        $conversations = DB::table('conversations')
                            ->join('users as u', 'conversations.user_id_1', 'u.id')
                            ->where('conversations.user_id_1', Admin('id'))
                            ->orWhere('conversations.user_id_2', Admin('id'))
                            ->select('conversations.*', 'u.fullname', 'u.username', 'u.id as uid', 'u.status as ustatus', 'u.image', 'u.image_folder')
                            ->get();
                            ;
        return view('user.messages.index', ['conversations' => $conversations]);
    }

    public function ServiceRequirement(Request $request) {
        $transa = $request->trans;
        if(empty($transa)) {
            return redirect()->route('home');
        } else {
            $enrol = new \App\Models\UserModel\Service_enroll();

            $service = $enrol::where('transaction_id', $transa)->first();

            if(!$service) {
                return redirect()->route('home');
            } else {
                $id = $service->id;
                return view('user.services.requirement', ['id' => $id]);
            }

        }
    }
}
