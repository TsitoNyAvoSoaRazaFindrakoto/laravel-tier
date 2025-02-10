let transactionApp = angular.module("transactionApp", ["ngRoute"]).config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
}).filter('searchByNameAndDate', function() {
    return function(items, name, startDate, endDate,crypto) {
        if (!items) return [];

        return items.filter(function(item) {
            // Vérifier le critère de nom (ignorer la casse)
            if (name && !item.utilisateur.pseudo.toLowerCase().includes(name.toLowerCase())) {
                return false;
            }

            const itemDate = new Date(item.dateTransaction); // Convertir la date de l'élément
            // Vérifier la plage de dates
            if (startDate) {
                if(itemDate < new Date(startDate)){
                    return false;
                }
            }
            if(endDate){
                if (itemDate > new Date(endDate)) {
                    return false;
                }
            }

            if(crypto){
                if(crypto!=item.crypto.idCrypto && crypto!=0){
                    return false;
                }
            }

            // Si l'élément correspond à tous les critères, l'inclure
            return true;
        });
    };
});

transactionApp.controller('transactionController', function ($scope, $http) {
    $scope.transactionsCrypto = [];
    $scope.transactionsFond = [];
    $scope.utilisateur = "";
    $scope.dataCrypto=dataCrypto;
    $scope.dataPaginated=[];
    $scope.cryptos=[];
    $scope.cryptos.push({idCrypto:0,crypto:"Tous"});
    $scope.crypto=0;
    $scope.images=[];

    for(let i=0;i<cryptos.length;i++){
        $scope.cryptos.push(cryptos[i]);
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
    var db = firebase.firestore();

    db.collection("utilisateur")
        .get()
        .then((querySnapshot) => {
            querySnapshot.forEach((doc) => {
                const data = doc.data(); // Données du document
                const idUtilisateur = data.idUtilisateur; // ID du document (peut être différent de l'ID utilisateur stocké dans le document)
                $scope.$apply(function() {
                    if(doc.img!=undefined){
                        $scope.images.push({img:doc.img,idUtilisateur:idUtilisateur});
                    }
                    else{
                        $scope.images.push({img:"https://ik.imagekit.io/qmegcemhav/profile-pictures/default.jpg?updatedAt=1738953528745",idUtilisateur:idUtilisateur})
                    }
                });
            });
            $scope.paginate(dataCrypto,12);
        })
        .catch((error) => {
            console.error('Erreur lors de la récupération des données:', error);
        });

    $scope.index=0;

    $scope.next=function(){
        $scope.index++;
        $scope.transactionsCrypto=$scope.setImage($scope.dataPaginated[$scope.index]);
    }
    $scope.previous=function(){
        $scope.index--;
        $scope.transactionsCrypto=$scope.setImage($scope.dataPaginated[$scope.index]);
    }

    $scope.setImageById=function(dataCrypto){
        dataCrypto.utilisateur.img="https://ik.imagekit.io/qmegcemhav/profile-pictures/default.jpg?updatedAt=1738953528745";
        for(let i=0;i<$scope.images.length;i++){
            if($scope.images[i].idUtilisateur==dataCrypto.utilisateur.idUtilisateur){
                dataCrypto.utilisateur.img=$scope.images[i].img;
            }
        }
        return dataCrypto;
    }

    $scope.setImage=function(dataCrypto){
        for(let i=0;i<dataCrypto.length;i++){
            dataCrypto[i]=$scope.setImageById(dataCrypto[i]);
        }
        return dataCrypto;
    }

    $scope.paginate=function(dataCrypto,number){
        var data=[]
        for (let i=0;i<dataCrypto.length;i++){
            data.push(dataCrypto[i]);
            if(number==data.length){
                $scope.dataPaginated.push(data);
                data=[];
            }
        }
        if(data.length!=0){
            $scope.dataPaginated.push(data);
        }
        $scope.index=0;
        $scope.$apply(function (){
            $scope.transactionsCrypto=$scope.setImage($scope.dataPaginated[$scope.index]);
        });
    }
});
