<?php

//Route::get('/', 'Butler\Controller\HomeController@home');

/*
Route::get('/{page?}', function($pageNumber = 1) {
    Butler\Events\Paginate::setPage($pageNumber);
    return ButlerHTML::make();
});
*/

Route::group(array('prefix' => ButlerFlow::homeRoute()), function() {

    Route::get('test', function() {
        return 'test';
    });

    Route::get('/{page?}', array('as' => 'butler.home', function() {
        return ButlerHTML::make();
    }));

    Route::get('/category/{category_name?}', array('as' => 'butler.category', function() {
        return 'category views';
    }));

    Route::get('/tag/{tag_name?}', array('as' => 'butler.tag', function() {

    }));

    Route::get('/{param1?}/{param2?}/{param3?}', array('as' => 'butler.custom', function() {
        return Event::chain('butler.custom.route', func_get_args());
    }));

});



Route::get('//{page}.html', array('as' => 'products.list', 'uses' => ''));



/*
Route::get('revision', function() {

    Auth::loginUsingId(5);

    //DB::table('posts')->delete();

    //$post = new Post;
    $post = Butler\Model\Post::whereTitle('hi')->first();
    $post->title = "Dean is the catman!";
    $post->save();
    $post->title = "RAWR";
    $post->save();
});
*/
