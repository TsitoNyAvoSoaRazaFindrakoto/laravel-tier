@extends('template')
@section('title','Liste achat - Crypta')
@section('links')
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Historique des opération</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Opération</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactionsFond as $transaction)
                            <tr>
                                <td>{{ $transaction->getOperationName() }}</td>
                                <td>{{ number_format($transaction->getMontant(), 2)  }}</td>
                                <td>{{ $transaction->dateTransaction }}</td>
                                <td>{{ $transaction->utilisateur->pseudo }}</td>
                                <td><a href="/transaction/accept/{{$transaction->idTransFondRequest}}">Accepter</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
