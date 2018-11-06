<?php
namespace Penguin\Dlapi\Repositories\Traits;

trait FetchesNextRecordId
{
    /**
     * Retrieve a single item from the data set.
     *
     * @return array
     */
    public function getNextRecordId($id)
    {
        return $this->model->where('id', '>', $id)->min('id');
       // return \DB::table($this->model->getTable())->where('id', '>', $id)->orderBy('id','asc')->first()->id; // For performance testing

    }
}