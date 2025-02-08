<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="{{asset('images/Crypta.png')}}" class="mr-2" alt="logo"></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('images/mini-Crypta.png')}}" class="mr-2" alt="logo"></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background-color: #4B49AC;">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu" style="color: white"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">

                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-settings d-none d-lg-flex">
                <p style="color: white" class="font-weight-bold">Solde : <p id="solde" style="color: white">{{$solde}}</p></p>
            </li>
            <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="{{ url('/') }}" style="margin-left: 10%;color: white">
                    Deconnection
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
