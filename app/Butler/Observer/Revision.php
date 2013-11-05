<?php namespace Butler\Observer;

use Butler\Model;
use Illuminate\Support\Facades\Auth;

class Revision {

    protected static $disabled = false;

    public function updating($revisionable)
    {

        if (Auth::check()) {
            if (static::$disabled) return true;

            if (count($revisionable->getDirty()) > 0) {
                $revision          = new Model\Revision;
                $revision->user_id = Auth::user()->id;
                $revision->record  = json_encode($revisionable->getOriginal());

                if ($revisionable->revisions()->save($revision)) {
                    return true;
                } else {
                    // Throw exception maybe?  But our revision didn't save. So don't save the object either.
                    return false;
                }
            }
        } else {
            // Only save if user is authenticated
            //
            // @TODO On post maintance or something similar, this will stop all posts being updated.
            // Not sure if we want to do that.  Requires discussion.
            // Perhaps null user_id would indicate system.

            return false;
        }
    }

    /**
     * Disable all Revisions.
     *
     * @return void
     */
    public static function disable()
    {
        static::$disabled = true;
    }

    /**
     * Enable the mass assignment restrictions.
     *
     * @return void
     */
    public static function enable()
    {
        static::$disabled = false;
    }

}
