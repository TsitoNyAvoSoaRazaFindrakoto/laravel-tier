<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#vente" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Vente</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="vente">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('/vente')}}">Insertion vente</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('/vente/liste_vente')}}">Liste des ventes</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#achat" aria-expanded="false" aria-controls="ui-basics">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Achat</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="achat">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('/achat') }}">Insertion achat</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('/achat/liste_achat') }}">Liste des Achats</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#transaction" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Transaction</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="transaction">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/depot') }}">Insertion Depot</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/retrait') }}">Insertion Retrait</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/transaction/request') }}">Voir les requetes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/transaction/historique') }}">Voir les historiques</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#portefeuille" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Portefeuille</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="portefeuille">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/portefeuille/liste_portefeuille">portefeuille</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#dashboard" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Dashboard</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="dashboard">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/dashboard") }}">Evolution graphique</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/parametre") }}">Parametre des commissions</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/achat") }}">Liste des achats</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/vente") }}">Liste des ventes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/porte-feuille") }}">Liste des porte feuille</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#analyse" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Analyse</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="analyse">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/analyse/crypto") }}">Cryptos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/analyse/commission") }}">Commissions</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
