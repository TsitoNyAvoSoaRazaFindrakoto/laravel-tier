@extends('template')
@section('title','Liste portefeuille - Crypta')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Liste des portefeuilles</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Crypto</th>
                            <th>Solde</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($portefeuilles as $portefeuille)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $portefeuille->crypto->crypto }}</td>
                            <td>{{ number_format($portefeuille->solde, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
