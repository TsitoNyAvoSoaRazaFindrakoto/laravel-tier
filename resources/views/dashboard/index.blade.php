@extends('template')

@section('title','Evolution des Cryptos - Crypta')

@section('links')
    <!-- Ajouter le CDN de Google Charts -->
    <style>
        .card-body {
            background-color: #1f1f1f; /* Fond sombre pour améliorer la visibilité du graphique */
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
            transition: box-shadow 0.3s ease; /* Animation de l'ombre */
        }

        .card-body:hover {
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.5); /* Ombre plus prononcée au survol */
        }

        h4.card-title {
            color: #fff;
            font-weight: bold;
            font-size: 28px;
            transition: color 0.3s ease;
        }

        h4.card-title:hover {
            color: #ff9800; /* Changement de couleur au survol */
        }

        #curve_chart {
            height: 400px;
            width: 100%;
            border-radius: 10px; /* Bordures arrondies */
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-2">
            <!-- Espace vide pour la mise en page -->
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Evolution des Cryptos</h4>

                    <!-- Conteneur pour afficher le graphique -->
                    <div id="curve_chart"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Charger les packages nécessaires de Google Charts
        google.charts.load('current', {'packages':['corechart', 'line']});
        google.charts.setOnLoadCallback(drawCurveChart);

        var data;
        var chart;
        var time = 0; // Temps initial en secondes
        var cryptos = [
            'Bitcoin', 'Ethereum', 'Binance Coin', 'Ripple', 
            'Cardano', 'Solana', 'Polkadot', 'Dogecoin', 
            'Litecoin', 'Chainlink'
        ];

        // Fonction pour dessiner et redessiner le graphique
        function drawCurveChart() {
            data = new google.visualization.DataTable();
            data.addColumn('number', 'Temps');
            cryptos.forEach(crypto => {
                data.addColumn('number', crypto); // Ajouter une colonne pour chaque crypto
            });

            // Initialiser les prix aléatoires
            var initialRow = [time];
            cryptos.forEach(() => {
                initialRow.push(randomPrice()); // Ajouter un prix aléatoire
            });
            data.addRow(initialRow);

            var options = {
                hAxis: {
                    title: 'Temps (s)',
                    titleTextStyle: {color: '#fff'},
                    textStyle: {color: '#fff'},
                    gridlines: { count: 10 }
                },
                vAxis: {
                    title: 'Prix',
                    titleTextStyle: {color: '#fff'},
                    textStyle: {color: '#fff'}
                },
                backgroundColor: '#2c2c2c', // Fond sombre pour le graphique
                curveType: 'function', // Courbe pour l'évolution fluide
                legend: { 
                    position: 'bottom', 
                    textStyle: {color: '#fff'},
                    alignment: 'center',
                    maxLines: 1
                },
                animation: {
                    startup: true,
                    duration: 2000, // Durée de l'animation plus longue
                    easing: 'inAndOut'  // Transition fluide de l'animation
                },
                pointSize: 6, // Taille des points augmentée pour une meilleure visibilité
                lineWidth: 4, // Épaisseur de la ligne
                chartArea: {
                    left: 40,
                    top: 20,
                    bottom: 40,
                    right: 40
                }
            };

            // Créer le graphique
            chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);

            // Appeler la fonction pour mettre à jour les données toutes les 10 secondes
            setInterval(updateData, 10000);
        }

        // Fonction pour générer un prix aléatoire entre 50 et 50000
        function randomPrice() {
            return Math.floor(Math.random() * (50000 - 50 + 1)) + 50; // Prix entre 50 et 50000
        }

        // Fonction pour simuler l'évolution des prix de chaque crypto
        function updateData() {
            time += 10; // Incrémenter le temps de 10 secondes

            var newRow = [time];
            cryptos.forEach(() => {
                var newPrice = randomPrice(); // Générer un prix aléatoire pour chaque crypto
                newRow.push(newPrice); // Ajouter le nouveau prix
            });

            // Ajouter la nouvelle ligne de données (temps et prix des cryptos)
            data.addRow(newRow);

            // Redessiner le graphique avec les nouvelles données
            chart.draw(data, {animation: {startup: true, duration: 1500, easing: 'inAndOut'}});
        }
    </script>
@endsection
