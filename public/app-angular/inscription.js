let inscriptionApp = angular.module("inscriptionApp",["ngRoute"]);

inscriptionApp.controller('inscriptionController', function($scope, $http) {
    $scope.utilisateur={};
    console.log("Hello");
    const buttonHtml="\n" +
        "            <span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n" +
        "            <span class=\"visually-hidden\">Loading...</span>";
    const message=document.getElementById("message");
    const buttonLogin=document.getElementById("buttonLogin");
    $scope.submitForm=function(){
        console.log("Submit");
        if($scope.utilisateur.password!=$scope.passwordTest){
            message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">\n" +
                "Veillez retaper les mots de passe SVP</div>";
            return;
        }
        buttonLogin.innerHTML=buttonHtml;
        buttonLogin.disabled=true;
        console.log(JSON.stringify($scope.utilisateur));
        $http.post("http://localhost:8082/utilisateur/utilisateur/inscription",$scope.utilisateur,{
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            $scope.data=response.data;
            console.log($scope.data);
            buttonLogin.innerHTML="S'inscrire";
            buttonLogin.disabled=false;
            if($scope.data.status==200){
                window.location.href = `http://127.0.0.1:8000/pin?token=${$scope.data.data}`;
            }
            else{
                console.log($scope.data.message);
            }
        });
    }
});
