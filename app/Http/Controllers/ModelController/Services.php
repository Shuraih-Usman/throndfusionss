<?php

namespace App\Http\Controllers\ModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel\Service;
use Illuminate\Support\Facades\DB;

class Services extends Controller
{
    //

    public function list($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = Service::query()
        ->select('s.id', 's.title', 's.user_id', 's.price', 's.image', 's.img_folder', 's.delivery_day', 's.status', 's.service_cat_id', 's.description', 's.created_at', 's.updated_at', 'u.username as username', 'c.title as cat_title', DB::raw('COUNT(se.service_id) as tc'))
        ->leftJoin('users as u', 's.user_id', '=', 'u.id')
        ->rightJoin('service_enrolls as se', 'se.service_id', '=', 's.id')
        ->leftJoin('service_cats as c', 's.service_cat_id', '=', 'c.id')
        ->groupBy('s.id', 's.title', 's.user_id', 's.price', 's.image', 's.img_folder', 's.delivery_day', 's.status', 's.service_cat_id', 's.description', 's.created_at', 's.updated_at', 'u.username', 'c.title')
        ->from('services as s');
    
    
        if ($filterData == 'Draft') {
            $query->where('s.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('s.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('s.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['s.id', 's.title', 's.status', 's.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = Service::count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {

            $image = '<img src="/images/'.$row->img_folder.$row->image.'" class="thumbnail" width="60" height="60"/>';
            $status = $row->status == 1 ? '<span class="badge bg-label-primary me-1">Active</span>' : '<span class="badge bg-label-warning me-1">Inactive</span>';

            

            $dropDown = '<div class="btn-group">
            <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" style="">';
    
            if ($row->status != 1) {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light activate" data-id="' . $row->id . '" href="#">Activate</a></li>';
            } else {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light text-warning draft" href="#" data-id="'.$row->id.'">Draft</a></li>';
            }
    
            $dropDown .= '<a class="dropdown-item waves-effect waves-light text-info edit" href="/admin/edit-user/' . $row->id . '">Edit</a></li>
                <li><a data-id="' . $row->id . '" class="dropdown-item waves-effect waves-light text-danger delete " href="#">Delete</a></li>
            </ul>
        </div>';

        $title = '<a href="javascript:void(0)" class="service_details" data-title="'.$row->title.'" data-price="'.$row->price.'" data-username="'.$row->username.'" data-delivery="'.$row->delivery_day.'" data-status="'.$row->status.'" data-cat_title="'.$row->cat_title.'" data-acquire="'.$row->tc.'" data-date="'.$row->created_at->format('d M, Y').'" data-description="'.htmlspecialchars($row->title).'" data-image="/images/'.$row->img_folder.$row->image.'">'.$row->title.'</a>';
    
            $rowData = [
               $row->id,
               $image,
               $title,
               $row->username,
               CUR.$row->price,
               $row->delivery_day,
               $row->tc,
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
                          $user = Service::find($id);
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
                          $user = Service::find($id);
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
                          $user = Service::find($id);
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
                        $user = Service::find($ids);
                        $user->status = 0;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break;
                    case 'activate':
                        $user = Service::find($ids);
                        $user->status = 1;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break; 
                    case 'delete':
                        $user = Service::find($ids);
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
