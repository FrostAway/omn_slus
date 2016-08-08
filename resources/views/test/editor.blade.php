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
        <script src="/plugins/tinymce/tinymce.min.js"></script>
        
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <h1>/</h1>
                    <div class="form-group">
                        <textarea class="form-control txt_editor" id="txt_editor"></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            (function($){
                tinymce.init({
                    selector: '#txt_editor',
                    plugins: 'code ex_loadfile',
                    toolbar: 'ex_loadfile image link code'
                });
            })(jQuery);
        </script>
    </body>
</html>
