@extends('template')
@section('title','Historique - Crypto')
@section('style')
    <style>
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
        }

        .profile-info h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 10px;
        }

        .letter-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #4b49ac;
            color: white;
            font-size: 24px;
            font-weight: bold;
            border-radius: 50%; /* Rond */
            text-transform: uppercase;
        }

        .profile-info p {
            color: #666;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .bitcoin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .bitcoin-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .bitcoin-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #ddd;
        }

        .bitcoin-info h3 {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 5px;
        }

        .bitcoin-info p {
            color: #666;
            font-size: 0.9em;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img id="photo" src="" style="border-radius: 100px"/>
                </div>
                <div class="profile-info">
                    <h1>{{$utilisateur->pseudo}}</h1>
                    <p>{{$utilisateur->email}}</p>
                    <p>Solde : {{$solde}} Ar</p>
                    <p><a href="/profile/modification">Modifier information</a></p>
                </div>
            </div>

            <div class="bitcoin-grid">
                @foreach($porteFeuilles as $porteFeuille)
                    <div class="bitcoin-card">
                        <div class="letter-icon">{{Str::substr($porteFeuille->crypto->crypto, 0, 1);}}</div>
                        <div class="bitcoin-info">
                            <h3>{{$porteFeuille->crypto->crypto}}</h3>
                            <p>Quantité: {{$porteFeuille->solde}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const idUtilisateur={{$utilisateur->idUtilisateur}};
    </script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
    <script src="{{ asset('app-angular/profile.js') }}"></script>
@endsection
