<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'My top')</title>

        <link rel="stylesheet" href="/css/fonts.css">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/uweb/css/main.css">
        <link rel="stylesheet" href="/uweb/css/screen.css">

        <script src="/js/jquery.min.js"></script>
       
        @yield('head')
    </head>
    <body class="@yield('body_class', 'home')">

        <header>
            <nav class="" id="topnav">
                <div class="container-fluid">
                    <div class="row">
                        <div class="nav_toggle btn-group col-xs-2">
                            <button type="button" class="btn_toggle dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></button>
                            <ul class="nav_menus dropdown-menu">
                                @if(c_auth()->check())
                                <li><a href="{{route('uw.mytop')}}"><i class="fa fa-shopping-cart"></i> My top</a></li>
                                <li><a href="{{route('uw.profile')}}"><i class="fa fa-user"></i> Profile</a></li>
                                <li><a href="{{route('uw.logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="nav_brand col-xs-8"><h1 class="head-title text-uppercase text-center">@yield('head_title', 'Global top')</h1></div>
                        <div class="col-xs-2 text-right">
                            <a href="#" class="btn_setting"><i class="fa fa-gear"></i></a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <section id="main_body">
            <div class="container">
                @yield('content')
            </div>
        </section>

        <footer>
            <nav id="footnav">
                <div class="container">
                    <ul class="list-unstyled mgb-0">
                        <li><a href="uw-083-80.php">About</a></li>
                        <li><a href="uw-000.php">新規登録</a></li>
                        <li><a href="#">運営会社</a></li>
                        <li><a href="#">プライバシーポリシー</a></li>
                        <li><a href="uw-083-80.php">お問い合わ</a></li>
                        <li><a href="uw-084.php">特定商取引法</a></li>
                        <li><a href="uw-085.php">利用規約</a></li>
                    </ul>
                </div>
            </nav>
        </footer>

        <script src="/js/bootstrap.min.js"></script>
        <script src="/uweb/js/main.js"></script>
        
        @yield('foot')

    </body>
</html>
