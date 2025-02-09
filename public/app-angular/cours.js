let coursApp = angular.module("coursApp",["ngRoute"]).config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

coursApp.controller('coursController', function($scope, $http) {
    $scope.cours=cours;
    $scope.idCrypto=idCrypto;
    $scope.crypto=crypto.crypto;
    $scope.idUtilisateur=idUtilisateur;
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
        $scope.setIfFavoriteBuy($scope.idUtilisateur);
    }

    $scope.setIfFavoriteBuy=function(idUtilisateur){
        db.collection("utilisateur")
            .where("idUtilisateur", "==", idUtilisateur)
            .get()
            .then((querySnapshot) => {
                querySnapshot.forEach((doc) => {
                    data=doc.data();
                    for(let i=0;i<data.favoris.length;i++){
                        if($scope.transaction.idCrypto+""===data.favoris[i]){
                            $scope.transaction.favori=true;
                            $scope.transaction.mtoken=data.mToken;
                            break;
                        }
                        $scope.transaction.favori=false;
                    }
                    if($scope.transaction.favori){
                        window.location.href = `http://127.0.0.1:8000/achat/insertion_achat?idCrypto=${idCrypto}&quantite=${$scope.transaction.quantite}&mtoken=${$scope.transaction.mtoken}&favori=true`;
                    }
                    else{
                        window.location.href = `http://127.0.0.1:8000/achat/insertion_achat?idCrypto=${idCrypto}&quantite=${$scope.transaction.quantite}&favori=false`;
                    }
                });
            })
            .catch((error) => {
                console.error("Erreur lors de la récupération des documents :", error);
            });
    }

    $scope.setIfFavoriteSell=function(idUtilisateur){
        db.collection("utilisateur")
            .where("idUtilisateur", "==", idUtilisateur)
            .get()
            .then((querySnapshot) => {
                querySnapshot.forEach((doc) => {
                    data=doc.data();
                    for(let i=0;i<data.favoris.length;i++){
                        if($scope.transaction.idCrypto+""===data.favoris[i]){
                            $scope.transaction.favori=true;
                            $scope.transaction.mtoken=data.mToken;
                            break;
                        }
                        $scope.transaction.favori=false;
                    }
                    console.log(JSON.stringify($scope.transaction));
                    $http.post(`/vente/insertion_vente`,$scope.transaction,{
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }).then(function(response){
                        if(response.data.status==200){
                            addToFirestore("fondUtilisateur",response.data.data.fondUtilisateur);
                            addToFirestore("transCrypto",response.data.data.transaction);
                            $scope.styleMessage="alert-success";
                        }
                        else{
                            $scope.styleMessage="alert-danger";
                        }
                        $scope.message=response.data.message;
                        var venteSuccess = document.getElementById('toast');
                        var toast = new bootstrap.Toast(venteSuccess);
                        toast.show();
                    });
                });
            })
            .catch((error) => {
                console.error("Erreur lors de la récupération des documents :", error);
            });
    }

    $scope.sell = function (idCrypto){
        $scope.transaction={};
        $scope.transaction.idCrypto=idCrypto;
        $scope.transaction.quantite=getQuantityCoursById(idCrypto);
        $scope.setIfFavorite($scope.idUtilisateur);
    }
    function getQuantityCoursById(idCrypto){
        for (i=0;i<$scope.cours.length;i++) {
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

    $scope.chartEvolution = chartEvolution;
    /* ChartJS
     * -------
     * Data and config for chartjs
     */
    'use strict';
    var data = {
        labels: $scope.chartEvolution.labels,
        datasets: [{
            label: 'Cours cryptomonnaie' ,
            data: $scope.chartEvolution.data,
            borderWidth: 2,
            borderColor: '#4b49ac', // Couleur de la ligne
            backgroundColor: '#4b49ac',
            fill: false
        }]
    };
    var options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            display: false
        },
        elements: {
            point: {
                radius: 5, // Taille des points (en pixels)
                backgroundColor: '#ff4757', // Couleur des points
                borderColor: '#4b49ac', // Bordure des points
                borderWidth: 2 // Largeur de la bordure des points
            }
        }

    };
    var lineChart = null;
    // Get context with jQuery - using jQuery's .get() method.
    if ($("#lineChart").length) {
        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: data,
            options: options
        });
    }

    function updateChart(newLabels, newData) {
        lineChart.data.labels = newLabels; // Met à jour les labels
        lineChart.data.datasets[0].data = newData; // Met à jour les données du dataset
        lineChart.update(); // Applique les changements
    }

    function threadChart(){
        setTimeout(() => {
            getDataChart();
        }, 10000);
    }

    function getDataChart(){
        $http.get(`http://127.0.0.1:8000/dashboard/crypto/${$scope.idCrypto}`)
            .then(function(response) {
                $scope.chartEvolution = response.data; // Assigner les données récupérées
                updateChart($scope.chartEvolution.labels,$scope.chartEvolution.data);
            })
            .catch(function(error) {
                console.error('Erreur lors de la requête :', error);
            });
        threadChart();
    }

    $scope.turnGraphe=function(crypto){
        $http.get(`http://127.0.0.1:8000/dashboard/crypto/${$scope.idCrypto}`)
            .then(function(response) {
                $scope.chartEvolution = response.data; // Assigner les données récupérées
                updateChart($scope.chartEvolution.labels,$scope.chartEvolution.data);
                const cible = document.getElementById('graphe'); // Remplace 'monDiv' par l'ID de ton div
                cible.scrollIntoView({
                    behavior: 'smooth', // Défilement fluide
                    block: 'start',     // Aligner le div au début de la vue
                    inline: 'nearest'   // Alignement horizontal (si besoin)
                });
                $scope.idCrypto=crypto.idCrypto;
                $scope.crypto=crypto.crypto;
            })
            .catch(function(error) {
                console.error('Erreur lors de la requête :', error);
            });
    }

    threadChart();

    thread();
});
