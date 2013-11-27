<?php

//Route::get('/', 'Butler\Controller\HomeController@home');

/*
Route::get('/{page?}', function($pageNumber = 1) {
    Butler\Events\Paginate::setPage($pageNumber);
    return ButlerHTML::make();
});
*/

Route::group(array('prefix' => ButlerFlow::homeRoute()), function() {

    Route::get('category/{category?}/{page?}', array('as' => 'butler.category', function($category = false, $page = false) {
        if ($category === false) {
            return 'category view';
        } else {
            if ($page == 1) {
                return Redirect::route('butler.category', $category);
            } else {
                ButlerEvent::listen('butler.thePosts', function($query) {});
                return 'posts in category ' . $category;
            }
        }
    }))->where('page', '[0-9]+');



    Route::get('tag/{tag?}/{page?}', array('as' => 'butler.tag', function() {
        if ($category === false) {
            return 'category view';
        } else {
            if ($page == 1) {
                return Redirect::route('butler.category', $category);
            } else {
                return 'posts in category ' . $category;
            }
        }
    }))->where('page', '[0-9]+');



    Route::get('/{page?}', array('as' => 'butler.home', function($page = false) {
        if ($page == 1) {

            return Redirect::route('butler.home');

        } elseif ($page === false) {

            ButlerFlow::isHomepage(true);

        }
        return ButlerHTML::make();
    }))->where('page', '[0-9]+');



});




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
