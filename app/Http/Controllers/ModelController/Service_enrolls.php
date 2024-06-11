<?php

namespace App\Http\Controllers\ModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel\Service_enroll;
class Service_enrolls extends Controller
{
    
    public function list($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = Service_enroll::query()
        ->join('services as s', 'se.service_id', '=', 's.id')
        ->join('users as b', 'se.buyer_id', '=', 'b.id')
        ->join('users as u', 's.user_id', '=', 'u.id')
        ->selectRaw('se.*, u.username as username, b.username as buyername, s.description, s.delivery_day, s.image as s_img, s.img_folder as s_img_folder, s.title')
        ->from('service_enrolls as se');

        ;
    
    
        if ($filterData == 'Draft') {
            $query->where('se.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('se.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('s.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['se.id', 's.title', 'se.status', 'se.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = Service_enroll::count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {

            $image = '<img src="/images/'.$row->s_img_folder.$row->s_img.'" class="thumbnail" width="60" height="60"/>';
            $status = $row->status == 1 ? '<span class="badge bg-label-primary me-1">Completed</span>' : '<span class="badge bg-label-warning me-1">On Progress</span>';

            

            $dropDown = '<div class="btn-group">
            <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" style="">';
    
            if ($row->status != 1) {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light activate" data-id="' . $row->id . '" href="#">Complete it</a></li>';
                
                
            } else {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light text-warning draft" href="#" data-id="'.$row->id.'">Unfinish</a></li>';
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light admin_proof"  data-id="' . $row->id . '" href="javascript:void(0)" data-title="'.$row->title.'" data-transactionid="'.$row->transaction_id.'" data-proof="'.$row->proof_work.'" data-image="/images/'.$row->img_folder.$row->image.'">Proof</a></li>';
                
            }
            $dropDown .= '<li><a class="dropdown-item waves-effect waves-light  admin_requirement" href="javascript:void(0)" data-id="'.$row->id.'" data-title="'.$row->title.'" data-image="/images/'.$row->s_img_folder.$row->s_img.'" data-requirement="'.$row->requirements.'">Requirement</a></li>';
            $dropDown .= '<a class="dropdown-item waves-effect waves-light text-info edit" href="/admin/edit-user/' . $row->id . '">Edit</a></li>
                <li><a data-id="' . $row->id . '" class="dropdown-item waves-effect waves-light text-danger delete " href="#">Delete</a></li>
            </ul>
        </div>';

        $title = '<a href="javascript:void(0)" class="enroll_service_details" data-title="'.$row->title.'" data-price="'.$row->price.'" data-username="'.$row->username.'" data-buyername="'.$row->buyername.'" data-quantity="'.$row->quantity.'" data-total="'.$row->total.'" data-delivery="'.$row->delivery_day.'" data-status="'.$row->status.'" data-transactionid="'.$row->transaction_id.'" data-date="'.$row->created_at->format('d M, Y').'" data-description="'.htmlspecialchars($row->description).'" data-image="/images/'.$row->s_img_folder.$row->s_img.'">'.$row->title.'</a>';
    
            $rowData = [
               $row->id,
               $image,
               $title,
               $row->username,
               $row->buyername,
               CUR.$row->price,
               $row->delivery_day,
               $status,
               $dropDown,
               $row->created_at->format('d M, Y')
            ];
            $rowData = array_combine(range(0, count($rowData) - 1), array_values($rowData));
            $data[] = $rowData;
        }
    
        $response = [
            "draw" => (int)$draw,
            "recordsTotal" => (int)$totalRecords,
            "recordsFiltered" => (int)$totalFiltered,
            "columns" => 0, 
            "data" => $data
        ];
    
        return $response;
    }



    public function toStatus($request) {
        $s = 0;
        $errors = [];
        $type = $request->type;
        $ids = $request->ids;
        $table = 'Services';
        if (Admin('superAdmin') != 1) {
            $m = "Unauthorized action";
        } else {

            if(!$ids) {
                $m = "No item selected";
            } else if(!in_array($type, ['activateAll', 'draftAll', 'draft', 'activate', 'delete', 'deleteAll'])) {
                $m = "Invalid Action";
            } else {
                $total = 0;
    
                switch($type) {
                    case 'activateAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Service_enroll::find($id);
                          $user->status = 1;
                          $user->save();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total $table where successfully Activated";
                        } else {
                            $m = "Failed to activate items";
                        }
                        break;
                    case 'draftAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Service_enroll::find($id);
                          $user->status = 0;
                          $user->save();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total $table where successfully Drafted";
                        } else {
                            $m = "Failed to draft items";
                        }
                        break;
                    case 'deleteAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Service_enroll::find($id);
                          $user->delete();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total $table where successfully Deleted";
                        } else {
                            $m = "Failed to delete items";
                        }
                        break;
                    case 'draft':
                        $user = Service_enroll::find($ids);
                        $user->status = 0;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break;
                    case 'activate':
                        $user = Service_enroll::find($ids);
                        $user->status = 1;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break; 
                    case 'delete':
                        $user = Service_enroll::find($ids);
                        $s = 1; 
                        $m = "Item was successfully deleted";
                        break;
                    default:
                        $m = "Undefined action";
                        break;
                }
            }
        }

       
        
        return ['m' => $m, 's' => $s];
    }
}
