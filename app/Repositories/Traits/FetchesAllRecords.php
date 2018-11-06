<?php
namespace Penguin\Dlapi\Repositories\Traits;

use Penguin\Dlapi\Http\State;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

trait FetchesAllRecords
{
    /**
     * Apply state filters and return all remaining records.
     *
     * @param State $state
     * @return array
     */
    public function all(State $state) : array
    {
        $builder = $this->model->query();

        if($state->state !== '*') {
            $builder->where('state', $state->state);
        }

        $builder = $this->applyFilters($builder, $state->filter);

        $builder->orderBy($state->sort, $state->direction)
                ->skip($state->offset)
                ->take($state->limit);

        if($state->fields) {
            return $builder->get(explode(',', $state->fields))->toArray();
        }

        return $builder->get()->toArray();
    }

    /**
     * Apply builder filters from URL.
     *
     * @param Builder $builder
     * @param string $filter
     * @return Builder
     */
    private function applyFilters(Builder $builder, string $filter) : Builder
    {
        if(!empty($filter) && $filters = explode(',', $filter)) {

            foreach ($filters as $filter) {
                $filter = explode('|', $filter);

                // Defensively bail out if this column doest exist
                // to stop user's encountering a 1054 error
                if(!Schema::hasColumn($builder->getModel()->getTable(), $filter[0])) {
                    continue;
                }

                $builder->where($filter[0], $filter[1]);
            }
        }

        return $builder;
    }
}