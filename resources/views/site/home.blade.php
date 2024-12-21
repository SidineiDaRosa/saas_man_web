@include('site.navigation_bar')

<body>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/video6.mp4') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <div class="carousel-item">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/fapolpa1.jpeg') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <div class="carousel-item">
                <video autoplay muted loop class="h-100">
                    <source src="{{ asset('img/apresentacao/fapolpa1.jpeg') }}" type="video/mp4" alt="...">
                </video>
            </div>
            <!--Div imagem fosca-->
            <div id="overlay"></div>
            <div class="carousel-caption">
                <h1>ManWEB</h1>
                Sistema para gestão de manutenção.
                <input type="button" value="saber mais...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!--inicio do rodapé da pagina-->
    <footer>
        <div>
            <style>
                footer {
                    text-align: center;
                    width: 100%;
                }

                .title-footer {
                    color: black;
                    margin: 10px;
                }
            </style>
            <a href="#" class="title-footer">HOME</a>|
            <a href="" class="title-footer">PRODUTOS</a>|
            <a href="#" class="title-footer">SOBRE NÓS</a>|
            <a href="#" class="title-footer">DOWNLOADS</a>
            <a href="#" class="title-footer">Webmail</a>
        </div>
    </footer>
</body>

</html>
<!--Cookies-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consentimento de Cookies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .cookie-banner p {
            margin: 0;
            font-size: 14px;
        }

        .cookie-banner a {
            color: #4CAF50;
            text-decoration: underline;
        }

        .cookie-banner .buttons {
            display: flex;
            gap: 10px;
        }

        .cookie-banner button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }

        .cookie-banner button.decline {
            background-color: #f44336;
        }

        .cookie-banner button:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

    <div class="cookie-banner" id="cookieBanner">
        <p>Este site utiliza cookies para melhorar sua experiência. Saiba mais em nossa <a href="#">Política de Cookies</a>.</p>
        <div class="buttons">
            <button id="acceptCookies">Aceitar</button>
            <button id="declineCookies" class="decline">Recusar</button>
        </div>
    </div>

    <script>
        // Aceitar cookies
        document.getElementById('acceptCookies').addEventListener('click', function() {
            localStorage.setItem('cookiesConsent', 'accepted');
            document.getElementById('cookieBanner').style.display = 'none';
            console.log('Cookies aceitos');
        });

        // Recusar cookies
        document.getElementById('declineCookies').addEventListener('click', function() {
            localStorage.setItem('cookiesConsent', 'declined');
            document.getElementById('cookieBanner').style.display = 'none';
            console.log('Cookies recusados');
        });

        // Verifica se o banner precisa ser exibido
        window.onload = function() {
            const consent = localStorage.getItem('cookiesConsent');
            if (consent === 'accepted' || consent === 'declined') {
                document.getElementById('cookieBanner').style.display = 'none';
            }
        };
    </script>

</body>

</html>