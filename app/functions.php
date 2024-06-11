<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;

const APP_NAME = "Throne Fusion";
const APP_URLS = "http://127.0.0.1:8000";

define('APP_DESC', '');
define('CUR', 'N');
define("MONNIFY_API_KEY", "MK_TEST_J6GSNYYQ99");
define("MONNIFY_SECRET", "JQNCHSV27LJ8SDLP4A6GGDA2Z4XHB7G1");
function Admin($prob) {
    if(auth()->guard('admin')->check()) {
        return Admin::current()->$prob;
    } else if(auth()->check()) {
        return auth()->user()->$prob;
    } else {
        return null;
    }
}

function getRowData ($table, $column, $id) {

    $row = DB::table($table)
                ->where('id', $id)
                ->first();

    return $row->$column;
}

define('SERVICE_PERCENT', 20);

function getPercent($part, $num) {
    $val= ($part / 100) * $num;
    return $val;
}

const TEXT = [
    "e_withdraw" => "Error in withdrawal pls contact admin",
    "s_u_withraw" => "You successfully make withdrawal request pls wait for your withdrawal to proccess",
];