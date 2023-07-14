<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://www.agility.com.br/assets/faviconpj.png" type="image/png">

    <title>Agility Imóveis | Server Status</title>
    <style>
        body {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            background-color: #E6EDF9;

            display: grid;
            place-items: center;
            height: 100vh;

            text-align: center;
        }

        .logo-agility {
            margin-right: 1rem
        }

        .logo-labs {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>

<body>
    <main>
        <div>
            <img class="logo-agility" src="https://www.agility.com.br/assets/images/logo-pj.svg" alt="Logo da Agility">
            <img class="logo-labs" src="https://avatars.githubusercontent.com/u/79149051?s=200&v=4"
                alt="Logo da Agility Labs">
        </div>
        <h1>Server On</h1>
    </main>
</body>

</html>
