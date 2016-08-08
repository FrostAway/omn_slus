<!DOCTYPE html>

<html>
    <head>
        <title>Files</title>

        <script src="/js/jquery.min.js"></script>
        <script src="/js/angular.min.js"></script>
    </head>
    <body ng-app="ngApp" ng-controller="FileCtrl">
        <h3>Files</h3>

        <ul id="files">
            <li ng-repeat="file in files"><a ng-click="checkFile(file, true)" href="javascript:void(0)" data-url="{% file.url %}">{% file.title %}</a></li>
        </ul>

        <div id="upload_box">
            <form enctype="multipart/form-data">
                <input type="file" name="files[]" multiple ng-model="files" file-upload>
            </form>
        </div>

        <div id="lists">
            <a ng-repeat="item in checked_files" href="{% item.url %}">{% item.title %}</a>
        </div>

        <script>
                    (function ($) {
                        var args = top.tinymce.activeEditor.windowManager.getParams();
                        var editor = args.editor;

//                $('body').on('click', '#files b', function(e){
//                   e.preventDefault();
//                   editor.insertContent($(this).attr('href'));
//                   editor.windowManager.close();
//                });
                    })(jQuery);

                    angular.module('ngApp', [])
                            .config(function ($interpolateProvider) {
                                $interpolateProvider.startSymbol('{%');
                                $interpolateProvider.endSymbol('%}');
                            })
                            .controller('FileCtrl', function ($scope) {
                                $scope.files = [
                                    {title: 'File 1', url: 'url1'},
                                    {title: 'File 2', url: 'url2'},
                                    {title: 'File 3', url: 'url3'},
                                    {title: 'File 4', url: 'url4'}
                                ];

                                $scope.checked_files = [];
                                $scope.checkFile = function (file, multi) {
                                    $scope.proccessing = false;
                                    if (typeof multi == "undefined") {
                                        multi = false;
                                    }
                                    if (!multi) {
                                        $scope.checked_files[0] = file;
                                    } else {
                                        var index = $scope.checked_files.indexOf(file);
                                        if (index > -1) {
                                            $scope.checked_files.splice(index, 1);
                                        } else {
                                            $scope.checked_files.push(file);
                                        }
                                    }
                                    console.log($scope.checked_files);
                                };

                                $scope.files = [];
                            })
                            .directive('fileUpload', function ($http) {
                                return {
                                    restrict: 'A',
                                    link: function (scope, element, attrs) {
                                        element.bind('change', function (event) {
                                            scope.$apply(function () {
                                                var files = event.target.files || event.dataTransfer.files;
                                                var form = $(element).parent()[0];
                                                var formData = new FormData();
                                                for (var i = 0; i < files.length; i++) {
                                                    formData.append('files[]', files[i]);
                                                }
                                                $http({
                                                    method: 'POST',
                                                    url: '/test/upload',
                                                    data: formData,
                                                    headers: {'Content-type': undefined}
                                                }).success(function (data) {
                                                    console.log(data);
                                                }).error(function (error) {
                                                    console.log(error);
                                                });
                                            });
                                        });
                                    }
                                };
                            });
        </script>
    </body>
</html>
