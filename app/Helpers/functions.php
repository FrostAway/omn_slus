<?php

function c_auth() {
    return Auth::guard('customer');
}

/**
 * Show error or success message
 */
function show_messes($txt_class = null, $box_class = null) {
    $result = '';
    if (Session::has('errorMess')) {
        $result = '<div class="alert alert-warning alert-dismissible border_box ' . $box_class . '">'
                . '<div class="errorMess ' . $txt_class . '">' . Session::get('errorMess') . '</div></div>';
        Session::forget('errorMess');
    }
    if (Session::has('successMess')) {
        $result = '<div class="alert alert-dismissible border_box ' . $box_class . '">'
                . '<div class="successMess ' . $txt_class . '">' . Session::get('successMess') . '</div></div>';
        Session::forget('successMess');
    }
    return $result;
}

function show_pmesses() {
    $result = '';
    if (Session::has('errorMess')) {
        $result = '<p class="errorMess pmess">' . Session::get('errorMess') . '</p>';
        Session::forget('errorMess');
    }
    if (Session::has('successMess')) {
        $result = '<p class="successMess pmess">' . Session::get('successMess') . '</p>';
        Session::forget('successMess');
    }
    return $result;
}

/**
 * 
 * @param type $field field name
 * @param type $errors array errors
 * @return type
 */
function error_field($field, $errors = null) {
    $errors = ($errors) ? $errors : Session::get('errors');
    if (count($errors) > 0) {
        if ($errors->has($field)) {
            return '<div class="help-block alert alert-danger">' . $errors->first($field) . '</div>';
        }
    }
    return '';
}

/**
 * 
 * @param type $length string length
 * @return type random string
 */
function randomString($length = 17) {
    $str = "";
    $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

/**
 * 
 * @param type $length number length
 * @return type random number
 */
function randomNumber($length = 6) {
    $str = '';
    $chars = range('0', '9');
    $max = count($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $chars[$rand];
    }
    return $str;
}

/**
 * generate select form options
 * @param type $name select form name
 * @param type $min min value
 * @param type $max max value
 * @return string 
 */
function option_range($name, $min, $max, $selected = -1) {
    $html = '<select name="' . $name . '" class="fl_txt s_caret">';
    for ($i = $min; $i <= $max; $i++) {
        $s_text = ($i == $selected) ? 'selected' : '';
        $html.='<option ' . $s_text . ' value="' . $i . '">' . $i . '</option>';
    }
    $html.='</select>';
    return $html;
}

/**
 * generate random pincode
 * @param type $model
 * @return type
 */
function makePin($model) {
    $pincode = str_random(6);
    $custem = $model::where('pincode', $pincode)->first(['id']);
    if ($custem) {
        $pincode = makePin($model);
    }
    return $pincode;
}

/**
 * Make unique random folder name
 * @param type $model
 */
function makeDirName($model) {
    $dirname = str_random(8);
    $dir = $model::where('url', $dirname)->first(['id']);
    if ($dir) {
        $dirname = makeDirName($model);
    }
    return $dirname;
}

/**
 * Is current route active
 * @param type $route
 * @param type $active
 */
function isActive($route, $echo = true, $active = 'active') {
    if (request()->route()->getName() == $route) {
        if ($echo) {
            echo $active;
        } else {
            return true;
        }
    }
    return false;
}

/**
 * Generate request params
 * @return string
 */
function requestInput() {
    $html = '';
    foreach (request()->all() as $key => $value) {
        $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
    }
    return $html;
}

function getDateNextMonth($is_next=true) {
    if($is_next){
        $next_month = strtotime('+1 month');
    }else{
        $next_month = strtotime();
    }
    $next_month_day = date('d', $next_month);
    $last_day = cal_days_in_month(CAL_GREGORIAN, date('m', $next_month), date('Y', $next_month));
    $add_day_second = ($last_day - $next_month_day) * 24 * 60 * 60;
    $date = date('Y-m-d H:i:s', $next_month + $add_day_second);
    return $date;
}

