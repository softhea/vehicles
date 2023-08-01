<?php
declare(strict_types=1);

namespace App\Request;
use Exception;

class AbstractVehiclePropertyRequest
{
    public ?string $value;

    /**
     * @throws Exception
     */
    public function __construct(?string $request) 
    {
        $request = json_decode($request, true);

        if (!array_key_exists('value', (array)$request)) {
            throw new Exception('\'value\' parameter missing from Request!');
        }

        $this->value = null === $request['value'] ? null : (string)$request['value'];
    }
}
