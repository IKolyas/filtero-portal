<?php

namespace app\requests;

use app\base\Request;

class ActivitiesRequest extends Request
{

    protected array $filter = [];

    public function validate()
    {
        // TODO
    }

    public function errors(): array
    {
        // TODO
    }

    public function filter(): array
    {

        $request = $this->getParams();

        $params = explode('&', $request);

        foreach ($params as $param) {
            $parseParam = explode('=', $param);
            $this->filter[$parseParam[0]] = $parseParam[1];
        }

        return $this->filter;
    }

}