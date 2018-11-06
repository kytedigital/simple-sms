<?php
namespace Penguin\Dlapi\Repositories\Traits;

trait FetchesPreviousRecordId
{
    /**
     * Retrieve a single item from the data set.
     *
     * @return array
     */
    public function getPreviousRecordId($id)
    {
        return $this->model->where('id', '<', $id)->max('id');
       // return \DB::table($this->model->getTable())->where('id', '<', $id)->orderBy('id','desc')->first()->id; // For performance testing
    }
}