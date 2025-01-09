@extends('template')
@section('title','Formulaire achat - Crypta')
@section('links')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="border: solid 1px;border-radius: 15px;">
                    <h4 class="card-title">Insertion Achat</h4>
                    <p>{{$message}}</p>
                    <form action="/achat" method="post">
                        @csrf
                        <div id="achat">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="idCrypto" class="form-select" aria-label="Default select example">
                                        <option selected>Crypto</option>
                                        @foreach($cryptos as $crypto)
                                        <option value="{{ $crypto->idCrypto  }}">{{ $crypto->crypto  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="quantite" class="form-control" id="floatingInput" placeholder="Quantite">
                                        <label for="floatingInput">Quantite</label>
                                    </div>
                                </div>
                                <input type="hidden" value="200" name="montant" class="form-control" id="floatingInput" placeholder="Quantite">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">

                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary" type="submit">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
