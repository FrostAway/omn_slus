<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CusTemp extends Model
{
    protected $table = 'customers_tentative';
    protected $guarded = ['id'];
    
    public $timestamps = false;
}
