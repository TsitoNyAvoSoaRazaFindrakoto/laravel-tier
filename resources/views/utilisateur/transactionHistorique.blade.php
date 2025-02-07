@extends('template')
@section('title','Historique - Crypto')
@section('style')
    <style>
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #eee;
        }

        .user-details {
            flex-grow: 1;
        }

        .username {
            font-weight: 500;
        }

        .date {
            color: #666;
            font-size: 0.9em;
        }

        .transaction-details {
            font-size: 0.95em;
            line-height: 1.6;
        }

        .transaction-details div {
            margin-bottom: 5px;
        }
    </style>
@endsection
@section('content')
    <div ng-app="transactionApp" ng-controller="transactionController">
        <div class="row mb-3">
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Filtre historique</h4>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" ng-model="startDate" name="dateMin" class="form-control"
                                           id="floatingInput" placeholder="Quantite">
                                    <label for="floatingInput">Date minimum</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="date" ng-model="endDate" name="dateMax"
                                           class="form-control"
                                           id="floatingInput" placeholder="Quantite">
                                    <label for="floatingInput">Date maximum</label>
                                </div>
                            </div>
                        </div>
                        @if($isAdmin)
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" ng-model="name" class="form-control" id="floatingInput"
                                               placeholder="Utilisateur">
                                        <label for="floatingInput">Utilisateur</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <select ng-model="crypto" class="form-select" aria-label="Default select example"
                                        ng-options="option.idCrypto as option.crypto for option in cryptos">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item" ng-if="index != 0">
                                            <button ng-click="previous()" class="page-link">Previous</button>
                                        </li>
                                        <li class="page-item" ng-if="index+1 != dataPaginated.length">
                                            <button ng-click="next()" class="page-link">Next</button>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card"
                 ng-repeat="transaction in transactionsCrypto | searchByNameAndDate:name:startDate:endDate:crypto">
                <div class="user-info">
                    <div class="avatar"><img src="[[ transaction.utilisateur.img ]]&tr=w-50,h-50"
                                             style="border-radius: 30px"/></div>
                    <div class="user-details">
                        <div class="username">[[transaction.utilisateur.pseudo]]</div>
                        <div class="date">[[transaction.dateTransaction]]</div>
                    </div>
                </div>
                <div class="[[transaction.styleClass]] font-weight-bold">[[transaction.operation]] <i
                        class="[[ transaction.icon ]]"></i></div>
                <div class="transaction-details">
                    <div>Montant : [[transaction.prixUnitaire*transaction.quantite]]</div>
                    <div>Quantité : [[transaction.quantite]]</div>
                    <div>Crypto : [[transaction.crypto.crypto]]</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const dataCrypto =<?php echo($transactionsCrypto) ?>;
        const dataFonds = {};
        const cryptos = <?php echo($cryptos) ?>;
        const images = <?php echo(json_encode($images)) ?>;
    </script>
    <script src="{{ asset('angular/angular.min.js') }}"></script>
    <script src="{{ asset('angular/angular-route.js') }}"></script>
    <script src="{{ asset('app-angular/historique_transaction.js') }}"></script>
@endsection
