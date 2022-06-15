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
            Новости
        </div>
        <div class="newContent">
            <?php
                foreach ($news as $v){
                    echo '
                    <div class="newsBlock">
                        <div class="currentNewsHeader">
                            <div class="newsDate">
                                '.date("d.m.Y", strtotime($v['date'])).'
                            </div>
                            <div class="newsTitle">
                                <a href="view.php?id='.$v['id'].'">'.$v['title'].'</a>
                            </div>
                        </div>
                        <div class="newsContent">
                            '.$v['announce'].'
                        </div>
                    </div>
                    ';
                }

            ?>


        </div>
        <div class="newsPagesSection">
            <div class="newsPagesHeader">
                Страницы:
            </div>
            <div class="newsPages">
                <?php
                    for ($i=1;$i<$pagesAmount+1;$i++){
                        $activeClass = ($i==$currentPage)?"active":"";
                        echo "
                            <a href='news.php?page=$i' class='pageBlock $activeClass'>$i</a>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
