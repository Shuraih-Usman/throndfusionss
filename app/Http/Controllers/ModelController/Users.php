<?php

namespace App\Http\Controllers\ModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use App\Models\Admin;

class Users extends Controller
{
    //


    public function add(Request $request)
    {
        $s = 0;
        $m = "";

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string',
            'username' => 'required|alpha_num|unique:users',
            'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            'role' => 'required',
            'email' => 'required|string|unique:users',
            
            
        ]);

        if ($validator->fails()) {
            $m = $validator->errors()->first();
        } else {
            // Process image upload if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $folder = 'images/users/' . date('y/m/');
                $subfolder = 'users/' . date('y/m/');
                $image->move(public_path($folder), $imageName);
            } else {
                $imageName = null;
                $subfolder = null;
            }

            $user = new User();
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->image = $imageName;
            $user->image_folder = $subfolder;
            $user->password = bcrypt('12345678'); 
            $user->role = $request->role;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->address = $request->address;
            $user->organization = $request->organization;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->lga = $request->lga;
            $user->status = $request->has('status') ? 1 : 0;
            $user->save();
            $s = 1;
            $m = "You have successfully added a new user His passwoord is 12345678 .";
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
    
        $query = User::query();
    
        if ($filterData == 'Draft') {
            $query->where('status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('fullname', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['id', 'fullname', 'username', 'email', 'phone', 'status', 'created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = User::count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {
            $status = $row->status == 1 ? '<span class="badge bg-label-primary me-1">Active</span>' : '<span class="badge bg-label-warning me-1">Inactive</span>';

            $role = $row->role == 1 ? '<span class="badge bg-primary me-1">User</span>' : '<span class="badge bg-primary me-1">Creator</span>';


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
    
            $rowData = [
               $row->id,
               $row->fullname,
               $row->username,
               $row->email,
               $row->phone,
               $role,
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
        $table = 'Users';
        $admin = Admin::current();
        if ($admin->superAdmin != 1) {
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
                          $user = User::find($id);
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
                          $user = User::find($id);
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
                          $user = User::find($id);
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
                        $user = User::find($ids);
                        $user->status = 0;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break;
                    case 'activate':
                        $user = User::find($ids);
                        $user->status = 1;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break; 
                    case 'delete':
                        $user = User::find($ids);
                        $image = public_path('/images/'.$user->image_folder.$user->image);
                        unlink($image);
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

    public function edit($request) 
    {
        $s = 0;
        $id = $request->id;

        if(Admin::current()->superAdmin != 1 ) {
            $m = "Unauthorized action";
        } else {

            $validator = Validator::make($request->all(), [

                'fullname' => 'required|string',
                'username' => 'required|alpha_num|unique:users,username,'.$id,
                'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
                'role' => 'required',
                'email' => 'required|string|unique:users,email,'.$id,
            ]);

            if($validator->fails()) {
                $m = $validator->errors()->first();
            } else {

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $folder = 'images/users/' . date('y/m/');
                    $subfolder = 'users/' . date('y/m/');
                    $image->move(public_path($folder), $imageName);
                } else {
                    $imageName = $request->img;
                    $subfolder = $request->img_folder;
                }

            $user = User::findOrFail($id);
            $user->fullname = $request->fullname;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->image = $imageName;
            $user->image_folder = $subfolder;
            $user->role = $request->role;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->address = $request->address;
            $user->organization = $request->organization;
            $user->country = $request->country;
            $user->state = $request->state;
            $user->lga = $request->lga;
            $user->status = $request->has('status') ? 1 : 0;
            $user->save();
            $s = 1;
            $m = "You have successfully Update this user data .";

            }
        }


        return ['m' => $m, 's' => $s];
    }
}
