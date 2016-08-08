<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable {

    protected $table = 'customers';
    protected $guarded = ['id'];
    protected $hidden = [
        'passwd'
    ];
    protected $dates = ['birthday', 'ctime', 'mtime', 'dtime', 'create_time'];
    protected $dateFormat = 'Y-m-d H:i:s';
    public $timestamps = false;

    public function getAuthPassword() {
        return $this->passwd;
    }

    public function setRememberToken($value) {
        
    }

    public function getRememberToken() {
        return null;
    }

    // Relationships
    public function avatar() {
        return $this->hasOne('App\Models\Image', 'id', 'image_id');
    }

    /**
     * Get html avatar image
     * @param type $img_type
     * @param type $size
     * @param type $class
     * @return string or null
     */
    public function avtImg($img_type, $size = 'thumbnail', $class = null) {
        if ($this->avatar) {
            return $this->avatar->getImage($img_type, $size, $class);
        }
        return null;
    }

    public function passport() {
        
    }

    public function hasPassport() {
        $item = self::join('customers_passports as cp', function($join) {
                    $join->on('customers.id', '=', 'cp.customer_id')
                    ->where('to_date', '>', date('Y-m-d H:i:s'))
                    ->where('set_flag', '=', 1);
                })
                ->find($this->id, ['cp.passport_id']);
        if ($item) {
            return true;
        }
        return false;
    }

    public function getPassport() {
        $item = self::join('customers_passports as cp', function($join) {
                    $join->on('customers.id', '=', 'cp.customer_id')
                    ->where('to_date', '>', date('Y-m-d H:i:s'))
                    ->where('set_flag', '=', 1);
                })
                ->join('passports as pp', 'cp.passport_id', '=', 'pp.id')
                ->where('customers.id', $this->id)
                ->select('pp.*', 'cp.next_passport_id')
                ->first();
        return $item;
    }

    /**
     * Get customer gender text
     * @return string
     */
    public function gender() {
        if ($this->gender == 1) {
            return '女性';
        } else if ($this->gender == 2) {
            return '男性';
        }
        return '指定なし';
    }

}
