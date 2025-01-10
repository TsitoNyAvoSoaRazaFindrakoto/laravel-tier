let loginApp = angular.module("loginApp",["ngRoute"]);

loginApp.controller('loginController', function($scope, $http) {
    const date=new Date();
    $scope.utilisateur={};
    $scope.submitForm=function(){
        console.log(JSON.stringify($scope.utilisateur));
        $http.post("dashboard/vitesse",$scope.utilisateur).then(function(response){
            $scope.data=response.data;
        });
    }
});
