@extends('template')
@section('title','Liste vente - Crypta')
@section('links')
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Liste des ventes</h4>
                <table class="table table-hoverable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Montant</th>
                        <th>Quantite</th>
                        <th>Date de transaction</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ventes as $vente)
                    <tr>
                        <td>{{$vente->idTransCrypto}}</td>
                        <td>{{number_format($vente->prixUnitaire*$vente->sortie, 2)}}</td>
                        <td>{{$vente->sortie}}</td>
                        <td>{{$vente->dateTransaction}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
