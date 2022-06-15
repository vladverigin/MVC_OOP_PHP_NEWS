<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>News</title>

    <link rel="stylesheet" href="/static/styles/main.css">
    <link rel="stylesheet" href="/static/styles/news.css">
</head>
<body>
    <div class="newsSection">
        <div class="newsHeader">
            <?php echo $news['title'] ?>
        </div>
        <div class="newContent extra">
            <?php echo $news['content'] ?>
        </div>
        <div class="newsPagesSection">
            <div class="newsPagesHeader extra">
                <a href="news.php">Все новости >></a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
