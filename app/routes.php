<?php
use Butler\Model\Post;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'Butler\Controller\HomeController@home');



/*
Route::get('revision', function() {

    Auth::loginUsingId(5);

    //DB::table('posts')->delete();

    //$post = new Post;
    $post = Post::whereTitle('hi')->first();
    $post->title = "Dean is the catman!";
    $post->save();
    $post->title = "RAWR";
    $post->save();
});
*/
