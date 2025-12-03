<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('images/mini-Crypta.png')}}">
    <title>Crypta - Investissez intelligemment</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5/css/bootstrap.min.css') }}">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Arial', sans-serif;
            scroll-behavior: smooth;
        }

        /* Navigation bar */
        .navbar {
            background-color: #657be9;
            color: #fff;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff !important;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .btn-signup {
            background-color: #fff;
            color: #4a4eb1;
            border-radius: 20px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-signup:hover {
            background-color: #4a4eb1;
            color: #fff;
            border: 1px solid #fff;
        }

        /* Hero section */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(135deg, #4a4eb1, #667eea);
            color: #fff;
            padding: 20px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn-start {
            background-color: #fff;
            color: #4a4eb1;
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-start:hover {
            background-color: #3b3e9e;
            color: #fff;
        }

        /* Popular Sites Section */
        .popular-sites {
            padding: 50px 20px;
            background-color: #f4f6fc;
            text-align: center;
        }

        .popular-sites h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .popular-sites .site {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .popular-sites img {
            width: 80px;
            height: auto;
            transition: transform 0.3s;
        }

        .popular-sites img:hover {
            transform: scale(1.1);
        }

        /* Features Section */
        .features {
            padding: 50px 20px;
            background-color: #fff;
            text-align: center;
        }

        .features h2 {
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .features .feature {
            margin-bottom: 20px;
        }

        .features .icon {
            font-size: 3rem;
            color: #4a4eb1;
            margin-bottom: 10px;
        }

        /* Footer */
        .footer {
            background-color: #4a4eb1;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .footer a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="{{asset('images/Crypta.png')}}" style="width: 10%"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/connection">Connection</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-signup" href="/inscription">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <h1>Investissez votre argent correctement</h1>
    <p>La cryptomonnaie simplifiée : investissez dans l'avenir, aujourd'hui.</p>
    <a href="/connection" class="btn btn-start">Commencer</a>
</section>

<!-- Features Section -->
<section class="features" id="features">
    <h2>Pourquoi choisir Crypta ?</h2>
    <div class="row justify-content-center">
        <div class="col-md-4 feature">
            <div class="icon">💼</div>
            <h4>Gestion Professionnelle</h4>
            <p>Une interface intuitive pour suivre vos investissements.</p>
        </div>
        <div class="col-md-4 feature">
            <div class="icon">🔒</div>
            <h4>Sécurité Totale</h4>
            <p>Nous garantissons la sécurité de vos données et fonds.</p>
        </div>
        <div class="col-md-4 feature">
            <div class="icon">📈</div>
            <h4>Rentabilité Maximale</h4>
            <p>Des outils analytiques pour optimiser vos profits.</p>
        </div>
    </div>
</section>

<section class="popular-sites" id="sites">
    <h2>Suivez-nous sur les réseaux sociaux</h2>
    <div class="site">
        <a href="https://www.facebook.com" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" width="50" height="50">
        </a>
        <a href="https://www.twitter.com" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="Twitter" width="50" height="50">
        </a>
        <a href="https://www.instagram.com" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram" width="50" height="50">
        </a>
    </div>
    <div class="site mt-3">
        <a href="https://www.linkedin.com" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733561.png" alt="LinkedIn" width="50" height="50">
        </a>
        <a href="https://www.youtube.com" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733646.png" alt="YouTube" width="50" height="50">
        </a>
        <a href="https://www.whatsapp.com" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="50" height="50">
        </a>
    </div>
</section>


<!-- Footer -->
<footer class="footer">
    <p>&copy; 2025 Crypta. Tous droits réservés. <a href="#">Politique de confidentialité</a></p>
</footer>

<script src="{{asset('bootstrap-5/js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
