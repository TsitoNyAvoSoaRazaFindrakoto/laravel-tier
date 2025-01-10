let loginApp = angular.module("loginApp",["ngRoute"]);

dashboardApp.controller('loginController', function($scope, $http) {
    const date=new Date();
    $scope.utilisateur={};
    $scope.submitForm=function(){
        $http.post("dashboard/vitesse",$scope.utilisateur).then(function(response){
            $scope.data=response.data;
        });
    }
});
