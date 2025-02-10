let pinApp = angular.module("pinApp",["ngRoute"]);

pinApp.controller('pinController', function($scope, $http) {
    $scope.utilisateur={};
    $scope.transaction={};
    $scope.transaction.idCrypto=idCrypto;
    $scope.transaction.quantite=quantite;
    const buttonHtml="\n" +
        "            <span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n" +
        "            <span class=\"visually-hidden\">Loading...</span>";
    const buttonLogin=document.getElementById("buttonLogin");
    const message=document.getElementById("message");

    const firebaseConfig = {
        apiKey: "AIzaSyD_dhXrU5-3m_QsUAka7FVavlGTgNTlppI",
        authDomain: "crypta-d5e13.firebaseapp.com",
        projectId: "crypta-d5e13",
        storageBucket: "crypta-d5e13.firebasestorage.app",
        messagingSenderId: "539604836728",
        appId: "1:539604836728:web:5876a760ea6bf2189ee88d",
        measurementId: "G-X7J7VJSX4N"
    };
    firebase.initializeApp(firebaseConfig);
    const db = firebase.firestore();

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
            buttonLogin.innerHTML="Valider";
            buttonLogin.disabled=false;
            $scope.data=response.data;
            if($scope.data.status==200){
                $scope.transaction.token=$scope.data.data.token;
                $http.post(`/achat/validated`,$scope.transaction,{
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(function(response){
                    if(response.data.status==200){
                        addToFirestore("fondUtilisateur",response.data.data.fondUtilisateur);
                        addToFirestore("transCrypto",response.data.data.transaction);
                        window.location.href="/dashboard/cours-crypto";
                    }
                    else{
                        console.log(response.data.message);
                    }
                }).catch(function(error){
                    console.log(error);
                    message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">\n" +
                        error.data.message+"    </div>";
                });
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

    function addToFirestore(collection,data){
        db.collection(collection) // Nom de la collection
            .add(data) // Les données à insérer
            .then((docRef) => {
                console.log("Document ajouté avec ID: ", docRef.id);
            })
            .catch((error) => {
                console.error("Erreur lors de l'ajout du document: ", error);
            });
    }
});
