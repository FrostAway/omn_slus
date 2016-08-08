<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Editor</title>

        <link rel="stylesheet" href="/css/bootstrap.min.css">

        <script src="/js/jquery.min.js"></script>
        <script src="/js/jquery-ui.min.js"></script>
        <script src="/js/nestedSortable.js"></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <h1>.......</h1>
                    <ol class="sortable">
                        <li><a>Some content</a></li>
                        <li>
                            <a>Some content</a>
                            <ol>
                                <li><a>Some sub-item content</a></li>
                                <li><a>Some sub-item content</a></li>
                            </ol>
                        </li>
                        <li><a>Some content</a></li>
                    </ol>
                    
                    <br />
                    <button type="button" class="sort">Sort</button>
                </div>
            </div>
        </div>

        <script>
            (function ($) {
                $('.sortable').nestedSortable({
                    handle: 'a',
                    items: 'li',
                    toleranceElement: '> a'
                });
                $('.sort').click(function(){
                    var hiered = $('.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
                    console.log(hiered);
                });
            })(jQuery);
        </script>
    </body>
</html>
