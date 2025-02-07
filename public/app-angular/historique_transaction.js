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
    console.log($scope.cryptos);

    for(let i=0;i<cryptos.length;i++){
        $scope.cryptos.push(cryptos[i]);
    }

    console.log($scope.dataCrypto);
    $scope.index=0;

    $scope.next=function(){
        $scope.index++;
        $scope.transactionsCrypto=$scope.dataPaginated[$scope.index];
    }
    $scope.previous=function(){
        $scope.index--;
        $scope.transactionsCrypto=$scope.dataPaginated[$scope.index];
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
        $scope.transactionsCrypto=$scope.dataPaginated[$scope.index];
    }

    $scope.paginate(dataCrypto,10);
});
