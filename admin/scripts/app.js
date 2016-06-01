/**
 * Created by pakabah on 25/05/2016.
 */
var app = angular.module('app',['ngNewRouter','ngFileUpload']);

app.controller('RouteController', ['$router',function($router){
    $router.config([
        {path:'/',redirectTo: '/upload'},
        {path:'/upload', component: 'upload'}
    ]);
}
]);

app.factory('Login', function($http){
    return{
        login: function(username,password)
        {
            return  $http.post('../process/process_login.php',{login: 'ASEW45FUVNTE6UE', username:username,password:password});
        },
        isloggedIn: function()
        {
            return  $http.post('../process/process_login.php',{isloggedIn: 'ASEW45FUVNTE6UE'});
        },
        logout: function()
        {
            return  $http.post('../process/process_login.php',{logout: 'ASEW45FUVNTE6UE'});
        },
        getName: function()
        {
            return  $http.post('../process/process_login.php',{getUsername: 'ASEW45FUVNTE6UE'});
        }

    }
});

app.factory("Listing", function($http){
    return{
        getRecentListing: function()
        {
            return  $http.post('../process/process_listings.php',{getRecentListing: 'ASEW45FUVNTE6UE'});
        },
        getAllListing: function()
        {
            return  $http.post('../process/process_listings.php',{getAllListing: 'ASEW45FUVNTE6UE'});
        },
        getSearchListing: function(search)
        {
            return  $http.post('../process/process_listings.php',{getSearchListing: 'ASEW45FUVNTE6UE',search:search});
        },
        uploadListing: function(hostelname,region,campus,area,location,phone,email,rooms)
        {
            return  $http.post('../process/process_listings.php',{uploadListing: 'ASEW45FUVNTE6UE',hostelname:hostelname,region:region,campus:campus,area:area,location:location,phone:phone,email:email,rooms:rooms});
        },
        getMyListing: function()
        {
            return $http.post('../process/process_listings.php',{getMyListing: 'ASEW45FUVNTE6UE'});
        }
    }
});

app.controller("MenuController", function($scope,Login){
    Login.getName().success(function(data){
       $scope.name = data;
    });

    $scope.logout = function()
    {
        Login.logout().success(function(){

            window.open("/","_self");
        });
    }
});

app.controller("MainController", function($scope){

});

app.controller("UploadController", function($scope,Listing,Upload,$timeout){
    $scope.cCreated = true;

    $scope.saveListing = function(hostelname,region,campus,area,location,phone,email,rooms,description,lon,lat)
    {
        //Listing.uploadListing(hostelname,region,campus,area,location,phone,email,rooms).success(function(data){
        //    $scope.cCreated = false;
        //    console.log(data);
        //})
        $scope.upload($scope.files,hostelname,region,campus,area,location,phone,email,rooms,description,lon,lat);
    };

    Listing.getMyListing().success(function(data){
        $scope.iMyListing = data;
        console.log(data);
    });

    $scope.$watch('files', function () {
        //$scope.upload($scope.files,hostelname,region,campus,area,location,phone,email,rooms,description,lon,lat);
    });
    $scope.$watch('file', function () {
        if ($scope.file != null) {
            $scope.files = [$scope.file];
        }
    });
    $scope.log = '';

    $scope.upload = function (files,hostelname,region,campus,area,location,phone,email,rooms,description,lon,lat) {
        if (files && files.length) {
            var hsId = null;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (!file.$error) {
                    Upload.upload({
                        url: '../process/process_file.php',
                        data: {
                            file: file,
                            hostelname: hostelname,
                            region: region,
                            campus: campus,
                            area:area,
                            description: description,
                            location:location,
                            phone:phone,
                            email:email,
                            rooms:rooms,
                            lon:lon,
                            lat:lat,
                            count: i,
                            hsid:hsId
                        }
                    }).then(function (resp) {
                       hsId = resp;
                        //$timeout(function () {
                        //    $scope.log = 'file: ' +
                        //        resp.config.data.file.name +
                        //        ', Response: ' + JSON.stringify(resp.data) +
                        //        '\n' + $scope.log;
                        //});
                    }, null, function (evt) {
                        var progressPercentage = parseInt(100.0 *
                            evt.loaded / evt.total);
                        $scope.log = 'progress: ' + progressPercentage +
                            '% ' + evt.config.data.file.name + '\n' +
                            $scope.log;
                    });
                }
            }
        }
    }

});
