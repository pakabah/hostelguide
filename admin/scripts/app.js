/**
 * Created by pakabah on 25/05/2016.
 */
var app = angular.module('app',['ngNewRouter']);

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

app.controller("UploadController", function($scope,Listing){
    $scope.cCreated = true;

    $scope.saveListing = function(hostelname,region,campus,area,location,phone,email,rooms)
    {
        console.log(hostelname+region+campus+area+location+phone+email+rooms);
        Listing.uploadListing(hostelname,region,campus,area,location,phone,email,rooms).success(function(data){
            $scope.cCreated = false;
            console.log(data);
        })
    };

    Listing.getMyListing().success(function(data){
        $scope.iMyListing = data;
        console.log(data);
    });

});
