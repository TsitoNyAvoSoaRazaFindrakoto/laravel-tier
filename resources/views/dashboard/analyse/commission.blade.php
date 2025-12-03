@extends('template')
@section('title','Formulaire parametre - Crypta')
@section('links')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="border: solid 1px;border-radius: 15px;">
                    <h4 class="card-title">Analyse des comission</h4>
                    <form action="/dashboard/analyse/commission" method="post">
                        @csrf
                        <div id="achat">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select name="typeAnalyse" class="form-select" aria-label="Default select example">
                                            <option value="Somme" selected>Somme</option>
                                            <option value="Moyenne">Moyenne</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select name="crypto" class="form-select" aria-label="Default select example">
                                            <option value="0" selected>Tous</option>
                                            @foreach($cryptos as $crypto)
                                                <option value="{{ $crypto->idCrypto  }}">{{ $crypto->crypto  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" name="dateHeureMin" class="form-control" id="floatingInput" placeholder="Date et Heure Minimum">
                                    <label for="floatingInput">Date et Heure Minimum</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" name="dateHeureMax" class="form-control" id="floatingInput" placeholder="Date et Heure Maximum">
                                    <label for="floatingInput">Date et Heure Maximum</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">

                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-primary" type="submit">Analyser</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
