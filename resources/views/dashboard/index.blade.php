@extends('template')
@section('title','Evolution des Cryptos - Crypta')
@section('content')
    <div class="row mb-3">
        <div class="col-md-3">
            <!-- Espace vide pour la mise en page -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Filtre Crypto</h4>
                    <form action="/dashboard" method="get">
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <select name="idCrypto" class="form-select" aria-label="Default select example">
                                    @foreach($cryptos as $crypto)
                                        <option value="{{$crypto->idCrypto}}"
                                                @if($crypto->idCrypto==$idCrypto) selected @endif>{{$crypto->crypto}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-outline-primary">Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <!-- Espace vide pour la mise en page -->
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" ng-app="dashboardApp" ng-controller="dashboardController">
                    <h4 class="card-title">Evolution cours cryptommonaie</h4>
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const chartEvolution =<?php echo(json_encode($evolutionCryptos)) ?>;
        const crypto=<?php echo($crypto) ?>;
        const idCrypto=<?php echo($idCrypto) ?>;
    </script>
    <script src="{{ asset('skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('skydash/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('angular/angular.min.js') }}"></script>
    <script src="{{ asset('angular/angular-route.js') }}"></script>
    <script src="{{ asset('app-angular/dashboard.js') }}"></script>
@endsection
