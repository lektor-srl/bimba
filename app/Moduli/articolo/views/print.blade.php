<html lang="it">
    <head>
        <title>Stampa documento</title>
        <link rel="stylesheet" href="/assets/css/print-article.css">
    </head>

    <body onload="window.print()">
    <header>
        <p><img src="https://www.lektorweb.eu/wp-content/uploads/2020/06/lektor-bianco.png" alt="logo Lektor"></p>
    </header>

    <article style="font-size: 0.9em">
        <section class="article-header">
            <section class="titolo"><h1>{{ $page_data['titolo'] }}</h1></section>
            <section class="autore"></section>
        </section>

        <section class="article-content">
            <?= $page_data['contenuto'] ?>
        </section>
    </article>

    <footer></footer>
    </body>
<script>
    setTimeout(function(){
        window.close();
    },500)
</script>
</html>
