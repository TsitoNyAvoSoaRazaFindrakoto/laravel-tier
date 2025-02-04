@extends('template')
@section('title','Liste achat - Crypta')
@section('links')
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" ng-app="transactionApp" ng-controller="transactionController">
                    <h4 class="card-title">Historique des opération</h4>
                    <div class="form-floating mb-3">
                        <input type="text" ng-model="utilisateur" class="form-control" id="floatingInput" placeholder="Utilisateur">
                        <label for="floatingInput">Utilisateur</label>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Opération</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Accepter</th>
                            <th>Refuser</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="transaction in transactionsFond | filter:utilisateur">
                            <td class="[[transaction.styleClass]] font-weight-bold">[[ transaction.operation ]] <i class="[[ transaction.icon ]]"></i></td>
                            <td>[[ transaction.montant ]]</td>
                            <td>[[ transaction.dateTransaction ]]</td>
                            <td>[[ transaction.utilisateur.pseudo ]]</td>
                            <td><a href="/transaction/accept/[[transaction.idTransFondRequest]]">Accepter</a></td>
                            <td><a href="/transaction/decline/[[transaction.idTransFondRequest]]">Refuser</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const dataFonds=<?php echo($transactionsFond) ?>;
        const dataCrypto={};
    </script>
    <script src="{{ asset('angular/angular.min.js') }}"></script>
    <script src="{{ asset('angular/angular-route.js') }}"></script>
    <script src="{{ asset('app-angular/historique_transaction.js') }}"></script>
@endsection
