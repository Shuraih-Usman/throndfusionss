<?php

namespace App\Http\Controllers\ModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminModel\Wishlist_item;

class wishlist_items extends Controller
{
    //

    public function add($request)
    {
        $s = 0;
        $m = "";

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'image' => 'required|image|mimes:jpg,gif,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            $m = $validator->errors()->first();
        } else {
            
            $image = $request->file('image');
            $imageName = time().'.' . $image->getClientOriginalExtension();
            $folder = 'images/wishes/' . date('y/m/');
            $subfolder = 'wishes/' . date('y/m/');
            $image->move(public_path($folder), $imageName);

            $user = new wishlist_item();
            $user->name = $request->title;
            $user->description = $request->description;
            $user->price = $request->price;
            $user->img = $imageName;
            $user->img_folder = $subfolder;
            $user->save();
            $s = 1;
            $m = "You have successfully added a new Item";
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
    
        $query = wishlist_item::query();
    
        if ($filterData == 'Draft') {
            $query->where('status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('name', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['id', 'name', 'status', 'created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = wishlist_item::count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {
            $image = '<img src="/images/'.$row->img_folder.$row->img.'" class="thumbnail" width="60" height="60"/>';
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
               $row->name,
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
        $table = 'Item';
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
                          $user = wishlist_item::find($id);
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
                          $user = wishlist_item::find($id);
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
                          $user = wishlist_item::find($id);
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
                        $user = wishlist_item::find($ids);
                        $user->status = 0;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break;
                    case 'activate':
                        $user = wishlist_item::find($ids);
                        $user->status = 1;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break; 
                    case 'delete':
                        $user = wishlist_item::find($ids);
                        $user->delete();
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

    public function edit($request) {
        $s = 0;
    
     
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'image' => 'image"mimes:jpg,gif,png,jpeg,webp|max:2048'

            ]);
    
            if( $validator->fails() ) {
                $m = $validator->errors()->first();
            } else {
    
                try {
                    
                    if($request->has('image')) {
                        $image = $request->file('image');
                        $imageName = time().'.' . $image->getClientOriginalExtension();
                        $folder = 'images/wishes/' . date('y/m/');
                        $subfolder = 'wishes/' . date('y/m/');
                        $image->move(public_path($folder), $imageName);
                    } else {
                        $imageName = $request->img;
                        $subfolder = $request->img_folder;
                    }

        
                    $user = wishlist_item::find($request->id);
                    $user->name = $request->title;
                    $user->price = $request->price;
                    $user->description = $request->description;
                    $user->img = $imageName;
                    $user->img_folder = $subfolder;
                    $user->save();
                    $s = 1;
                    $m = "Edited Successfully ";
                } catch (\Exception $e) {
                    $m = "Error. ".$e->getMessage();
                }
    
            }
    
        
    
        return ['m' => $m, 's' => $s];
    }


    public function getRow($request) {
        $campaign = wishlist_item::find($request->id);
        return $campaign;
    }


}
