let transactionApp = angular.module("transactionApp",["ngRoute"]).config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

transactionApp.controller('transactionController', function($scope, $http) {
    $scope.transactionsCrypto=dataCrypto;
    $scope.transactionsFond=dataFonds;
    console.log($scope.transactionsFond);
    $scope.utilisateur="";
});
