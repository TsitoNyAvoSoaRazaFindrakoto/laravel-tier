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
                    <h4 class="card-title">Parametre commission</h4>
                    <form action="/dashboard/parametre" method="post">
                        @csrf
                        <div id="achat">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="achatComission" class="form-control" id="floatingInput" placeholder="Achat Comission">
                                        <label for="floatingInput">Achat Comission</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="venteComission" class="form-control" id="floatingInput" placeholder="Vente Comission">
                                        <label for="floatingInput">Vente Comission</label>
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
