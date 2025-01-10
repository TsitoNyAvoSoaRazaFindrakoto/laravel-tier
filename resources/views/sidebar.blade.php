<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Vente</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{url('/vente')}}">Insertion vente</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{url('/vente/liste_vente')}}">Liste des ventes</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basics" aria-expanded="false" aria-controls="ui-basics">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Achat</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basics">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('/achat') }}">Insertion achat</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ url('/achat/liste_achat') }}">Liste des Achats</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Transaction</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/vente/form_vente">Insertion vente</a></li>
                    <li class="nav-item"><a class="nav-link" href="/vente/liste">Liste des ventes</a></li>
                    <li class="nav-item"><a class="nav-link" href="/vente/filter?idTypeProduit=Tous&idCategorie=Tous">Liste vente avec filtre</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/depot') }}">Insertion Depot</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/retrait') }}">Insertion Retrait</a></li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elementss" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Portefeuille</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elementss">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/portefeuille/liste_portefeuille">Liste des portefeuilles</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Dashboard</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/dashboard") }}">Evolution graphique</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
