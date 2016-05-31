/**
 * Created by pakabah on 19/05/2016.
 */
var app = angular.module('app',[]);

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

app.factory('SignUp', function($http){
    return{
        signup: function(name,email,password,username,profile,phone)
        {
            return  $http.post('../process/process_login.php',{signup: 'ASEW45FUVNTE6UE',name:name,email:email,profile:profile,username:username,password:password,phone:phone});
        }
    }
});

app.factory("Agent", function($http){
    return{

    }
});

app.factory("Index", function($http){
    return{

    }
});

app.factory("Contact", function($http){
    return{

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
        uploadListing: function(hostelname,region,campus,area,location,phone,email,rooms,lat,long)
        {
            return  $http.post('../process/process_listings.php',{uploadListing: 'ASEW45FUVNTE6UE',hostelname:hostelname,region:region,campus:campus,area:area,location:location,phone:phone,email:email,rooms:rooms,lat:lat,long:long});
        },
        getAllAgentListing: function()
        {
            return  $http.post('../process/process_listings.php',{getAllAgentListing: 'ASEW45FUVNTE6UE'});
        },
        getDetails: function(id)
        {
            return  $http.post('../process/process_listings.php',{getDetailListing: 'ASEW45FUVNTE6UE', id:id});
        }
    }
});

app.factory("Search", function($http){
   return{
       searchHostel: function(search,region,campus,area)
       {
           return  $http.post('../process/process_search.php',{search: 'ASEW45FUVNTE6UE', searchTerm:search,region:region,campus:campus,area:area});
       }
   }
});

app.controller('MenuController', function($scope){

});


app.controller('ListingController', function($scope,Login,Listing,Search){
    $scope.log= false;
    $scope.loggedIn = true;

    Login.isloggedIn().success(function(data){
        if(data == "1")
        {
            Login.getName().success(function(data){
                $scope.username = data;
            });
            $scope.loggedIn = false;
            $scope.log = true;
        }
        else
        {
            $scope.loggedIn = true;
            $scope.log = false;
        }
    });

    $scope.logout = function()
    {
        Login.logout().success(function(data){
            $scope.loggedIn = true;
            $scope.log = false;
        })
    };

    Listing.getAllListing().success(function(data){
      $scope.mListing= data;
    });

    $scope.searchHide = true;

    $scope.searching = function(mHostel,mRegion,mCampus,mArea)
    {
        Search.searchHostel(mHostel,mRegion,mCampus,mArea).success(function(data){
            $scope.searchHide = false;

            $scope.mSearch = data;
        });
    }

});

app.controller("IndexController", function($scope,Login,Listing,Search){

    $scope.log= false;
    $scope.loggedIn = false;

    Login.isloggedIn().success(function(data){
       if(data == "1")
       {
           Login.getName().success(function(data){
              $scope.username = data;
           });
           $scope.loggedIn = false;
           $scope.log = true;
       }
        else
       {
           $scope.loggedIn = true;
           $scope.log = false;
       }
    });

    $scope.logout = function()
    {
        Login.logout().success(function(data){
            $scope.loggedIn = true;
            $scope.log = false;
        })
    };

    Listing.getRecentListing().success(function(data){

        $scope.mRecent = data;
    });

    Listing.getAllAgentListing().success(function(data){
       $scope.mAgent = data;
    });

    $scope.searchHide = true;

    $scope.searching = function(mHostel,mRegion,mCampus,mArea)
    {
        Search.searchHostel(mHostel,mRegion,mCampus,mArea).success(function(data){
            $scope.searchHide = false;

            $scope.mSearch = data;
        });
    }


});

app.controller("LoginController", function($scope,Login){

    $scope.hideNot = true;

    $scope.Login = function(username,password)
    {
        Login.login(username,password).success(function(data){
            if(data != '0')
            {
                if(data == "manager")
                {
                    window.open("admin/","_self");

                }
                else
                {
                    window.open("/","_self");
                }
            }
            else
            {
                $scope.hideNot = false
            }
        });
    };
});

