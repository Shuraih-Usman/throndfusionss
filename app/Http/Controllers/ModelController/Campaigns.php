<?php

namespace App\Http\Controllers\ModelController;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\UserModel\Campaign;
class Campaigns extends Controller
{
    //

    public function add(Request $request) {
        $s = 0;
    
        if(Admin('role') != 2) {
            $m = "Only creators can create Fundraising projects";
        } else {
    
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'project_type'=> 'required|string',
                'campaign_type' => 'required',
                'goal' => 'required|numeric',
                'description' => 'required|string',
                'image' => 'required|mimes:jpg,png,gif,webp,jpeg|max:2048',
            ], [
                'image.max' => 'Image size exceed 2MB pls select lower size'
            ]);
    
            if( $validator->fails() ) {
                $m = $validator->errors()->first();
            } else {

                $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
                $folder = 'campaigns/'.date('y/m/');
                $request->file('image')->move(public_path('images/'.$folder), $imageName);
    
                try {
                    DB::beginTransaction();
    
                    $campaign = new Campaign();
                    $campaign->title = $request->input('title');
                    $campaign->type = $request->input('project_type');
                    $campaign->campaign_type_id = $request->input('campaign_type');
                    $campaign->goal_amount = $request->input('goal');
                    $campaign->image = $imageName;
                    $campaign->img_folder = $folder;
                    $campaign->description = $request->input('description');
                    $campaign->user_id = Admin('id');
                    $campaign->status = 1;
                    $campaign->shared_amount =  $request->has('shared') ? $request->input('shared') : 0;
                    $campaign->invest_stop_date = $request->has('stopdate') ? $request->input('stopdate') : NULL; 
                    $campaign->save();
                    DB::commit();
                    $s = 1;
                    $m = "You successfully submitted a project. Please wait for Admin to confirm and approve it.";
                } catch (QueryException $e) {
                    DB::rollBack();
                    $m = "An error occurred while submitting the project. Please contact admins.";
                    Log::error($e->getMessage());
                }
    
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
    
        $query = DB::table('campaigns as c')
                ->join('users as u', 'c.user_id', '=', 'u.id')
                ->join('campaign_type as ct', 'c.campaign_type_id', '=', 'ct.id')
                ->selectRaw('c.*, u.username, ct.title as ct_title');
    
    
        if ($filterData == 'Closed') {
            $query->where('c.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('c.status', 2);
        }  elseif ($filterData == 'Pending') {
            $query->where('c.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['c.id', 'c.title', 'c.status', 'c.type', 'c.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = DB::table('campaigns')->count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {

            $donOrinv = 0;
            if($row->type == 1) {
                $donOrinv = DB::table('donations')->where('campaign_id', $row->id)->count();
            } else {
                $donOrinv = 0;
            }
            $type = $row->type == 1 ? 'Donation' : 'Investment';

            $title = '<a href="javascript:void(0)" class="inv_details" data-type="'.$row->type.'" data-title="'.htmlspecialchars($row->title).'" data-amount="'.htmlspecialchars(CUR.$row->current_amount).'" data-description="'.htmlspecialchars($row->description).'" data-category="'.htmlspecialchars($row->ct_title).'" data-goal="'.htmlspecialchars(CUR.$row->goal_amount).'" data-stop="'.htmlspecialchars($row->invest_stop_date).'" data-date="'.htmlspecialchars($row->created_at).'" data-share="'.htmlspecialchars($row->shared_amount).'" data-username="'.$row->username.'" data-status="'.htmlspecialchars($row->status).'"> '.htmlspecialchars($row->title).'</a>';


            $status = $row->status == 1 ? '<span class="badge bg-label-warning me-1">Pending</span>' : ($row->status == 2 ? '<span class="badge bg-label-success me-1">Active</span>' : '<span class="badge bg-label-danger me-1">Closed</span>');

            $dropDown = '<div class="btn-group">
            <button type="button" class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" style="">';
    
            if ($row->status != 1) {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light activate" data-id="' . $row->id . '" href="#">Activate</a></li>';
            } else {
                $dropDown .= '<li><a class="dropdown-item waves-effect waves-light text-warning draft" href="#" data-id="'.$row->id.'">Close</a></li>';
            }
    
            $dropDown .= '<a class="dropdown-item waves-effect waves-light text-info edit" href="#" data-id="' . $row->id . '">Edit</a></li>
                <li>
                
            </ul>
        </div>';

        $createdAt = Carbon::parse($row->created_at);

            $rowData = [
               $row->id,
               $type,
               $title,
               $row->username,
               CUR.$row->goal_amount,
               CUR.$row->current_amount,
               $donOrinv,
               $status,
               $dropDown,
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

    public function list_investment($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = DB::table('investings')
                        ->join('campaigns as c', 'investings.campaign_id', 'c.id')
                        ->select('c.title as title', 'c.goal_amount as goal', 'investings.amount as amount', 'shared_amount as shared', 'c.status as c_status', 'investings.status as p_status', 'investings.created_at as date', 'investings.stop_date as stop_date', 'investings.id as id', 'c.created_at as credate')
                        ->where('investings.user_id', Admin('id'));
    
        if ($filterData == 'Closed') {
            $query->where('investings.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('investings.status', 2);
        }  elseif ($filterData == 'Pending') {
            $query->where('investings.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('c.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['investings.id', 'c.title', 'investings.status', 'investings.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = DB::table('investings')->where('user_id', Admin('id'))->count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {



            $status = $row->p_status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : ($row->status == 2 ? '<span class="badge bg-label-warning me-1">Pending</span>' : '<span class="badge bg-label-danger me-1">Closed</span>');

         

        $createdAt = Carbon::parse($row->date);

            $rowData = [ 
                $row->id,
               '<a href="javascript:void(0)" class="inv_details" data-title="'.$row->title.'" data-amount="'.CUR.$row->amount.'" data-goal="'.CUR.$row->goal.'" data-stop="'.$row->stop_date.'" data-date="'.$row->date.'" data-share="'.$row->shared.'" data-pr_status="'.$row->c_status.'" data-cre_date="'.$row->credate.'" data-p_status="'.$row->p_status.'"> '.$row->title.'</a>',
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


    public function list_donations($request) 
    {
        
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
    
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
    
        $filterData = $request->input('filterdata');
    
        $query = DB::table('donations')
                        ->join('campaigns as c', 'donations.campaign_id', 'c.id')
                        ->select('c.title as title', 'c.goal_amount as goal', 'donations.amount as amount', 'c.status as c_status', 'donations.status as p_status', 'donations.created_at as date', 'donations.id as id', 'c.created_at as credate')
                        ->where('donations.user_id', Admin('id'));
    
        if ($filterData == 'Closed') {
            $query->where('donations.status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('donations.status', 2);
        }  elseif ($filterData == 'Pending') {
            $query->where('donations.status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('c.title', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['donations.id', 'c.title', 'donations.status', 'donations.created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = DB::table('donations')->where('user_id', Admin('id'))->count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {



            $status = $row->p_status == 1 ? '<span class="badge bg-label-success me-1">Active</span>' : ($row->status == 2 ? '<span class="badge bg-label-warning me-1">Pending</span>' : '<span class="badge bg-label-danger me-1">Closed</span>');

         

        $createdAt = Carbon::parse($row->date);

            $rowData = [ 
                $row->id,
               '<a href="javascript:void(0)" class="don_details" data-title="'.$row->title.'" data-amount="'.CUR.$row->amount.'" data-goal="'.CUR.$row->goal.'"  data-date="'.$row->date.'" data-pr_status="'.$row->c_status.'" data-cre_date="'.$row->credate.'" data-p_status="'.$row->p_status.'"> '.$row->title.'</a>',
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


    public function toStatus($request) {
        $s = 0;
        $errors = [];
        $type = $request->type;
        $ids = $request->ids;
        $table = 'Campaigns';
        if (Admin('role') != 2) {
            $m = "Unauthorized action";
        } else {

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
                          $user = Campaign::find($id);
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
                          $user = Campaign::find($id);
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
                        $user = Campaign::find($ids);
                        $user->status = 0;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break;
                    case 'activate':
                        $user = Campaign::find($ids);
                        $user->status = 1;
                        $user->save();
                        $s = 1; 
                        $m = "Item was successfully updated";
                        break;
                    default:
                        $m = "Undefined action";
                        break;
                }
            }
        }

       
        
        return ['m' => $m, 's' => $s];
    }

    public function getRow($request) {
        $campaign = Campaign::find($request->id);
        return $campaign;
    }


    public function edit($request) {
        $s = 0;
    
        if(Admin('role') != 2) {
            $m = "Only creators can create Fundraising projects";
        } else {
    
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'campaign_type' => 'required',
                'goal' => 'required|numeric',
                'description' => 'required|string',
            ]);
    
            if( $validator->fails() ) {
                $m = $validator->errors()->first();
            } else {
    
                try {
                    DB::beginTransaction();
                    $campaign = Campaign::find($request->id);
                    $campaign->title = $request->input('title');
                    $campaign->campaign_type_id = $request->input('campaign_type');
                    $campaign->goal_amount = $request->input('goal');
                    $campaign->description = $request->input('description');
                    $campaign->user_id = Admin('id');
                    $campaign->status = 1;
                    $campaign->save();
                    DB::commit();
                    $s = 1;
                    $m = "Edited Successfully ";
                } catch (QueryException $e) {
                    DB::rollBack();
                    $m = "An error occurred while submitting the project. Please contact admins. ".$e->getMessage();
                    Log::error($e->getMessage());
                }
    
            }
    
        }
    
        return ['m' => $m, 's' => $s];
    }
}
