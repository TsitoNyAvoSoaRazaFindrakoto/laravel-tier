let dashboardApp = angular.module("dashboardApp", ["ngRoute"]).config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

dashboardApp.controller('dashboardController', function ($scope, $http) {
    $scope.chartEvolution = chartEvolution;
    /* ChartJS
     * -------
     * Data and config for chartjs
     */
    'use strict';
    var data = {
        labels: $scope.chartEvolution.labels,
        datasets: [{
            label: 'Cours ' + crypto.crypto,
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
                radius: 0
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

    function thread(){
        setTimeout(() => {
            getDataChart();
        }, 10000);
    }

    function getDataChart(){
        $http.get(`http://127.0.0.1:8000/dashboard/crypto/${idCrypto}`)
            .then(function(response) {
                $scope.chartEvolution = response.data; // Assigner les données récupérées
                updateChart($scope.chartEvolution.labels,$scope.chartEvolution.data);
                console.log("Fetched");
            })
            .catch(function(error) {
                console.error('Erreur lors de la requête :', error);
            });
        thread();
    }

    thread();
});
