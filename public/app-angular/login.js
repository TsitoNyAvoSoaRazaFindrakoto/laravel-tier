let loginApp = angular.module("loginApp",["ngRoute"]);

loginApp.controller('loginController', function($scope, $http) {
    $scope.utilisateur={};
    $scope.utilisateur.email="LizkaRyan626@gmail.com";
    $scope.utilisateur.password="itu16";

    const buttonHtml="\n" +
        "            <span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n" +
        "            <span class=\"visually-hidden\">Loading...</span>";
    const buttonLogin=document.getElementById("buttonLogin");
    const message=document.getElementById("message");

    if(error!=""){
        message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">\n" +
            error+"    </div>";
    }

    $scope.submitForm=function(){
        console.log(JSON.stringify($scope.utilisateur));
        buttonLogin.innerHTML=buttonHtml;
        buttonLogin.disabled=true;
        $http.post("http://localhost:8082/utilisateur/utilisateur/login",$scope.utilisateur,{
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            $scope.data=response.data;
            console.log($scope.data);
            buttonLogin.innerHTML="Login";
            buttonLogin.disabled=false;
            console.log($scope.data);
            if($scope.data.status==200){
                url=`http://127.0.0.1:8000/pin?token=${$scope.data.data.token}`;
                if($scope.data.data.isAdmin){
                    url = `http://127.0.0.1:8000/session?idUtilisateur=${$scope.data.data.utilisateur.idUtilisateur}&pseudo=${$scope.data.data.utilisateur.utilisateur}&role=${$scope.data.data.utilisateur.role.roleName}&token=${$scope.data.data.token}`;
                }
                window.location.href=url;
            }
            else{
                message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">\n" +
                    $scope.data.message+"    </div>";
            }
        });
    }
});
