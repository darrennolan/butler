<?php namespace Butler\Observer;

class ModelObserver {

    public function updating($model)
    {
        if (\Auth::check()) {
            if (count($model->getDirty()) > 0)
            {
                $revision             = new \Butler\Model\Revision;
                $revision->user_id    = \Auth::user()->id;
                $revision->model_id   = $model->id;
                $revision->model      = get_class($model);
                $revision->model_data = json_encode($model->getDirty());
                $revision->save();
            }

            // return true as we want to save the model
            // regardless of whether it is revisionable
            return true;
        } else {
            // Only save if user is authenticated
            return false;
        }
    }

}
