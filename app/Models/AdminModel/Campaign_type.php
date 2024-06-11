<?php

namespace App\Models\AdminModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign_type extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
    ];
    protected $table = "campaign_type";
}
