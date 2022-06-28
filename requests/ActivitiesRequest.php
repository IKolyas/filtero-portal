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

        if (empty($params)) return [];

        foreach ($params as $param) {
            $parseParam = explode('=', $param);
            if($parseParam[1] !== 'null') $this->filter[$parseParam[0]] = $parseParam[1];
        }

        if(isset($this->filter['search']) && strlen($this->filter['search']) === 0) unset($this->filter['search']);

        return $this->filter;
    }

}