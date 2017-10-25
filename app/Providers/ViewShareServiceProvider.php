<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Support\ServiceProvider;

class ViewShareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      /*$totalPosts = Post::count();
      $postIds = [];
      $i = 1;
      while($i <=5)
      {
        $postIds[] = rand('1', $totalPosts);
        $i++;
      }
      $suggestions = Post::whereIn('id', $postIds)->get();

      view()->composer(['hrms.updates.*', 'home'], function ($view) use($suggestions){

        $view->with('suggestions', $suggestions);
      });*/
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
