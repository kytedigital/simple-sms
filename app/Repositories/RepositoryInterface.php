<?php

namespace App\Repositories;

use App\Http\State;

interface RepositoryInterface
{
    /**
     * @param State $state
     */
    public function browse(State $state);

    /**
     * @param string $id
     */
    public function read(string $id);
}
