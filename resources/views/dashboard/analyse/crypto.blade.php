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
                    <h4 class="card-title">Analyse des cryptos</h4>
                    <form action="/dashboard/analyse/crypto" method="post">
                        @csrf
                        <div id="achat">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select name="typeAnalyse" class="form-select" aria-label="Default select example">
                                            <option value="1er Quartile" selected>1er Quartile</option>
                                            <option value="Maximum">Maximum</option>
                                            <option value="Minimum">Minimum</option>
                                            <option value="Moyenne">Moyenne</option>
                                            <option value="ecart-type">Ecart-type</option>
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
                            <div class="col-md-6" style="margin-left: 5%">
                                <div class="form-check">
                                    <input value="1" class="form-check-input" type="checkbox" name="Tous" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Tous
                                    </label>
                                </div>
                                @foreach($cryptos as $crypto)
                                    <div class="form-check">
                                        <input value="{{$crypto->idCrypto}}" class="form-check-input" type="checkbox" name="{{$crypto->crypto}}" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            {{ $crypto->crypto  }}
                                        </label>
                                    </div>
                                @endforeach
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
