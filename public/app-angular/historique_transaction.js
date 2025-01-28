let transactionApp = angular.module("transactionApp",["ngRoute"]);

transactionApp.controller('transactionController', function($scope, $http) {
    $scope.transactionsFond=dataFonds;
});
