<?php namespace Butler\Observer;

class RevisionObserver {

    public function updating($revisionable)
    {
        if (\Auth::check()) {
            if (count($revisionable->getDirty()) > 0)
            {
                $revision                    = new \Butler\Model\Revision;
                $revision->user_id           = \Auth::user()->id;
                $revision->revisionable_id   = $revisionable->id;
                $revision->revisionable_type = get_class($revisionable);
                $revision->diff              = json_encode($revisionable->getDirty());
                $revision->save();
            }

            // return true as we want to save the revisionable
            // regardless of whether it is revisionable
            return true;
        } else {
            // Only save if user is authenticated
            return false;
        }
    }

}
