<?php

namespace App\Eloquents;

use Image;
use Storage;

class ImageEloquent {

    protected $model;

    public function __construct(\App\Models\Image $model) {
        $this->model = $model;
    }

    public function upload($file, $manage_type=1, $manage_id=1, $image_type=1) {
        
        //resize
        $randdir = makeDirName($this->model);
        $extension = $file->getClientOriginalExtension();
        $str_imgtypes = config('app.str_imgtypes');

        $typepath = 'pub/'.$str_imgtypes[$manage_type].'/';

        $m_image = Image::make($file);
        $width = $m_image->width();
        $height = $m_image->height();
        $ratio = $width/$height;

        $sizes = config('app.image_sizes')[$image_type];
        
        if($sizes){
            foreach ($sizes as $key => $value) {
                $w = $value['w'];
                $h = $value['h'];

                if($w==null && $h==null){
                    continue;
                }

                $rspath = $typepath. $key.'/'. $randdir.'/'.intval($w).'x'.intval($h).'.'. $extension;

                $crop = $value['crop'];
                $r = ($h == null) ? 0 : $w/$h;

                if($width > $w && $height > $h){
                    if($ratio > $r){
                        $rh = $h;
                        $rw = ($h == null) ? $w : $width*$h/$height;
                    }else{
                        $rw = $w;
                        $rh = ($w == null) ? $h : $height*$w/$width;
                    }
                    $sh = round(($rh-$h)/2);
                    $sw = round(($rw-$w)/2);

                    $rsImage = Image::make($file)->resize($rw, $rh, function($constraint){
                        $constraint->aspectRatio();
                    });
                    if($crop){
                        $rsImage->crop($w, $h, $sw, $sh);
                    }

                    Storage::disk('s3')->put($rspath, $rsImage->stream()->__toString());
                }
            }
        }
        // end resize
        
        $image = new $this->model();
        $image->manager_type = $manage_type;
        if($manage_type == 1){
            $image->customer_id = $manage_id;
        }
        $image->name = $file->getClientOriginalName();
        $image->url = $randdir;
        $image->image_type = $image_type;
        
        $image->save();
        return $image;
    }
    
     public function delete($image) {
         if(is_numeric($image)){
            $image = $this->model->find($image);
         }
         if($image){
             $type = $image->image_type;
             $str_imgtypes = config('app.str_imgtypes');
             $sizes = config('app.image_sizes')[$type];
             if($sizes){
                 $dir = 'pub/'.$str_imgtypes[$type].'/';
                 foreach ($sizes as $key => $size){
                     $path = $dir.$key.'/'.$image->url;
                     if(Storage::disk('s3')->exists($path)){
                        Storage::disk('s3')->deleteDirectory($path);
                     }
                 }
             }
             $image->delete();
         }
    }

}
