let transactionApp = angular.module("transactionApp", ["ngRoute"]).config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

transactionApp.controller('transactionController', function ($scope, $http) {
    $scope.transactionsCrypto = dataCrypto;
    $scope.transactionsFond = [];

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

    for (i=0;i<dataFonds.length;i++) {
        dataFonds[i].mobile=false;
        $scope.transactionsFond.push(dataFonds[i]);
        console.log($scope.transactionsFond);
    }

    if ($scope.transactionsFond !== {}) {

        db.collection("fondUtilisateurRequest")
            .where("mobile", "==", true) // Condition : âge supérieur à 18
            .get()
            .then((querySnapshot) => {
                querySnapshot.forEach((doc) => {
                    data=doc.data();
                    // Ajouter à transactionsFond
                    $scope.$apply(function() {
                        $scope.transactionsFond.push($scope.setValueData(data,doc.id));
                    });
                });
            })
            .catch((error) => {
                console.error("Erreur lors de la récupération des documents :", error);
            });
    }

    $scope.setValueData=function(dataFirestore,id){
        const timestamps = {
            seconds: dataFirestore.dateTransaction.seconds,
            nanoseconds: data.dateTransaction.nanoseconds
        };
        dataFirestore.date=dataFirestore.dateTransaction;
        // Convertir les secondes en millisecondes
        dataFirestore.dateTransaction = new Date(timestamps.seconds * 1000);
        dataFirestore.dateTransaction = new Date(dataFirestore.dateTransaction.getTime() + (timestamps.nanoseconds / 1000000));
        dataFirestore.dateTransaction = formatDateTime(dataFirestore.dateTransaction);

        dataFirestore.idFirestore = id;

        if(dataFirestore.entree==0){
            dataFirestore.montant=dataFirestore.sortie;
            dataFirestore.styleClass="text-danger";
            dataFirestore.operation="Retrait";
            dataFirestore.icon="mdi mdi-arrow-bottom-right";
        }
        else{
            dataFirestore.montant=dataFirestore.entree;
            dataFirestore.styleClass="text-success";
            dataFirestore.operation="Depot";
            dataFirestore.icon="mdi mdi-arrow-top-right";
        }
        return dataFirestore;
    }

    function setDataFirestore(transaction){
        console.log(transaction);
        data={};
        data.entree=transaction.entree;
        data.sortie=transaction.sortie;
        if(transaction.date===undefined){
            data.dateTransaction=convertDateTime(transaction.dateTransaction);
        }
        else{
            data.dateTransaction=transaction.date;
        }
        data.mobile=false;
        data.dateValidation=new Date();
        data.utilisateur=transaction.utilisateur;
        return data;
    }

    function convertDateTime(dateString) {
        let dateISO = dateString.replace(" ", "T");
        return new Date(dateISO);
    }

    $scope.accept=function(i){
        //Ajouter fondUtilisateur
        db.collection("fondUtilisateur") // Nom de la collection
            .add(setDataFirestore($scope.transactionsFond[i])) // Les données à insérer
            .then((docRef) => {
                console.log("Document ajouté avec ID: ", docRef.id);
            })
            .catch((error) => {
                console.error("Erreur lors de l'ajout du document: ", error);
            });

        //Supprimer la requête
        if($scope.transactionsFond[i].mobile){
            db.collection("fondUtilisateurRequest") // Nom de la collection
                .doc($scope.transactionsFond[i].idFirestore) // ID du document à supprimer
                .delete() // Supprime le document
                .then(() => {
                    console.log("Document supprimé avec succès!");
                })
                .catch((error) => {
                    console.error("Erreur lors de la suppression du document: ", error);
                });
        }
        else{
            $http.post(`/transaction/accept/${$scope.transactionsFond[i].idTransFondRequest}`,{
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function(response){
                console.log("Inserted");
            });
        }
        $scope.transactionsFond.splice(i,1);
    }

    $scope.decline=function(i){
        if($scope.transactionsFond[i].mobile){
            console.log($scope.transactionsFond[i].idFirestore);
            db.collection("fondUtilisateurRequest") // Nom de la collection
                .doc($scope.transactionsFond[i].idFirestore) // ID du document à supprimer
                .delete() // Supprime le document
                .then(() => {
                    console.log("Document supprimé avec succès!");
                })
                .catch((error) => {
                    console.error("Erreur lors de la suppression du document: ", error);
                });
        }
        else{
            $http.post(`/transaction/decline/${$scope.transactionsFond[i].idTransFondRequest}`,{
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function(response){
                console.log("Inserted");
            });
        }
        $scope.transactionsFond.splice(i,1);
    }

    function formatDateTime(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Mois commence à 0
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }
    $scope.utilisateur = "";
});
