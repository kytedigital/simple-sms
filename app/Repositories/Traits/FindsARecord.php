<?php
namespace Penguin\Dlapi\Repositories\Traits;

trait FindsARecord
{
    /**
     * Retrieve a single item from the data set.
     *
     * @param $id
     * @return array
     */
    public function find($id) : array
    {
        $record =  $this->model::find($id);

        return is_null($record) ? [] : $record->toArray();
    }
}