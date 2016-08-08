<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class PageController extends Controller
{
    protected $page;
    
    public function __construct(\App\Models\Page $page) {
        $this->page = $page;
    }
    
    public function show($id){
        $page = $this->page->find($id);
    }
}
