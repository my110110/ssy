<?php 
 //please do not modify this file, this file is built by app\modules\backend\models\baseConfig.php 
 return array (
  'appName' => 'sz',
  'homeTitle' => 'sz',
  'logo' => '@web/images/logo.png',
  'keywords' => 'sz',
  'description' => '',
  'cacheDuration' => '-1',
  'pageSize' => '10',
  'nav' => '{
    "options": {
        "class": "nav navbar-nav navbar-right"
    },
    "items": [
        {
            "label": "首页",
            "url": [
                "/site/index"
            ]
        },
        {
            "label": "成功案例",
            "url": [
                "/products/list"
            ],
            "activeUrls": [
                "/products/index"
            ]
        },
        {
            "label": "新闻公告",
            "url": [
                "/news/list"
            ],
            "activeUrls": [
                "/news/index"
            ]
        },
    
        {
            "label": "关于我们",
            "url": [
                "/page/1"
            ]
           
        },
        {
            "label": "联系我们",
            "url": [
                "/page/2"
            ]
        }
    ]
}',
);
