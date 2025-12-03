<li class="nav-item">
    <a class="nav-link" href="/profile">
        <i class="icon-grid mdi mdi-account"></i>
        <span class="menu-title" style="margin-left: 10%">Profile</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="/transaction/utilisateur">
        <i class="icon-grid mdi mdi-cash-multiple"></i>
        <span class="menu-title" style="margin-left: 10%">Mes opérations</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#transaction" aria-expanded="false" aria-controls="form-elements">
        <i class="icon-columns mdi mdi-arrow-expand"></i>
        <span class="menu-title" style="margin-left: 10%">Transaction</span>
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
    <a class="nav-link" data-toggle="collapse" href="#dashboard" aria-expanded="false" aria-controls="form-elements">
        <i class="icon-columns mdi mdi-gauge"></i>
        <span class="menu-title" style="margin-left: 10%">Tableau de bord</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="dashboard">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/cours-crypto") }}">Evolution graphique</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/parametre") }}">Paramètre
                    commissions</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/porte-feuille") }}">Liste des porte feuille</a></li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#analyse" aria-expanded="false" aria-controls="form-elements">
        <i class="icon-columns mdi mdi-magnify"></i>
        <span class="menu-title" style="margin-left: 10%">Analyse</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="analyse">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/analyse-crypto") }}">Cryptos</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url("dashboard/analyse/commission") }}">Commissions</a>
            </li>
        </ul>
    </div>
</li>
