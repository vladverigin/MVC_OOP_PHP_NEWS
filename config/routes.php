<?php

/**
 * I use pattern where first word is name of controller and the second one is name of function/method in this controller, last one is params
 */
return [
    'customRoutes' => [
        'news' => 'News/show',
        'news?page' => 'News/showPage',
        'view?id' => 'News/getOne'
    ],
    'indexRoute' => 'Home/show',
    'notFoundRoute' => 'Home/notFound',
];
