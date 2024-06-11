<?php

namespace App\Http\Controllers\UserModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel\Conversation;
use App\Models\UserModel\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class Messages extends Controller
{
    //

    public function list() {

        $id = Admin('id');

        $conversations = DB::table('conversations')
                            ->join('users as u', 'conversations.user_id_1', 'u.id')
                            ->where('conversations.user_id_1', Admin('id'))
                            ->orWhere('conversations.user_id_2', Admin('id'))
                            ->select('conversations.*', 'u.fullname', 'u.username', 'u.id as uid', 'u.status as ustatus', 'u.image', 'u.image_folder')
                            ->orderBy('conversations.id', 'desc')
                            ->get();
                            ;

        $html = '
        <div class="">

        <button id="toggleNav" class="btn btn-primary d-md-none">Users</button>

            <div id="navContainer" class="">
            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Users</h5>
          <div class="card">
            <div class="card-body">
                <div class="d-md-flex flex-md-column">
               

                  
                 
              <ul class="list-unstyled mb-0 scrollable-list-container" style="max-height: 400px; overflow-y: auto;">';

              foreach($conversations as $item) {

                if($item->user_id_1 != Admin('id')) {
                  $user_id = $item->user_id_1;
                } else {
                  $user_id = $item->user_id_2;
                }

                $image = '/images/'.getRowData('users', 'image_folder', $user_id).getRowData('users', 'image', $user_id);
                $fullname = getRowData('users', 'fullname', $user_id);
                $html .= '<li class="p-2 border-bottom" style="background-color: #eee;">
                <a href="#" class="d-flex justify-content-between user_message_conversation" data-id="'.$item->id.'">
                  <div class="d-flex flex-row">
                  <img src="'.$image.'" alt="'.$fullname.'"
                  class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60" height="60">
                  <div class="pt-1">
                        <p class="fw-bold mb-0">'.$fullname.'</p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="small text-muted mb-1">Just now</p>
                      <span class="badge bg-danger float-end">1</span>
                    </div>
                  </a>
                </li>';
              }
             $html .= '</ul>          </div>

             </div>
           </div>
      
         </div>
      '   ;
              
        return $html;
    }


    public function message() {

      $model = DB::table('conversations')
      ->where('user_id_1', Admin('id'))
      ->orWhere('user_id_2', Admin('id'))
      ->latest('id') 
      ->first();

      $id = $model->id;

      return $this->get_message($id);


    }

    public function get_message($id) {

      $messages = DB::table('messages')
      ->join('conversations as c', 'messages.conversation_id', 'c.id')
      ->where('conversation_id', $id)
      ->select('messages.*', 'c.user_id_1', 'c.user_id_2')
      ->get();

      $html = '
      <div class="">
      <ul class="list-unstyled">';

      foreach($messages as $mess) {

        $currentUserIsAdmin = ($mess->sender_id == Admin('id'));
        $user_id = $currentUserIsAdmin ? Admin('id') : (($mess->sender_id != Admin('id')) ? $mess->sender_id : $mess->user_id_2);
        $image = '/images/'.getRowData('users', 'image_folder', $user_id).getRowData('users', 'image', $user_id);
        $fullname = getRowData('users', 'fullname', $user_id);

        if($currentUserIsAdmin) {

          $html .= '        <li class="d-flex justify-content-between mb-4">
          <div class="card w-100">
            <div class="card-header d-flex justify-content-between p-3" >
              <p class="fw-bold mb-0">'.$fullname.'</p>
              <p class="text-muted small mb-0"><i class="far fa-clock"></i> '.\Carbon\Carbon::parse($mess->created_at)->diffForHumans().'</p>
            </div>
            <div class="card-body">
              <p class="mb-0">
                '.$mess->content.'
              </p>
            </div>
          </div>
          <img src="'.$image.'" alt="avatar"
            class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60" height="60">
        </li>';
        }
        
        if(!$currentUserIsAdmin) {

          $html .= ' <li class="d-flex justify-content-between mb-4">
          <img src="'.$image.'" alt="avatar"
            class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60" height="60">
          <div class="card w-100">
            <div class="card-header d-flex justify-content-between p-3">
              <p class="fw-bold mb-0">'.$fullname.'</p>
              <p class="text-muted small mb-0"><i class="far fa-clock"></i> '.\Carbon\Carbon::parse($mess->created_at)->diffForHumans().'</p>
            </div>
            <div class="card-body">
              <p class="mb-0">
                '.$mess->content.'
              </p>
            </div>
          </div>
        </li>';
        }
      }

     $html .= '

        <li class="bg-white mb-3 p-2">
        
          <div data-mdb-input-init class="form-outline">
            <textarea class="form-control" id="textarea_message" name="" rows="4"></textarea>
            <label class="form-label" for="message">Message</label>
          </div>
        </li>
        <input type="hidden" id="messages_conversation_id" name="conversation_id" value="'.$id.'">
        <input type="hidden" id="messages_user_id" name="user_id" value="'.Admin('id').'">
        <input type="hidden" id="message_action" name="action" value="conver_message">
        <button type="button" id="conver_message" class="btn btn-info btn-rounded float-end">Send</button>
      </ul>

    </div>
    ';

    return $html;

    }

    public function add($data) {
      $s = 0;
      
      $validate = Validator::make($data->all(), [
        "message" => "required"
      ]);

      if($validate->fails()) {
        $m = $validate->errors()->first();
      } else {

        $message = new Message();
        $message->sender_id = $data->user_id;
        $message->content = $data->message;
        $message->conversation_id = $data->conversation_id;
        $message->save();
        $s = 1;
        $m = $this->get_message($data->conversation_id);
      }

      return ['s' => $s, 'm' => $m];
    }
}
