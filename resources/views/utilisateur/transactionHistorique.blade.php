@extends('template')
@section('title','Historique - Crypto')
@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filtre historique</h4>
                    <form action="{{ $formSubmit }}" method="get">
                        <div id="achat">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" value="{{$dateMin}}" name="dateMin" class="form-control"
                                               id="floatingInput" placeholder="Quantite">
                                        <label for="floatingInput">Date minimum</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="dateMax" value="{{$dateMax}}" class="form-control"
                                               id="floatingInput" placeholder="Quantite">
                                        <label for="floatingInput">Date maximum</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="achat">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="idCrypto" class="form-select" aria-label="Default select example">
                                        <option selected value="0">Tous</option>
                                        @foreach($cryptos as $crypto)
                                            <option value="{{ $crypto->idCrypto }}"
                                                    @if($crypto->idCrypto==$idCrypto) selected @endif>{{ $crypto->crypto  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">

                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary" type="submit">Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div ng-app="transactionApp" ng-controller="transactionController">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Historique des achats/ventes</h4>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" ng-model="utilisateurAchat" class="form-control" id="floatingInput"
                                       placeholder="Utilisateur">
                                <label for="floatingInput">Utilisateur</label>
                            </div>
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Opération</th>
                                <th>Montant</th>
                                <th>Quantité</th>
                                <th>Date de transaction</th>
                                <th>Cryptomonnaie</th>
                                <th>Utilisateur</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="transaction in transactionsCrypto | filter:utilisateurAchat">
                                <td class="[[transaction.styleClass]] font-weight-bold">[[ transaction.operation ]] <i class="[[ transaction.icon ]]"></i></td>
                                <td>[[ transaction.prixUnitaire*transaction.quantite ]]</td>
                                <td>[[ transaction.quantite ]]</td>
                                <td>[[ transaction.dateTransaction ]]</td>
                                <td>[[ transaction.crypto.crypto ]]</td>
                                <td>
                                    <a href="/transaction/details/[[transaction.utilisateur.idUtilisateur]]-utilisateur">[[transaction.utilisateur.pseudo]]</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const dataCrypto =<?php echo($transactionsCrypto) ?>;
    </script>
    <script src="{{ asset('angular/angular.min.js') }}"></script>
    <script src="{{ asset('angular/angular-route.js') }}"></script>
    <script src="{{ asset('app-angular/historique_transaction.js') }}"></script>
@endsection
