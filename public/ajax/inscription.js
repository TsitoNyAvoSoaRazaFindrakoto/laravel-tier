let inscriptionApp = angular.module("inscriptionApp",["ngRoute"]);

inscriptionApp.controller('inscriptionController', function($scope, $http) {
    $scope.utilisateur={};
    console.log("COUCOU")
    $scope.submitForm=function(){
        console.log(JSON.stringify($scope.utilisateur));
        $http.post("http://localhost:8082/utilisateur/utilisateur/inscription",$scope.utilisateur,{
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            $scope.data=response.data;
            console.log($scope.data);
            if($scope.data.status==200){
                window.location.href = `http://127.0.0.1:8000/pin?token=${$scope.data.data}`;
            }
            else{
                console.log($scope.data.message);
            }
        });
    }
});
