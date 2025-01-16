@extends('template')
@section('title','Statistique - Crypta')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistique transaction utilisateur</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Total achat</th>
                            <th>Total vente</th>
                            <th>Valeur portefeuille</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($statistiques as $statistique)
                            <tr>
                                <td>{{ $statistique->idUtilisateur }}</td>
                                <td>{{ $statistique->achat }}</td>
                                <td>{{ $statistique->vente }}</td>
                                <td>{{ number_format($statistique->solde, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
