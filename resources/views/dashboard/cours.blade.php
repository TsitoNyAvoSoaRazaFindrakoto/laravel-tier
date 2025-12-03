@extends('template')
@section('title','Evolution des Cryptos - Crypta')
@section('style')
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Arial', sans-serif;
        }

        .crypto-card {
            background-color: white;
            color: #000;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 10%;
        }

        .crypto-card h4 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .crypto-card p {
            margin: 0;
        }

        .crypto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
@section('content')
    <div class="container py-5" ng-app="coursApp" ng-controller="coursController">
        <div class="row text-center">
            <div class="col-md-3" ng-repeat="cour in cours">
                <div class="crypto-card">
                    <h4>[[cour.crypto.crypto]]</h4>
                    <p>Valeur: [[cour.prixUnitaire]] Ar</p>
                    <div class="row mb-3" ng-if="cour.variation">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                            <p class="[[cour.styleClass]]">[[cour.variation]]<i class="[[ cour.icon ]]"></i></p>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" ng-model="cour.quantite" step="0.001" class="form-control" id="floatingInput" placeholder="Quantite">
                                <label for="floatingInput">Quantite</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <button id="buy[[cour.crypto.idCrypto]]" class="btn btn-success" ng-click="buy(cour.crypto.idCrypto)">Acheter</button>
                        </div>
                        <div class="col-md-6">
                            <button id="sell[[cour.crypto.idCrypto]]" class="btn btn-danger" ng-click="sell(cour.crypto.idCrypto)">Vendre</button>
                        </div>
                    </div>
                    <div class="row">
                        <button ng-click="turnGraphe(cour.crypto)" class="btn btn-primary">Voir graphe</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="graphe">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Evolution cours [[crypto]]</h4>
                        <canvas id="lineChart"></canvas>
                    </div>
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
        const cours =<?php echo(json_encode($cours)) ?>;
        const chartEvolution =<?php echo(json_encode($evolutionCryptos)) ?>;
        const crypto=<?php echo($crypto) ?>;
        const idCrypto=<?php echo($idCrypto) ?>;
        const idUtilisateur=<?php echo($idUtilisateur) ?>;
    </script>
    <script src="{{ asset('skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('skydash/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
    <script src="{{ asset('bootstrap-5/js/bootstrap.bundle.min.js') }}"></script></body>
    <script src="{{ asset('angular/angular.min.js') }}"></script>
    <script src="{{ asset('angular/angular-route.js') }}"></script>
    <script src="{{ asset('app-angular/cours.js') }}"></script>
@endsection
