<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tools4Devs - Developer Tools (API)</title>

        <link rel="icon" href="/img/logo-tools4devs.png" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Styles / Scripts -->
        <style>
            body {
                font-family: Figtree, sans-serif;
                background-color: rgb(33, 33, 33);
                color: #ffffff;
            }
            header {
                text-align: center;
                margin-bottom: 2rem;
            }

            header img {
                width: 150px;
            }
            .name-logo{
                margin-top: 0px;
                /* margin-left: -5px; */
            }

            header nav {
                margin-top: 1rem;
            }

            header nav a {
                margin: 0 10px;
                color: #ff6700;
                text-decoration: none;
                font-weight: 500;
            }

            header .flag-icon {
                width: 30px;
                height: 20px;
                object-fit: cover;
                margin-right: 5px;
                vertical-align: middle;
                border-radius: 2px;
            }
            .language-selector a {
                padding: 8px 4px 10px 5px;
                border: 1px solid transparent; /* Sem borda padrão */
                border-radius: 5px; /* Suaviza os cantos */
                transition: border-color 0.3s; /* Animação suave ao mudar */
            }
            .language-selector a.active-language {
                border-color: #ff6700; /* Destaque em laranja */
            }
            main {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
                max-width: 1200px;
                margin: 0 auto;
                padding: 1.5rem;
            }

            .card {
                background-color:  #181818;
                border-radius: 0.75rem;
                box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.5);
                padding: 1.5rem;
                transition: transform 0.3s;
                /* margin-left: -15px; */
                /* margin-right: 5px; */
            }

            .card:hover {
                transform: translateY(-5px);
            }

            .card h2 {
                color: #ff6700;
                margin-bottom: 1rem;
            }

            .card p {
                color: #d1d5db;
            }

            a {
                color: #ff6700;
                text-decoration: underline;
            }
            .btn-a { display: inline-block; padding: 10px 20px; border: 2px solid #ff6700; border-radius: 5px; color: #ff6700; text-decoration: none; font-weight: bold; text-align: center; transition: background-color 0.3s, color 0.3s;}
            .btn-a:hover {
                background-color: #ff660049;
                color: #ffffff !important;
            }
            footer {
                text-align: center;
                margin-top: 2rem;
                padding: 1rem;
                font-size: 0.875rem;
            }

            .custom-alert {
                border: 2px solid #ff6700; /* Borda laranja */
                border-radius: 8px;
                padding: 16px;
                color: #ffffff; /* Texto escuro */
                font-family: Arial, sans-serif;
                margin-bottom: 16px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .custom-alert h3 {
                font-size: 1rem;
                margin-bottom: 8px;
                color: #ff6700; /* Título laranja */
            }

            .custom-alert p {
                font-size: 0.9rem;
                margin-bottom: 8px;
                line-height: 1.5;
            }

            .custom-alert a {
                color: #007bff; /* Link azul */
                text-decoration: none;
                font-weight: bold;
            }

            .custom-alert a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <header>
            <div>
                <img src="/img/logo-tools4devs.png" alt="Tools4Devs Logo">
                <h1 class="name-logo">Tools4Devs</h1>

            </div>
            <nav class="language-selector">
                <a href="?lang=en" class="{{ app()->getLocale() === 'en' ? 'active-language' : '' }}">
                    <img class="flag-icon" src="https://cdn.jsdelivr.net/gh/hjnilsson/country-flags/svg/us.svg" alt="EN"> EN
                </a>
                <a href="?lang=es" class="{{ app()->getLocale() === 'es' ? 'active-language' : '' }}">
                    <img class="flag-icon" src="https://cdn.jsdelivr.net/gh/hjnilsson/country-flags/svg/es.svg" alt="ES"> ES
                </a>
                <a href="?lang=pt-BR" class="{{ app()->getLocale() === 'pt-BR' ? 'active-language' : '' }}">
                    <img class="flag-icon" src="https://cdn.jsdelivr.net/gh/hjnilsson/country-flags/svg/br.svg" alt="PT-BR"> PT-BR
                </a>
            </nav>
            <br />
            <p>{{ __('messages.introduction') }}</p>
        </header>

        <main>
            <div class="card">
                <h2>{{ __('messages.what_is') }}</h2>
                <p>{{ __('messages.description') }}</p>
            </div>

            <div class="card">
                <h2>{{ __('messages.features') }}</h2>
                <p>{{ __('messages.feature1') }}</p>
                <p>{{ __('messages.feature2') }}</p>
                <p>{{ __('messages.feature3') }}</p>
                <p>{{ __('messages.feature4') }}</p>
                <p>{{ __('messages.feature5') }}</p>
                <p>{{ __('messages.feature6') }}</p>

                            </div>

            <div class="card">
                <h2>{{ __('messages.get_started') }}</h2>
                <p>{{ __('messages.documentation_intro') }}</p>
                <a href="/api/documentation" target="_blank"  class="btn-a text-center"">
                    {{ __('messages.view_documentation') }}
                </a>
            </div>
        </main>

        <main>

            <div class="custom-alert">
                <h3>{{ __('messages.alert_title1') }}</h3>
                <p>{!! __('messages.alert_info1') !!}</p>

                <h3>{{ __('messages.alert_title2') }}</h3>
                <p>{!! __('messages.alert_info2') !!}</p>

                <h3>{{ __('messages.alert_title3') }}</h3>
                <p>{!! __('messages.alert_info3') !!}</p>

                <h3>{{ __('messages.alert_title4') }}</h3>
                <p>{!! __('messages.alert_info4') !!}</p>
                <p>{!! __('messages.alert_info5') !!}</p>
            </div>
        </main>

        <footer style="text-align: center; padding: 1rem; font-size: 0.875rem; color: #ffffff;">
            Tools4Devs v1.0 © 2024-<span id="currentYear"></span>
            <p>
                <a href="https://rodrigorchagas.com.br" target="_blank" style="color: #ff6700;">Rodrigo Chagas</a>
                <a href="https://github.com/vanhalen/tools-4-devs" target="_blank" style="margin-left: 5px; color: #ffffff;">
                    <i class="fab fa-github" style="font-size: 20px;"></i>
                </a>
            </p>
        </footer>

        <script>
            // Atualiza o ano atual dinamicamente
            document.getElementById("currentYear").textContent = new Date().getFullYear();
        </script>


    </body>
</html>
