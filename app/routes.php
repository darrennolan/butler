<?php
Illuminate\Foundation\AliasLoader::getInstance()->alias('ButlerFlow', 'Butler\Facades\Flow');

$subscriber = new Butler\Event\Post;
Event::subscribe($subscriber);
$subscriber = new Butler\Event\Paginate;
Event::subscribe($subscriber);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/', 'Butler\Controller\HomeController@home');

Route::get('/', function() {

    $homeDirective = ButlerFlow::homeDirective();

    var_dump($homeDirective->count());

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
