let pinApp = angular.module("pinApp",["ngRoute"]);

pinApp.controller('pinController', function($scope, $http) {
    $scope.utilisateur={};
    $scope.urlGiven=urlGiven;
    const buttonHtml="\n" +
        "            <span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n" +
        "            <span class=\"visually-hidden\">Loading...</span>";
    const buttonLogin=document.getElementById("buttonLogin");
    const message=document.getElementById("message");
    $scope.submitForm=function(token){
        if($scope.utilisateur.tokenUtilisateur==null){
            $scope.utilisateur.tokenUtilisateur=token;
        }
        buttonLogin.innerHTML=buttonHtml;
        buttonLogin.disabled=true;
        console.log($scope.utilisateur);
        $http.post("http://localhost:8082/utilisateur/utilisateur/login/pin",$scope.utilisateur,{
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            buttonLogin.innerHTML="Login";
            buttonLogin.disabled=false;
            $scope.data=response.data;
            console.log($scope.data);
            if($scope.data.status==200){
                window.location.href = `http://127.0.0.1:8000/session?idUtilisateur=${$scope.data.data.idUtilisateur}&pseudo=${$scope.data.data.pseudo}&role=${$scope.data.data.role.roleName}&token=${token}`;
            }
            else{
                message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">\n" +
                    $scope.data.message+"    </div>";
                if($scope.data.data!=null){
                    $scope.utilisateur.tokenUtilisateur=$scope.data.data;
                }
            }
        });
    }
});
