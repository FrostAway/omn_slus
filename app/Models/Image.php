<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    protected $table = 'images';
    protected $guarded = ['id'];
    
    public $timestamps = false;
    
    public function getSrc($image_type, $size = 'origin'){
        $image_sizes = config('app.image_sizes');
       
        if(!isset($image_sizes[$image_type])){
            return null;
        }
        $sizes = $image_sizes[$image_type];     
        if(!isset($sizes[$size])){
            return null;
        }
        
        $str_imgtypes = config('app.str_imgtypes');
        
        $srcdir = '/pub/'.$str_imgtypes[$image_type].'/'.$size.'/'.$this->url;
        $srcfiles = Storage::disk('s3')->files($srcdir);
        if(!$srcfiles){
            return null;
        }
        return Storage::disk('s3')->url($srcfiles[0]);
    }
    
    public function getImage($image_type, $size='origin', $class=null){
        if($src = $this->getSrc($image_type, $size)){
            return '<img class="img-responsive '.$class.'" src="'.$src.'" alt="No image">';
        }
        return null;
    }
}
