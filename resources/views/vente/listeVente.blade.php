@extends('template')
@section('title','Liste vente - Crypta')
@section('links')
@endsection
@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Liste des Transactions</h4>
                <table class="table table-hoverable">
                    <thead>
                    <tr>
                        <th>Operation</th>
                        <th>Montant</th>
                        <th>Quantite</th>
                        <th>Date de transaction</th>
                        <th>Cryptomonnaie</th>
                        <th>Utilisateur</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <?php $transaction->setCalculatedValue() ?>
                    <tr>
                        <td class="{{$transaction->styleClass}} font-weight-bold">{{$transaction->operation}}</td>
                        <td>{{number_format($transaction->prixUnitaire*$transaction->quantite, 2)}}</td>
                        <td>{{$transaction->quantite}}</td>
                        <td>{{$transaction->dateTransaction}}</td>
                        <td>{{$transaction->crypto->crypto}}</td>
                        <td>{{$transaction->utilisateur->pseudo}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <nav aria-label="...">
                        <ul class="pagination">
                            @if($page-1>0)
                                <li class="page-item"><a class="page-link" href="{{$path}}?page={{$page-1}}">Précédent</a></li>
                            @endif
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{$page}}</span>
                            </li>
                            @if($page+1<=$nbPages)
                            <li class="page-item"><a class="page-link" href="{{$path}}?page={{$page+1}}">Suivant</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
