<?php


namespace App\Libraries;


use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class AppendablePaginator extends ResourceCollection
{
    private $appends = [];

    public function toFlatArray()
    {
        $this->collection->each->append($this->appends);
        $paginated = $this->resource->toArray();
        $data = $paginated['data'];
        unset($paginated['data']);
        $pagination = $paginated;
        return ['data' => $data, 'pagination' => $pagination];
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {

        if($this->resource instanceof AbstractPaginator){
            return (new FlattenedPaginatedResourceResponse($this))->toResponse($request);
        }else{
            return parent::toResponse($request);
        }
    }

    /**
     * Append to the underlying models
     * @param  array|string|null  $key
     */
    public function modelAppend($key) {
        if (is_null($key)) {
            return $this;
        }

        if (is_array($key)) {
            $this->appends = array_merge($this->appends, $key);
        } else {
            $this->appends[] = $key;
        }

        return $this;
    }
}