app.controller("SignupController", function($scope,SignUp){

    $scope.SignUp  = function(name,email,password,username,profile,phone)
    {
        SignUp.signup(name,email,password,username,profile,phone).success(function(data){
            console.log(data);
            if(data == 0)
            {
                var msg = "Username already taken";
                var title = "Signup Error";
                var showDuration = 300;
                var hideDuration = 1000;
                var timeOut = 5000;
                var $extendedTimeOut = 1000;
                var $showEasing = "swing";
                var $hideEasing = "swing";
                var $showMethod = "fadeIn";
                var $hideMethod = "fadeOut";

                toastr.options = {
                    closeButton: true,
                    debug: false,
                    progressBar: false,
                    positionClass: "toast-top-center",
                    onclick: null
                };

                toastr.error(msg,title);
                toastr.options.showDuration = showDuration;

                toastr.options.hideDuration = hideDuration;

                toastr.options.timeOut = timeOut;

                toastr.options.extendedTimeOut = $extendedTimeOut;

                toastr.options.showEasing = $showEasing;

                toastr.options.hideEasing = $hideEasing;

                toastr.options.showMethod = $showMethod;

                toastr.options.hideMethod = $hideMethod;
            }else
            {

            }
        });
    }
});

app.controller("ContactController", function($scope,Login){
    $scope.log= false;
    $scope.loggedIn = false;

    Login.isloggedIn().success(function(data){
        if(data == "1")
        {
            Login.getName().success(function(data){
                $scope.username = data;
            });
            $scope.loggedIn = false;
            $scope.log = true;
        }
        else
        {
            $scope.loggedIn = true;
            $scope.log = false;
        }
    });

    $scope.logout = function()
    {
        Login.logout().success(function(data){
            $scope.loggedIn = true;
            $scope.log = false;
        })
    }

});

app.controller("AgentsController", function($scope,Login,Listing,Search){
    $scope.log= false;
    $scope.loggedIn = false;

    Login.isloggedIn().success(function(data){
        if(data == "1")
        {
            Login.getName().success(function(data){
                $scope.username = data;
            });
            $scope.loggedIn = false;
            $scope.log = true;
        }
        else
        {
            $scope.loggedIn = true;
            $scope.log = false;
        }
    });

    $scope.logout = function()
    {
        Login.logout().success(function(data){
            $scope.loggedIn = true;
            $scope.log = false;
        })
    };

    Listing.getAllAgentListing().success(function(data){
       $scope.mAgent = data;
    });

    $scope.searchHide = true;

    $scope.searching = function(mHostel,mRegion,mCampus,mArea)
    {
        Search.searchHostel(mHostel,mRegion,mCampus,mArea).success(function(data){
            $scope.searchHide = false;

            $scope.mSearch = data;
        });
    }

});

app.controller("UploadController", function($scope,Listing,Login){
    $scope.log= false;
    $scope.loggedIn = false;

    Login.isloggedIn().success(function(data){
        if(data == "1")
        {
            Login.getName().success(function(data){
                $scope.username = data;
            });
            $scope.loggedIn = false;
            $scope.log = true;
        }
        else
        {
            $scope.loggedIn = true;
            $scope.log = false;
        }
    });

    $scope.logout = function()
    {
        Login.logout().success(function(data){
            $scope.loggedIn = true;
            $scope.log = false;
        })
    };

    $scope.saveListing = function(hostelname,region,campus,area,location,phone,email,rooms,lat,long)
    {
        Listing.uploadListing(hostelname,region,campus,area,location,phone,email,rooms,lat,long).success(function(data){
            console.log(data);
        })
    }
});

app.controller("DetailsController", function($scope,Login,Listing,$window,Search){
    $scope.log= false;
    $scope.loggedIn = false;

    Login.isloggedIn().success(function(data){
        if(data == "1")
        {
            Login.getName().success(function(data){
                $scope.username = data;
            });
            $scope.loggedIn = false;
            $scope.log = true;
        }
        else
        {
            $scope.loggedIn = true;
            $scope.log = false;
        }
    });

    $scope.logout = function()
    {
        Login.logout().success(function(data){
            $scope.loggedIn = true;
            $scope.log = false;
        })
    };

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec($window.location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    var target = getParameterByName("id");

    Listing.getDetails(target).success(function(data){
       $scope.details = data;

        $scope.hostelName = $scope.details[0].hostel_name;
        $scope.manager = $scope.details[0].name;
        $scope.managerPhone = $scope.details[0].phone;
        $scope.managerEmail = $scope.details[0].email;
        $scope.campus = $scope.details[0].campus;
        $scope.rooms = $scope.details[0].rooms;
        console.log(data);
    });

    $scope.searchHide = true;

    $scope.searching = function(mHostel,mRegion,mCampus,mArea)
    {
        Search.searchHostel(mHostel,mRegion,mCampus,mArea).success(function(data){
            $scope.searchHide = false;

            $scope.mSearch = data;
        });
    }

});