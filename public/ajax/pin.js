let pinApp = angular.module("pinApp",["ngRoute"]);

pinApp.controller('pinController', function($scope, $http,$location) {
    $scope.utilisateur={};
    $scope.submitForm=function(token){
        $scope.utilisateur.tokenUtilisateur=token;
        $http.post("http://localhost:8082/utilisateur/utilisateur/login/pin",$scope.utilisateur,{
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            $scope.data=response.data;
            window.location.href = `http://127.0.0.1:8000/session?idUtilisateur=${$scope.data.data.idUtilisateur}`;
        });
    }
});
