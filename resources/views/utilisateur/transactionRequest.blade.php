@extends('template')
@section('title','Liste achat - Crypta')
@section('links')
@endsection
@section('content')
    <div class="row mb-3" ng-app="transactionApp" ng-controller="transactionController">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Les requêtes dépot/retrait</h4>
                    <div class="form-floating mb-3">
                        <input type="text" style="width:25%" ng-model="utilisateur" class="form-control" id="floatingInput" placeholder="Utilisateur">
                        <label for="floatingInput">Utilisateur</label>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Opération</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Utilisateur</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="transaction in transactionsFond | filter:utilisateur">
                            <td class="[[transaction.styleClass]] font-weight-bold">[[ transaction.operation ]] <i class="[[ transaction.icon ]]"></i></td>
                            <td>[[ transaction.montant ]]</td>
                            <td>[[ transaction.dateTransaction ]]</td>
                            <td>[[ transaction.utilisateur.pseudo ]]</td>
                            <td><button class="btn btn-success" ng-click="accept([[$index]])">Valider</button></td>
                            <td><button class="btn btn-danger" ng-click="decline([[$index]])">Refuser</button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    {{--                    <img src="..." class="rounded me-2" alt="...">--}}
                    <strong class="me-auto">Crypto</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <div class="alert [[styleMessage]]" role="alert">
                        [[message]]
                    </div>
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
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
    <script src="{{ asset('bootstrap-5/js/bootstrap.bundle.min.js') }}"></script></body>
    <script src="{{ asset('angular/angular.min.js') }}"></script>
    <script src="{{ asset('angular/angular-route.js') }}"></script>
    <script src="{{ asset('app-angular/transaction_request.js') }}"></script>
@endsection
