<?php
namespace App\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

class State extends Facade
{
    /**
     * Records state.
     *
     * @var int
     */
//    public $state = 1;

    /**
     * Records limit.
     *
     * @var int
     */
    public $limit = 10;

    /**
     * Records offset.
     *
     * @var int
     */
    // public $offset = 0;

//    /**
//     * Records offset.
//     *
//     * @var int
//     */
//    public $page = 0;
// todo: https://shopify.dev/tutorials/make-paginated-requests-to-rest-admin-api

    /**
     * Filtering.
     *
     * @var null
     */
    public $filter = null;

    /**
     * Sort column.
     *
     * @var string
     */
    public $sort = 'id';

    /**
     * Ordering direction.
     *
     * @var string
     */
    public $direction = 'ASC';

    /**
     * Fields to be returned.
     *
     * @var null
     */
    public $fields = '*';

    /**
     * Search string query
     *
     * @var
     */
    public $query;

    /**
     * State constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->limit      = (int) $request->query('limit', 10);
//        $this->offset     = (int) $request->query('offset', 0);
//        $this->state      = $request->query('state', 1);
        $this->filter     = $request->query('filter', '');
        $this->sort       = $request->query('sort', '');
        $this->direction  = $request->query('direction', '');
        $this->fields     = $request->query('fields');
        $this->query      = $request->query('query');
//        $this->page       = $request->query('page');
    }

    /**
     * Render the state to a query string.
     *
     * @return string
     */
    public function __toString()
    {
        $state = (array) $this;

//        $state['page'] = floor($this->offset / $this->limit);
//        $state['page'] = $this->page;
        $state['order'] = $this->sort .' '. $this->direction;

        return http_build_query($state);
    }

    /**
     * Laravel facade accessor facilitation.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'state'; }
}
