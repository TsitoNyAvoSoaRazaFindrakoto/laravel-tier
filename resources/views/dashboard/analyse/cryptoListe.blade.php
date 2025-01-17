@extends('template')
@section('title','Liste vente - Crypta')
@section('links')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @if($typeAnalyse=="ecart-type")
                    <h4 class="card-title">Statistique ecart-type</h4>
                    <table class="table table-hoverable">
                        <thead>
                        <tr>
                            <th>Ecart-type echantillon</th>
                            <th>Ecart-type population</th>
                            <th>Cryptomonnaie</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stats as $stat)
                            <tr>
                                <td>{{$stat->ecartTypeEchantillon}}</td>
                                <td>{{$stat->ecartTypePopulation}}</td>
                                <td>{{$stat->crypto->crypto}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                    @if($typeAnalyse!="ecart-type")
                            <h4 class="card-title">Statitstique {{$typeAnalyse}}</h4>
                            <table class="table table-hoverable">
                                <thead>
                                <tr>
                                    <th>{{ $typeAnalyse }}</th>
                                    <th>Cryptomonnaie</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($stats as $stat)
                                    <tr>
                                        <td>{{$stat->stat}}</td>
                                        <td>{{$stat->crypto->crypto}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                </div>
            </div>
        </div>
    </div>
@endsection
