@extends('template')
@section('title','Historique - Crypto')
@section('content')
    <div ng-app="transactionApp" ng-controller="transactionController">
        <div class="row mb-3">
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
                        <div class="row">
                            <div class="col-md-6">
                                <select ng-model="crypto" class="form-select" aria-label="Default select example" ng-options="option.idCrypto as option.crypto for option in cryptos">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Historique des achats/ventes</h4>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Opération</th>
                                <th>Montant</th>
                                <th>Quantité</th>
                                <th>Date de transaction</th>
                                <th>Cryptomonnaie</th>
                                @if($isAdmin)
                                <th>Utilisateur</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="transaction in transactionsCrypto | searchByNameAndDate:name:startDate:endDate:crypto">
                                <td class="[[transaction.styleClass]] font-weight-bold">[[ transaction.operation ]] <i
                                        class="[[ transaction.icon ]]"></i></td>
                                <td>[[ transaction.prixUnitaire*transaction.quantite ]]</td>
                                <td>[[ transaction.quantite ]]</td>
                                <td>[[ transaction.dateTransaction ]]</td>
                                <td>[[ transaction.crypto.crypto ]]</td>
                                @if($isAdmin)
                                <td>
                                    <a href="/transaction/details/[[transaction.utilisateur.idUtilisateur]]-utilisateur">[[transaction.utilisateur.pseudo]]</a>
                                </td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
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
@endsection
@section('script')
    <script>
        const dataCrypto =<?php echo($transactionsCrypto) ?>;
        const dataFonds = {};
        const cryptos = <?php echo($cryptos)?>;
    </script>
    <script src="{{ asset('angular/angular.min.js') }}"></script>
    <script src="{{ asset('angular/angular-route.js') }}"></script>
    <script src="{{ asset('app-angular/historique_transaction.js') }}"></script>
@endsection
