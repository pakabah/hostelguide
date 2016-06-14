/**
 * Created by pakabah on 25/05/2016.
 */
var app = angular.module('app',['ngNewRouter','ngFileUpload']);

app.controller('RouteController', ['$router',function($router){
    $router.config([
        {path:'/',redirectTo: '/upload'},
        {path:'/upload', component: 'upload'},
        {path:'/settings', component: 'settings'}
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
        },
        getPic: function()
        {
            return  $http.post('../process/process_login.php',{getUserPic: 'ASEW45FUVNTE6UE'});
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
        },
        getListingEdit: function(listingId)
        {
            return $http.post('../process/process_listings.php',{getListingEdit: listingId});
        },
        deleteListing: function(listingId)
        {
            return $http.post('../process/process_listings.php',{deleteListing: listingId});
        },
        getMyReservations: function()
        {
            return $http.post('../process/process_listings.php',{getMyReservations: 'ASEW45FUVNTE6UE'});
        },
        deleteUser: function(username,hostel_id)
        {
            return $http.post('../process/process_listings.php',{deleteReservation: username,hostel_id:hostel_id});

        }
    }
});

app.factory("Settings", function($http){
   return{
       getMyDetails: function()
       {
           return  $http.post('../process/process_user.php',{getMyInfo: 'ASEW45FUVNTE6UE'});
       },
       updatePassword: function(oldPassword,newPassword)
       {
           return  $http.post('../process/process_user.php',{updatePassword: 'ASEW45FUVNTE6UE',oldPassword:oldPassword,newPassword:newPassword});
       },
       updateDetails: function(name,email,phone)
       {
           return  $http.post('../process/process_user.php',{updateDetails: 'ASEW45FUVNTE6UE',name:name,email:email,phone:phone});
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
    };

    Login.getPic().success(function(data){
        $scope.profile = data;
    })
});

app.controller("MainController", function($scope){

});

app.controller("UploadController", function($scope,Listing,Upload,$timeout){
    $scope.cCreated = true;

    $scope.saveListing = function(hostelname,region,campus,area,location,phone,email,oneRoom,twoRoom,threeRoom,fourRoom,fiveRoom,service,facilities,description,lon,lat)
    {
        $scope.cCreated = true;
        $scope.upload($scope.files,hostelname,region,campus,area,location,phone,email,oneRoom,twoRoom,threeRoom,fourRoom,fiveRoom,service,facilities,description,lon,lat);
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

    $scope.upload = function (files,hostelname,region,campus,area,location,phone,email,oneRoom,twoRoom,threeRoom,fourRoom,fiveRoom,service,facilities,description,lon,lat) {
        console.log(hostelname+" "+region+" "+campus+" "+area+" "+location+" "+phone+" "+email+" "+oneRoom+" "+twoRoom+" "+threeRoom+" "+fourRoom+" "+fiveRoom+" "+service+" "+facilities+" "+description+" "+lon+" "+lat);
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
                            oneRoom:oneRoom,
                            twoRoom:twoRoom,
                            threeRoom:threeRoom,
                            fourRoom:fourRoom,
                            fiveRoom:fiveRoom,
                            lon:lon,
                            lat:lat,
                            count: i,
                            facilities:facilities,
                            services:service,
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
                    });
                }
            }
            $scope.hostelName = "";
            $scope.region = "";
            $scope.campus="";
            $scope.area = "";
            $scope.location= "";
            $scope.phone ="";
            $scope.email= "";
            $scope.oneRoom = "";
            $scope.twoRoom = "";
            $scope.threeRoom ="";
            $scope.fourRoom ="";
            $scope.fiveRoom="";
            $scope.description = "";
            $scope.lon="";
            $scope.lat="";
            $scope.cCreated = false;
        }
    };

    $scope.editDetails = function(listingId)
    {
        Listing.getListingEdit(listingId).success(function(data){
            console.log(data);
            $scope.Arooms = angular.fromJson(data[0].rooms);
            $scope.edithostelname = data[0].hostel_name;
            $scope.editregion = data[0].region;
            $scope.editcampus = data[0].campus;
            $scope.editarea = data[0].area;
            $scope.editlocation = data[0].location;
            $scope.editphone = data[0].phone;
            $scope.editemail = data[0].email;

            angular.forEach($scope.Arooms, function(value,key){
                console.log(value);
                if(value.room == 1)
                {
                    $scope.editoneRoom = value.price;
                }
                 if(value.room == 2)
                {
                    $scope.edittwoRoom = value.price;
                }
                 if(value.room == 3)
                {
                    $scope.editthreeRoom = value.price;
                }
                 if(value.room == 4)
                {
                    $scope.editfourRoom = value.price;
                }
                 if(value.room == 5)
                {
                    $scope.editfiveRoom = value.price;
                }
            });

            $scope.editdescription = data[0].details;
            $scope.editlon = data[0].long;
            $scope.editlat = data[0].lat;
        });
    };

    $scope.deleteListing = function(listingId)
    {
      Listing.deleteListing(listingId).success(function(data){
         Listing.getMyListing().success(function(data){
             $scope.iMyListing = data;
             console.log(data);
         })
      });
    };

    Listing.getMyReservations().success(function(data){
       console.log(data);
        $scope.mReservations = data;
    });

    $scope.deleteUser = function(username,hostel_id)
    {
        Listing.deleteUser(username,hostel_id).success(function(data){
            Listing.getMyReservations().success(function(data){
                console.log(data);
                $scope.mReservations = data;
            });
        });
    }

});

app.controller("SettingsController", function($scope,Settings,Login,Upload){
    $scope.npass = true;

    Settings.getMyDetails().success(function(data){
        $scope.names = data.name;
        $scope.email = data.email;
        $scope.phone = data.phone;
        $scope.profile = data.pic;
    });

    Login.getName().success(function(data){
        $scope.num = data;
    });

    $scope.updateProfile = function(names,phone,email)
    {
        $scope.upload($scope.profile,names,phone,email);
    };

    $scope.upload = function (files,names,phone,email) {
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (!file.$error) {
                    Upload.upload({
                        url: '../process/process_profile.php',
                        data: {
                            file: file,
                            name: names,
                            phone: phone,
                            email: email
                        }
                    }).then(function (resp) {
                        //$timeout(function () {
                        //    $scope.log = 'file: ' +
                        //        resp.config.data.file.name +
                        //        ', Response: ' + JSON.stringify(resp.data) +
                        //        '\n' + $scope.log;
                        //});
                    }, null, function (evt) {
                        var progressPercentage = parseInt(100.0 *
                            evt.loaded / evt.total);
                    });
                }
            }
            $scope.names = "";
            $scope.email = "";
            $scope.phone="";
            $scope.cCreated = false;
        }
    };

    $scope.updatePass = function(oldpassword,newpassword)
    {
        Settings.updatePassword(oldpassword,newpassword).success(function(data){
            $scope.npass = false;
        });
    }
});
