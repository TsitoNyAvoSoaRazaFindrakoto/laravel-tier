<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Crypto</title>
    <!-- Lien vers Bootstrap -->
    <link rel="stylesheet" href="{{ asset('bootstrap-5/css/bootstrap.min.css') }}">
    <style>
        /* Animation de fade-in pour le formulaire */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            font-family: 'Arial', sans-serif;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            animation: fadeIn 1s ease;
        }

        .card-body {
            padding: 2rem;
        }

        h3 {
            color: #ffcb00;
            font-weight: bold;
        }

        .form-label {
            font-weight: bold;
        }

        input {
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        input:focus {
            background-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.6);
        }

        button {
            background: linear-gradient(to right, #f0b90d, #f0b90d);
            border: none;
            border-radius: 10px;
            font-weight: bold;
            transition: transform 0.3s;
        }

        button:hover {
            background: linear-gradient(to left, #f0b90d, #f0b90d);
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.98);
        }

        .container {
            animation: fadeIn 2s ease;
        }
    </style>
</head>
<body class="bg-dark text-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card bg-gradient shadow-lg" style="max-width: 400px; width: 100%; animation: fadeIn 1s ease;">
        <div class="card-body" ng-app="inscriptionApp" ng-controller="inscriptionController">
            <h3 class="text-center mb-4">Inscription</h3>
            <form ng-submit="submitForm()">
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo</label>
                    <input ng-model="utilisateur.pseudo" type="text" class="form-control" id="pseudo" placeholder="Entrez votre pseudo" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input ng-model="utilisateur.email" type="email" class="form-control" id="email" placeholder="Entrez votre email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input ng-model="utilisateur.password" type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" required>
                </div>
                <button type="submit" class="btn btn-light w-100 mt-3">S'inscrire</button>
            </form>
        </div>
    </div>
</div>

<!-- Lien vers les scripts JS de Bootstrap -->
</body>
<script src="{{ asset('angular/angular.min.js') }}"></script>
<script src="{{ asset('angular/angular-route.js') }}"></script>
<script src="{{ asset('app-angular/inscription.js') }}"></script>
<script src="{{ asset('bootstrap-5/js/bootstrap.bundle.min.js') }}"></script>
</html>
