<?php

use Sitemaped\Sitemap;

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        ['pattern' => 'vkAuth', 'route' => 'site/vk'],
        ['pattern' => 'policy', 'route' => 'site/policy'],
        ['pattern' => 'fbAuth', 'route' => 'site/fb'],
        ['pattern' => 'about', 'route' => 'site/about'],
        ['pattern' => 'search', 'route' => 'site/search'],

        ['pattern' => 'events', 'route' => 'events/index'],
        ['pattern' => 'news', 'route' => 'news/index'],
        ['pattern' => 'discounts', 'route' => 'discounts/index'],
        ['pattern' => 'vacancies', 'route' => 'vacancies/index'],

        ['pattern' => 'profile', 'route' => 'user/default/index'],
        ['pattern' => 'profile/export', 'route' => 'user/default/export'],
        ['pattern' => 'profile/disapprove', 'route' => 'user/default/disapprove'],

        ['pattern' => 'logout', 'route' => 'site/logout'],

        ['pattern' => 'profile/news', 'route' => 'user/default/news'],
        ['pattern' => 'profile/news/create', 'route' => 'user/default/news-create'],
        ['pattern' => 'profile/news/edit', 'route' => 'user/default/news-edit'],
        ['pattern' => 'profile/news/delete', 'route' => 'user/default/news-delete'],


        ['pattern' => 'profile/discounts', 'route' => 'user/default/discounts'],
        ['pattern' => 'profile/discounts/create', 'route' => 'user/default/discounts-create'],
        ['pattern' => 'profile/discounts/edit', 'route' => 'user/default/discounts-edit'],
        ['pattern' => 'profile/discounts/delete', 'route' => 'user/default/discounts-delete'],


        ['pattern' => 'profile/events', 'route' => 'user/default/events'],
        ['pattern' => 'profile/events/create', 'route' => 'user/default/events-create'],
        ['pattern' => 'profile/events/edit', 'route' => 'user/default/events-edit'],
        ['pattern' => 'profile/events/delete', 'route' => 'user/default/events-delete'],

        ['pattern' => 'profile/vacancies', 'route' => 'user/default/vacancies'],
        ['pattern' => 'profile/vacancies/create', 'route' => 'user/default/vacancies-create'],
        ['pattern' => 'profile/vacancies/edit', 'route' => 'user/default/vacancies-edit'],
        ['pattern' => 'profile/vacancies/delete', 'route' => 'user/default/vacancies-delete'],

        ['pattern' => 'restore/<token>', 'route' => 'site/set-new-pass'],
        ['pattern' => 'approve/<token>', 'route' => 'site/approve-email'],
        ['pattern' => 'api/user/edit', 'route' => 'api/user-edit'],
        ['pattern' => 'api/events/join', 'route' => 'api/events-add'],
        ['pattern' => 'api/vacancies/join', 'route' => 'api/vacancies-add'],

        ['pattern' => 'api/events/<id>', 'route' => 'api/event-one'],
        ['pattern' => 'api/discounts/<id>', 'route' => 'api/discounts-one'],
        ['pattern' => 'api/vacancies/<id>', 'route' => 'api/vacancies-one'],
        ['pattern' => 'api/news/<id>', 'route' => 'api/news-one'],
        ['pattern'=>'image/<path:(.*)>', 'route'=>'image/index', 'encodeParams' => false],
        ['pattern' => '<company>', 'route' => 'site/company'],
        ['pattern' => '<company>/events/<id>', 'route' => 'events/page'],
        ['pattern' => '<company>/discounts/<id>', 'route' => 'discounts/page'],
        ['pattern' => '<company>/vacancies/<id>', 'route' => 'vacancies/page'],
        ['pattern' => '<company>/news/<id>', 'route' => 'news/page'],

        // Sitemap
        ['pattern' => 'sitemap.xml', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_XML]],
        ['pattern' => 'sitemap.txt', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_TXT]],
        ['pattern' => 'sitemap.xml.gz', 'route' => 'site/sitemap', 'defaults' => ['format' => Sitemap::FORMAT_XML, 'gzip' => true]],
    ]
];
