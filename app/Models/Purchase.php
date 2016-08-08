<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchase';
//    protected $dates = ['purchase_date'];

    protected $fillable = ['user_id', 'order_id', 'amount', 'passport_id', 'purchase_date', 'payment_type', 'description', 'payment_result', 'error_message', 'tax'];
    
    public $timestamps = false;
    
    public function str_payment_result(){
        if($this->payment_result == 1){
            return trans('message.success');
        }
        return trans('message.falure');
    }
}
