<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="/public/css/bootstrap.min.css">
        <script src="/public/js/jquery.min.js"></script>
        <script src="/public/js/bootstrap.min.js"></script>

        <script src="https://js.pusher.com/3.2/pusher.min.js"></script>
        
    </head>
    <body>
        <div class="container">
            <div class="col-sm-4">
                <br />
                <br />
                <br />
                <div class="panel panel-default">
                    <ul class="panel-body" id="mess-box">
                        
                    </ul>
                </div>
                <form id="mess-form">
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control mess-txt" name="message" autocomplete="off">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default mess-btn">OK</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <script>

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('71dda9d5a69c8d0f839c', {
                cluster: 'eu',
                encrypted: true
            });

            var channel = pusher.subscribe('message-channel');
            channel.bind('App\\Events\\MessageCreated', function (data) {
                console.log(data);
                $('.mess-txt').val('');
                $('#mess-box').append('<li>'+data.name+'</li>');
            });
            
            (function($){
                $('#mess-form').submit(function(e){
                    e.preventDefault();
                    
                    console.log('waiting...');
                    $.ajax({
                       type: 'GET',
                       url: 'http://omn_slus.com/test/messages/event',
                       data: {mess: $('.mess-txt').val()},
                       success: function(data){
                           console.log(data);
                       }
                    });
                });
            })(jQuery);
            
        </script>
        
    </body>
</html>
