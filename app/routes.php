<?php

/*
|--------------------------------------------------------------------------
| アプリケーションルート
|--------------------------------------------------------------------------
|
| このファイルでアプリケーションの全ルートを定義します。
| 方法は簡単です。対応するURIをLaravelに指定してください。
| そしてそのURIに対応する実行コードをクロージャーで指定します。
|
*/

Route::group(['prefix' => 'admin', 'before' => 'admin'], function() {
    Route::controller('home','admin\home\IndexController');
    Route::controller('user/search','admin\user\SearchController');
    Route::controller('user/entry','admin\user\EntryController');
    Route::controller('auth','admin\auth\IndexController');
    Route::controller('setting/site','admin\setting\SiteController');
    Route::controller('setting/company','admin\setting\CompanyController');
    Route::controller('menu/category','admin\menu\CategoryController');
    Route::controller('menu/article/site', 'admin\menu\article\SiteController');
    Route::controller('menu/article', 'admin\menu\article\IndexController');
    Route::controller('contents/image', 'admin\contents\ImageController');
    Route::controller('contents/movie', 'admin\contents\MovieController');
    Route::controller('api/auth','admin\api\auth\IndexController');
    Route::controller('api/menu/article/site','admin\api\menu\article\site\IndexController');
    Route::controller('api/menu/article','admin\api\menu\article\IndexController');
    Route::controller('api/file','admin\api\file\IndexController');
});

Route::group(['prefix' => 'admin'], function() {
    Route::controller('/','admin\IndexController');
});


Route::controller('api/file','api\FileController');
Route::controller('api/category/list','api\category\ListController');
Route::controller('api/category','api\category\IndexController');


// Frontページ
Route::controller('/','\IndexController');