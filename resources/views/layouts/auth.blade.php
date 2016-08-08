<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'Home')</title>

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/uweb/css/main.css">

        <script src="/js/jquery.min.js"></script>

        @yield('head')
    </head>
    <body>

        <header>
            <div class="container">
            <nav class="navbar navbar-default" style="background: transparent; border: none;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bsmenu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hidden-md hidden-lg" href="#">Menu</a>
                </div>

                <div class="collapse navbar-collapse" id="bsmenu">
                    <ul class="nav navbar-nav navbar-right">
                        @if(auth()->guard('customer')->check())
                        <li><a href="{{route('uw.logout')}}">Logout</a></li>
                        @else
                        <li class="{{isActive('uw.get_reg_mail')}}"><a href="{{ route('uw.get_reg_mail') }}">Register</a></li>
                        <li class="{{isActive('uw.get_login')}}"><a href="{{ route('uw.get_login') }}">Login</a></li>
                        @endif
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            </div>
            @yield('header')
        </header>

        <section>
            <div class="container">
                @yield('content')
            </div>
        </section>

        <footer>

        </footer>

        <script src="/js/bootstrap.min.js"></script>
        <script src="/uweb/js/main.js"></script>
        @yield('foot')
    </body>
</html>
