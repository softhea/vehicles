<?php
declare(strict_types=1);

namespace App\Request;
use Exception;

class CreateVehiclePropertyRequest extends AbstractVehiclePropertyRequest
{
    public string $name;

    /**
     * @throws Exception
     */
    public function __construct(?string $request) 
    {
        parent::__construct($request);

        $request = json_decode($request, true);

        if (!isset($request['name'])) {
            throw new Exception('\'name\' parameter missing or empty!');
        }

        $this->name = (string)$request['name'];
    }
}
