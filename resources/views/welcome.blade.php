<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Gad.get</title>
</head>
<body>
    <header>
        <a href="" class="logo">Gad.get</a>

        <a href="{{ route('login') }}" class="button">Login</a>
    </header>

    <section class="home" id="home">
        <div class="home-text">
            <h1>A Laravel Website</h1>
            <h2>Gadgets <br> Most Precious Things</h2>
            <a href="{{ route('login') }}" class="button">Get 'em now!</a>

            <div class="home-img">
                <img src="img/phone1.png" alt="">
            </div>
        </div>
    </section>

    <footer>
        <p>Copyright © 2023 Gad.get corp. All Rights Reserved.</p>
    </footer>
</body>
</html>