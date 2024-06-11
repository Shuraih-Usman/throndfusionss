<?php

namespace App\Http\Controllers\UserModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UserModel\Service;
use Illuminate\Support\Str;
use Carbon\Carbon;
class Services extends Controller
{
    //

    public function add(Request $request) {
        $s = 0;
    
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'image'=> 'required|image|mimes:jpg,jpeg,gif,png|max:2040',
                'category' => 'required',
                'price' => 'required|numeric',
                'delivery' => 'required|numeric',
                'description' => 'required|string',
            ]);
    
            if( $validator->fails() ) {
                $m = $validator->errors()->first();
            } else {
    
                $image = $request->file('image');
                $imageName = time() . '-' . rand(0, 9). '.' .$image->getClientOriginalExtension();
                $folder = 'images/services/' . date('y/m/');
                $subfolder = 'services/' . date('y/m/');

                while(file_exists($folder . $imageName)) {
                    $imageName = time() .'-'. rand(0, 9) . '.' .$image->getClientOriginalExtension();
                }

                $image->move(public_path($folder), $imageName);

                try {
                    DB::beginTransaction();

                    $campaign = new Service();
                    $campaign->title = $request->input('title');
                    $campaign->service_cat_id = $request->input('category');
                    $campaign->image = $imageName;
                    $campaign->img_folder = $subfolder;
                    $campaign->description = $request->input('description');
                    $campaign->user_id = Admin('id');
                    $campaign->status = 1;
                    $campaign->price =  $request->input('price');
                    $campaign->delivery_day = $request->input('delivery'); 
                    $campaign->save();
                    DB::commit();
                    $s = 1;
                    $m = "You successfully submitted a Service.";
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
    
        $query = Service::query();

  $query->join('service_cats as c', 'services.service_cat_id', '=', 'c.id')
        ->where('services.user_id', Admin('id'))
         ->select('services.*',  'c.title as category_title');

    
        if ($filterData == 'Closed') {
            $query->where('services.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('services.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('services.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['services.id', 'services.title', 'services.status', 'services.created_at'];
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
    
            $dropDown .= '<a class="dropdown-item waves-effect waves-light text-info edit" href="#" data-id="' . $row->id . '">Edit</a></li>
                <li><a data-id="' . $row->id . '" class="dropdown-item waves-effect waves-light text-danger delete " href="#">Delete</a></li>
            </ul>
        </div>';
    
            $rowData = [
               $row->id,
               $image,
               '<a href="javascript:void(0);" class="view" data-id="'.$row->id.'" data-name="'.$row->title.'" data-price="'.$row->price.'" data-delivery="'.$row->delivery_day.'" data-status="'.$row->status.'" data-image="'.$row->image.'" data-folder="'.$row->img_folder.'" data-cat="'.$row->category_title.'" data-desc="'.$row->description.'">'.$row->title .'</a>',
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
        $table = 'Service';

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
                    case 'closeAll':
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
                            $m = "$total $table where successfully Close";
                        } else {
                            $m = "Failed to close items";
                        }
                        break;
                    case 'close':
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
                        $image = public_path('/images/'.$user->img_folder.$user->image);
                        unlink($image);
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
        $campaign = Service::find($request->id);
        return $campaign;
    }


    public function edit($request) {
        $s = 0;
    
        if(Admin('role') != 2) {
            $m = "Only creators can create Fundraising projects";
        } else {
    
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
                    $campaign = Service::find($request->id);
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
    
        }
    
        return ['m' => $m, 's' => $s];
    }


    public function list_onwork_services($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = DB::table('service_enrolls')
                        ->join('services as s', 'service_enrolls.service_id', 's.id')
                        ->select('service_enrolls.*', 's.title as title', 's.user_id as user_id', 's.delivery_day as delivery', 's.img_folder as ifolder', 's.image as img')
                        ->where('s.user_id', Admin('id'));
    

    
        if (!empty($searchValue)) {
            $query->where('s.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['service_enrolls.id', 's.title', 'service_enrolls.status', 'service_enrolls.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = DB::table('service_enrolls')
                    ->join('services as s', 'service_enrolls.service_id', 's.id')
                    ->where('s.user_id', Admin('id'))->count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {



            $status = $row->status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : ($row->status == 2 ? '<span class="badge bg-label-warning me-1">Completed</span>' : '<span class="badge bg-label-danger me-1">Closed</span>');
            $image = '<img src="/images/'.$row->ifolder.$row->img.'" class="thumbnail" width="60" height="60"/>';

            $action = $row->status == 1 ? 'service_details' : ($row->status == 2 ? '' : '');

         

        $createdAt = Carbon::parse($row->created_at);

        $currentDate = new \DateTime();
        $targetDate = new \DateTime($createdAt->format('Y-m-d'));
        $interval = $currentDate->diff($targetDate);
        $daysDifference = $interval->days;

            $rowData = [ 
                $row->id,
                $image,
               '<a href="javascript:void(0)" class="'.$action.'" data-title="'.$row->title.'" data-amount="'.CUR.$row->total.'" data-quantity="'.$row->quantity.'"  data-date="'.$createdAt->format('d M, Y').'" data-status="'.$row->status.'" data-buyer_id="'.$row->buyer_id.'" data-id="'.$row->id.'" data-service_id="'.$row->service_id.'" data-delivery_date="'.$row->delivery.'" data-remain="'.$daysDifference.'" data-buyer="'.getRowData('users', 'username', $row->buyer_id).'"> '.$row->title.'</a>',
               $status,
               $createdAt->format('d M, Y'),
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

    public function deliver_service($data) {

        $s = 0;

        $validator = Validator::make($data->all(), [
            'image' => 'required|image|mimes:jpg,png,gif,wepb|max:2048',
            'proof' => 'required',
            'id' => 'required',
        ]);

        if($validator->fails()) {
            $m = $validator->errors()->first();
        } else {

            $image = $data->file('image');
            $imageName = time() . '-' . rand(0, 9). '.' .$image->getClientOriginalExtension();
            $folder = 'images/services/' . date('y/m/');
            $subfolder = 'services/' . date('y/m/');

            while(file_exists($folder . $imageName)) {
                $imageName = time() .'-'. rand(0, 9) . '.' .$image->getClientOriginalExtension();
            }

            $image->move(public_path($folder), $imageName);

            $enroll = new \App\Models\UserModel\Service_enroll;

            $service = $enroll::find($data->id);
            
            $service->proof_work = $data->proof;
            $service->img_folder = $subfolder;
            $service->image = $imageName;
            $service->status = 2;
            $service->save();
            $s = 1;
            $m = "You successfully finished and delivered this service pls wait to the buyer to confirm and release payment";

        }

        return ['m' => $m, 's' => $s];

    }


    public function purchase_services($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = DB::table('service_enrolls')
                        ->join('services as s', 'service_enrolls.service_id', 's.id')
                        ->select('service_enrolls.*', 's.title as title', 's.user_id as user_id', 's.delivery_day as delivery', 's.img_folder as ifolder', 's.image as img')
                        ->where('service_enrolls.buyer_id', Admin('id'));
    

    
        if (!empty($searchValue)) {
            $query->where('s.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['service_enrolls.id', 's.title', 'service_enrolls.status', 'service_enrolls.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = DB::table('service_enrolls')
                    ->join('services as s', 'service_enrolls.service_id', 's.id')
                    ->where('s.user_id', Admin('id'))->count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {



            $status = $row->status == 1 ? '<span class="badge bg-label-warning me-1">On Progress</span>' : ($row->status == 2 ? '<span class="badge bg-label-success me-1">Completed</span>' : '<span class="badge bg-label-danger me-1">Closed</span>');
            $image = '<img src="/images/'.$row->ifolder.$row->img.'" class="thumbnail" width="60" height="60"/>';

            $action = $row->status == 2 ? 'service_details' : ($row->status == 1 ? '' : '');

         

        $createdAt = Carbon::parse($row->created_at);

        $currentDate = new \DateTime();
        $targetDate = new \DateTime($createdAt->format('Y-m-d'));
        $interval = $currentDate->diff($targetDate);
        $daysDifference = $interval->days;

            $rowData = [ 
                $row->id,
                $image,
               '<a href="javascript:void(0)" class="'.$action.'" data-title="'.$row->title.'" data-amount="'.CUR.$row->total.'" data-quantity="'.$row->quantity.'"  data-date="'.$createdAt->format('d M, Y').'" data-status="'.$row->status.'" data-buyer_id="'.$row->buyer_id.'" data-id="'.$row->id.'" data-service_id="'.$row->service_id.'" data-delivery_date="'.$row->delivery.'" data-remain="'.$daysDifference.'" data-image="/images/'.$row->img_folder.$row->image.'" data-proof="'.$row->proof_work.'" data-buyer="'.getRowData('users', 'username', $row->buyer_id).'"> '.$row->title.'</a>',
               $status,
               $createdAt->format('d M, Y'),
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


    public function approve_service($data) {
        
        $m = "";
        $s = 0;
        $enroll = new \App\Models\UserModel\Service_enroll;
        $service = $enroll::find($data->id);

        if($service) {
            if($service->status == 1) {
                $m = "The service was not completed";
            } else if($service->status == 0) {
                $m = "The service was already released and approved by you";
            }  else {
    
                $percentage = getPercent(SERVICE_PERCENT, $service->total);
                $paying =  $service->total - $percentage;
        
                $service->status = 0;
                $service->save();
        
                $users = new \App\Models\User;
                $user_id = getRowData('services', 'user_id', $service->service_id);
                $user = $users::find($user_id);
        
                $adding = $user->balance + $paying;
                $user->balance = $adding;
                $user->save();
                $m = "Successfully approved this service";
                $s = 1;
            }
        } else {
            $m = "Service not found";
        }
 








        return ['m' => $m, 's' => $s];
    }
}
