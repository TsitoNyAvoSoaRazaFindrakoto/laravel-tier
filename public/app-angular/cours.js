let coursApp = angular.module("coursApp",["ngRoute"]).config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

coursApp.controller('coursController', function($scope, $http) {
    $scope.cours=cours;
    function thread(){
        setTimeout(() => {
            getCours();
        }, 10000);
    }

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

    function getCours(){
        $http.get(`http://127.0.0.1:8000/api/cours/crypto`)
            .then(function(response) {
                for(i=0;i<$scope.cours.length;i++){
                    $scope.cours[i].variation=(response.data[i].prixUnitaire-$scope.cours[i].prixUnitaire).toPrecision(4);
                    if($scope.cours[i].variation>0){
                        $scope.cours[i].styleClass="text-success";
                        $scope.cours[i].icon="mdi mdi-arrow-top-right";
                    }
                    else{
                        $scope.cours[i].styleClass="text-danger";
                        $scope.cours[i].icon="mdi mdi-arrow-bottom-right";
                    }
                    $scope.cours[i].prixUnitaire=response.data[i].prixUnitaire;
                }
                console.log("Vita");
            })
            .catch(function(error) {
                console.error('Erreur lors de la requête :', error);
            });
        thread();
    }

    $scope.buy = function (idCrypto){
        $scope.transaction={};
        $scope.transaction.idCrypto=idCrypto;
        $scope.transaction.quantite=getQuantityCoursById(idCrypto);
        window.location.href = `http://127.0.0.1:8000/achat/insertion_achat?idCrypto=${idCrypto}&quantite=${$scope.transaction.quantite}`;
    }

    $scope.sell = function (idCrypto){
        $scope.transaction={};
        $scope.transaction.idCrypto=idCrypto;
        $scope.transaction.quantite=getQuantityCoursById(idCrypto);
        $http.post(`/vente/insertion_vente`,$scope.transaction,{
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response){
            console.log(response.data);
            if(response.data.status==200){
                addToFirestore("fondUtilisateur",response.data.data.fondUtilisateur);
                addToFirestore("transCrypto",response.data.data.transaction);
            }
            else{
                console.log(response.data.message);
            }
        });
    }

    function getQuantityCoursById(idCrypto){
        console.log($scope.cours);
        for (i=0;i<$scope.cours.length;i++) {
            console.log($scope.cours[i]);
            if($scope.cours[i].idCrypto==idCrypto){
                return $scope.cours[i].quantite;
            }
        }
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

    thread();
});
