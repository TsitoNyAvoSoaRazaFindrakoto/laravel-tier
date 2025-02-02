let transactionApp = angular.module("transactionApp",["ngRoute"]).config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

transactionApp.controller('transactionController', function($scope, $http) {
    $scope.transactionsCrypto=dataCrypto;
    $scope.utilisateur="";
});
