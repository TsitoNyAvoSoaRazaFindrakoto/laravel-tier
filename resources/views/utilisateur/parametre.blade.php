<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crypta - Login</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{asset('images/mini-Crypta.png')}}">
    <style>
        body {
            background: linear-gradient(135deg, #4a4eb1, #667eea);
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            padding: 30px;
            text-align: center;
        }

        .login-card h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #4a4eb1;
            margin-bottom: 10px;
        }

        .login-card p {
            color: #666;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .btn-login {
            background-color: #4a4eb1;
            color: #fff;
            border-radius: 20px;
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background-color: #3b3e9e;
        }

        .signup-link {
            color: #4a4eb1;
            text-decoration: underline;
            font-size: 0.9rem;
        }

        .signup-link:hover {
            color: #3b3e9e;
        }
    </style>
</head>
<body>
<div class="login-card" ng-app="inscriptionApp" ng-controller="inscriptionController">
    <h1>Crypta</h1>
    <h2>Modification profile</h2>
    <p>Continuer sur Crypta</p>
    <div id="message">

    </div>
    <form ng-submit="submitForm()">
        <input ng-model="utilisateur.pseudo" type="pseudo" class="form-control" placeholder="Pseudo" required>
        <input ng-model="utilisateur.password" type="password" class="form-control" placeholder="Mot de passe">
        <input ng-model="passwordTest" type="password" class="form-control" placeholder="Confirmer mot de passe">
        <button type="submit" id="buttonLogin" class="btn btn-login">Modifier</button>
    </form>
</div>
<script>
    const pseudo="{{$pseudo}}";
    const token="{{$token}}";
</script>
<script src="{{ asset('angular/angular.min.js') }}"></script>
<script src="{{ asset('angular/angular-route.js') }}"></script>
<script src="{{ asset('app-angular/modification_utilisateur.js') }}"></script>
<script src="{{ asset('bootstrap-5/js/bootstrap.bundle.min.js') }}"></script></body>
</html>
