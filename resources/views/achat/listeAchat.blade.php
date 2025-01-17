@extends('template')
@section('title','Liste achat - Crypta')
@section('links')
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Liste des achats</h4>
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
                    @foreach($achats as $achat)
                    <tr>
                        <td>{{$achat->idTransCrypto}}</td>
                        <td>{{number_format($achat->prixUnitaire*$achat->entree,2)}}</td>
                        <td>{{$achat->entree}}</td>
                        <td>{{$achat->dateTransaction}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
