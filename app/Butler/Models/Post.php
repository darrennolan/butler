<?php namespace Butler\Models;

use Butler\Models\PostSlug;

use Illuminate\Support\Facades\DB;
use Butler\Facades\Event;
use Butler\Facades\Flow as ButlerFlow;

class Post extends Base
{
    protected $table   = 'posts';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('Butler\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('Butler\Models\Comment');
    }

    public function postSlugs()
    {
        return $this->hasMany('Butler\Models\PostSlug');
    }

    public function currentSlug()
    {
        return $this->hasOne('Butler\Models\PostSlug')
            ->orderBy('created_at', 'DESC');
    }

    public function revisions()
    {
        return $this->morphMany('Butler\Models\Revision', 'revisionable');
    }

    public function category()
    {
        return $this->belongsToMany('Butler\Models\Category', 'category_post')->withTimestamps();
    }

    public function anchorUrl()
    {
        return date("Y/m/d", strtotime($this->post_at)) . '/' . $this->titleUrl();
    }

    public function theContent()
    {
        if (ButlerFlow::isPage()) {
            return $this->content;
        } else {
            if ($this->excerpt) {
                return $this->excerpt;
            } else {
                return $this->content;
            }
        }
    }

    public function hasMore()
    {
        if (ButlerFlow::isPage()) {
            return false;
        } else {
            if ($this->excerpt) {
                return true;
            }
        }
        return false;
    }

    public function theTitle()
    {
        return $this->title;
    }

    public function thePermalink()
    {
        return $this->currentSlug->url;
    }

    public function save(array $options = array())
    {
        if ( ! $this->exists ) {

            DB::transaction(function() use ($options) {
                $parent_save = parent::save($options);

                if ($parent_save) {

                    $post_slug       = new PostSlug;
                    $post_slug->post = $this;

                    $slug_saved = $this->postSlugs()->save($post_slug);

                    if ($slug_saved) {
                        return $parent_save;
                    } else {
                        return $slug_saved;
                    }

                } else {
                    return $parent_save;
                }

            });
        }

        return parent::save($options);
    }

    public function __get($key)
    {
        $key_value = parent::getAttribute($key);
        return Event::fireChain('butler.post.' . $key, $key_value);
    }

}
