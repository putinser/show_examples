<?php

namespace App\Http\Requests;

use ArrayAccess;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection as Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ApiCollection.
 */
class ApiCollection extends Collection
{
    /**
     * @param Arrayable|array|ArrayAccess|LengthAwarePaginator|Paginator $collection
     * @param string|null                                                $class
     * @param mixed                                                      ...$props
     */
    public function  __construct($collection, string $class = null, ...$props)
    {
        $newItems = [];
        foreach ($collection as $item) {
            if (empty($item)) {
                continue;
            }
            $newItems[] = new $class($item, ...$props);
        }
        parent::__construct($newItems);
    }
}
