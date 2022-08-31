<?php

namespace App\Services;

use Illuminate\Http\Client\Response;

class BaseService
{

    protected function returnAssocResponse(Response $response)
    {
        return json_decode($response, true);
    }

}
