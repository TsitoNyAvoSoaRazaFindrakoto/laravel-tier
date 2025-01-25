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
                                        <input type="date" value="{{$dateMin}}" name="dateMin" class="form-control" id="floatingInput" placeholder="Quantite">
                                        <label for="floatingInput">Date minimum</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" name="dateMax" value="{{$dateMax}}" class="form-control" id="floatingInput" placeholder="Quantite">
                                        <label for="floatingInput">Date maximum</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="achat">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="idCrypto" class="form-select" aria-label="Default select example">
                                        <option selected>Crypto</option>
                                        @foreach($cryptos as $crypto)
                                            <option value="{{ $crypto->idCrypto }}" @if($crypto->idCrypto==$idCrypto) selected @endif>{{ $crypto->crypto  }}</option>
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
    <div class="row mb-3">
        <div class="col-md-6">
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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactionsFond as $transaction)
                            <tr>
                                <td>{{ $transaction->getOperationName() }}</td>
                                <td>{{ number_format($transaction->getMontant(), 2)  }}</td>
                                <td>{{ $transaction->dateTransaction }}</td>
                                <td><a href="/liste/transaction/{{$transaction->utilisateur->idUtilisateur}}">{{ $transaction->utilisateur->pseudo }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Historique des achats/ventes</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Opération</th>
                            <th>Quantité</th>
                            <th>Date</th>
                            <th>Cryptomonnaie</th>
                            <th>Utilisateur</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactionsCrypto as $transaction)
                            <tr>
                                <td>{{ $transaction->getOperationName() }}</td>
                                <td>{{ number_format($transaction->getMontant(), 2)  }}</td>
                                <td>{{ $transaction->dateTransaction }}</td>
                                <td>{{ $transaction->crypto->crypto }}</td>
                                <td><a href="/liste/transaction/{{$transaction->utilisateur->idUtilisateur}}">{{ $transaction->utilisateur->pseudo }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
