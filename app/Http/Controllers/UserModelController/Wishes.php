<?php

namespace App\Http\Controllers\UserModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UserModel\Wishe;
use Illuminate\Support\Str;
class Wishes extends Controller
{
    //

    public function add(Request $request) {
        $s = 0;
    
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'category' => 'required',
                'address' => 'required',
                'phone' => 'required|numeric',
                'description' => 'required|string',
                'image' => 'required|mimes:jpg,png,gif,jpeg|max:2048',
            ]);
    
            if( $validator->fails() ) {
                $m = $validator->errors()->first();
            } else {
    
                $image = $request->file('image');
                $imageName = time(). '.' .$image->getClientOriginalExtension();
                $folder = 'images/wishes/' . date('y/m/');
                $subfolder = 'wishes/' . date('y/m/');

                while(file_exists($folder . $imageName)) {
                    $imageName = time() .'-'. rand(0, 9) . '.' .$image->getClientOriginalExtension();
                }

                $image->move(public_path($folder), $imageName);

                try {
                    DB::beginTransaction();

                    $campaign = new Wishe();
                    $campaign->title = $request->input('title');
                    $campaign->wish_cat = $request->input('category');
                    $campaign->description = $request->input('description');
                    $campaign->address = $request->input('address');
                    $campaign->phone = $request->input('phone');
                    $campaign->user_id = Admin('id');
                    $campaign->image = $imageName;
                    $campaign->img_folder = $subfolder;
                    $campaign->status = 1;
                    $campaign->save();
                    DB::commit();
                    $s = 1;
                    $m = "You successfully submitted a Wish.";
                } catch (\Exception $e) {
                    DB::rollBack();
                    $m = "An error occurred while submitting. Please contact admins.";
                    Log::error($e->getMessage());
                }
    
            }
    
        
    
        return ['m' => $m, 's' => $s];
    }
    

    public function list($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = Wishe::query();

  $query->join('wishlists_types as c', 'wishes.wish_cat', '=', 'c.id')
      ->select('wishes.*',  'c.title as category_title')
      ->where('wishes.user_id', Admin('id'));

    
        if ($filterData == 'Closed') {
            $query->where('wishes.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('wishes.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('wishes.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['wishes.id', 'wishes.title', 'wishes.status', 'wishes.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = Wishe::count();
    
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
    
            $dropDown .= '<a class="dropdown-item waves-effect waves-light text-info edit" href="#" data-id="' . $row->id . '">Edit</a></li>
                <li><a data-id="' . $row->id . '" class="dropdown-item waves-effect waves-light text-danger delete " href="#">Delete</a></li>
            </ul>
        </div>';
    
            $rowData = [
               $row->id,
               $image,
               $row->title,
               $row->categor_title,
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
        $table = 'Wishes';

            if(!$ids) {
                $m = "No item selected";
            } else if(!in_array($type, ['activateAll', 'closeAll', 'close', 'activate', 'delete', 'deleteAll'])) {
                $m = "Invalid Action";
            } else {
                $total = 0;
    
                switch($type) {
                    case 'activateAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Wishe::find($id);
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
                    case 'closeAll':
                        foreach($ids as $id) {
                            if(!$id) {
                                continue;
                            }
                          $user = Wishe::find($id);
                          $user->status = 0;
                          $user->save();
                          $total++;
                            
                        }
    
                        if($total > 0) {
                            $s = 1;
                            $m = "$total $table where successfully Close";
                        } else {
                            $m = "Failed to close items";
                        }
                        break;
                    case 'close':
                        $user = Wishe::find($ids);
                        $user->status = 0;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break;
                    case 'activate':
                        $user = Wishe::find($ids);
                        $user->status = 1;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break;
                     case 'delete':
                        $user = Wishe::find($ids);
                        
                        $user->delete();
                        $s = 1; 
                        $m = "Item was deleted successfully";
                        break;                   
                    default:
                        $m = "Undefined action";
                        break;
                }
            }
        

       
        
        return ['m' => $m, 's' => $s];
    }

    public function getRow($request) {
        $campaign = Wishe::find($request->id);
        return $campaign;
    }


    public function edit($request) {
        $s = 0;
    
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'category' => 'required',
                'price' => 'required|numeric',
                'delivery' => 'required|numeric',
                'description' => 'required|string',
            ]);
    
            if( $validator->fails() ) {
                $m = $validator->errors()->first();
            } else {

                if($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '-' . rand(0, 9). '.' .$image->getClientOriginalExtension();
                    $folder = 'images/services/' . date('y/m/');
                    $subfolder = 'services/' . date('y/m/');
    
                    while(file_exists($folder . $imageName)) {
                        $imageName = time() .'-'. rand(0, 9) . '.' .$image->getClientOriginalExtension();
                    }
    
                    $image->move(public_path($folder), $imageName);

                } else {
                    $subfolder = $request->input('hiddenfolder');
                    $imageName = $request->input('hiddenimg');
                }
    
                try {
                    DB::beginTransaction();
                    $campaign = Wishe::find($request->id);
                    $campaign->title = $request->input('title');
                    $campaign->service_cat_id = $request->input('category');
                    $campaign->image = $imageName;
                    $campaign->img_folder = $subfolder;
                    $campaign->description = $request->input('description');
                    $campaign->price =  $request->input('price');
                    $campaign->delivery_day = $request->input('delivery'); 
                    $campaign->save();
                    DB::commit();
                    $s = 1;
                    $m = "Edited Successfully ";
                } catch (\Exception $e) {
                    DB::rollBack();
                    $m = "An error occurred while submitting the project. Please contact admins. ".$e->getMessage();
                    Log::error($e->getMessage());
                }
    
            }
    
        
    
        return ['m' => $m, 's' => $s];
    }
}
