<?php

namespace App\Libraries;

use App\Libraries\PaginationBuilder;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseBuilder {

    protected $statusCode,
        $message,
        $data,
        $pagination,
        $authorization,
        $defaultData;

    public function __construct($statusCode = 200, $message = 'Ok', $data = [], $authorization = '') {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
        $this->pagination = null;
        $this->authorization = $authorization;
        $this->defaultData = [];
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getData() {
        if (!$this->data) {
            $this->data = [];
        }
        return $this->data;
    }

    public function getPagination() {
        return $this->pagination;
    }

    public function getAuthorization() {
        return $this->authorization;
    }

    public function getDefaultData() {
        return $this->defaultData;
    }

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        if ($statusCode != 200) {
            $this->setMessage(__('Something went wrong'));
        }
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setPagination($pagination) {
        $this->pagination = $pagination;
        return $this;
    }

    public function setAuthorization($authorization) {
        $this->authorization = $authorization;
        return $this;
    }

    public function setDefaultData($default) {
        $this->defaultData = $default;
        return $this;
    }

    public function build() {

        if ($this->getData() instanceof LengthAwarePaginator) {
            $dataWithPagination = PaginationBuilder::build($this->getData());
            $this->setPagination($dataWithPagination['pagination']);
            $this->setData($dataWithPagination['data']);
        }
        else if ($this->getData() instanceof AppendablePaginator) {
            $records = $this->getData()->toFlatArray();
            $this->setPagination($records['pagination']);
            $this->setData($records['data']);
        }
        else if ($this->getPagination() ) {
            $this->setPagination(PaginationBuilder::manipulatePaginationData($this->getPagination()));
        }
        $data = $this->getData();
        if($this->getPagination()){

            $data = [
                'collection' => $this->getData(),
                'pagination' => $this->getPagination()
            ];
        }
        $response = response([
            'success' => $this->getStatusCode()==200,
            'message' => $this->getMessage(),
            'data' => $data,
            'errors' => new \stdClass(),
            'status' => $this->getStatusCode()
        ]);
        if (strlen($this->getAuthorization()) > 0) {
            $response->withHeaders([
                'Authorization' => $this->getAuthorization()
            ]);
        }
        return $response;
    }

    public function error($message = '', $statusCode = 422, $data=[]) {
        $this->setStatusCode($statusCode);
        if (strlen($message) > 0) {
            $this->setMessage($message);
        }
        $this->setData($data);
        return $this->build();
    }

    public function success($message, $data=[]) {
        return $this->setMessage($message)->setData($data)->build();
    }

}
