app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};
    $scope.doLogin = function (customer) {
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
 
//Show the details in logged in user
    $scope.get_product = function() {
        Data.get('getrecords').then(function (data) {
            $scope.pagedItems = data; 
        });
        
    };
//Edit the Record    
     $scope.record_edit = function(index) {  
       alert('Edit ID: '+index)  ;
     };

//Record Delete
    $scope.record_delete = function(index) {
      alert('Delete ID: '+index);  
    };

    $scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    $scope.signUp = function (customer) {
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    };
});