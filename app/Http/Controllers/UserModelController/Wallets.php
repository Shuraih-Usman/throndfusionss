<?php

namespace App\Http\Controllers\UserModelController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel\Wallet;
use App\Models\AdminModel\Withdraw_request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Wallets extends Controller
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
    
        $query = Wallet::query();
        $query->where('user_id', Admin('id'))
                ->get();



    
        if ($filterData == 'Closed') {
            $query->where('status', 0);
        } elseif ($filterData == 'Actived') {
            $query->where('status', 1);
        }
    
        if (!empty($searchValue)) {
            $query->where('type', 'LIKE', "%$searchValue%");
        }
    
        $columns = ['id', 'amount', 'reference', 'type', 'created_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? $columns[0];
        $orderDirection = isset($orderDirection) ? $orderDirection : 'desc';
    
        $query->orderBy($orderColumn, $orderDirection);
    
        $totalRecords = Wallet::where('user_id', Admin('id'))->count();
    
        $results = $query->skip($start)->take($length)->get();
        $totalFiltered = ($searchValue != '') ? $results->count() : $totalRecords;
    
        $data = [];
        foreach ($results as $row) {

            $status = $row->status == 1 ? '<span class="badge bg-label-primary me-1">Success</span>' : ($row->status == 2 ? '<span class="badge bg-label-warning me-1">Pending</span>' :'<span class="badge bg-label-danger me-1">Failed</span>' );

            

    
            $rowData = [
               $row->id,
               $row->amount,
               $row->type,
               $row->reference,
               $status,
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


    public function withdraw($request) {
        $s = 0;

        $validate = Validator::make($request->all(), [
            "amount" => "numeric|required|min:1000",
        ]);

        if($validate->fails()) {
            $m = $validate->errors()->first();
        } else {
            $wallet = new Wallet();

            DB::beginTransaction();

            try {

                $wallet->amount = $request->amount;
                $wallet->user_id = $request->user_id;
                $wallet->reference = $request->reference;
                $wallet->type = "widthrawal";
                $wallet->status = 2;
                $wallet->save();
                
                try {

                    $payment = new Withdraw_request();

                    $payment->amount = $request->amount;
                    $payment->user_id = $request->user_id;
                    $payment->reference = $request->reference;
                    $wallet->status = 2;
                    
                    $payment->save();
                    DB::commit();
                    $s = 1;
                    $m = TEXT['s_u_withraw'];
                }  catch(\Exception $e) {
                    DB::rollBack();
                    $m = $e->getMessage();
                }

            } catch(\Exception $e) {
                DB::rollBack();
                $m = TEXT['e_withdraw'];
            }
        }

        return ['m' => $m, 's' => $s];
        
    }
}
