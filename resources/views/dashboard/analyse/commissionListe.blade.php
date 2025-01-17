@extends('template')
@section('title','Liste vente - Crypta')
@section('links')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistique {{$typeAnalyse}}</h4>
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

                </div>
            </div>
        </div>
    </div>
@endsection
