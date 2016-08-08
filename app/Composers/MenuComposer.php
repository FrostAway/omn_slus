<?php

namespace App\Composers;

use Illuminate\View\View;

class MenuComposer {

    public function compose(View $view) 
    {
        $menus = [
            ['title' => 'about', 'route' => ''],
            ['title' => '運営会社', 'route' => ''],
            ['title' => '利用規約', 'route' => ''],
            ['title' => '個人情報保護方針', 'route' => ''],
            ['title' => '特定商取引法', 'route' => '']
        ];
        $view->with('menus', $menus);
    }

}
