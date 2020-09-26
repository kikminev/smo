<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class CustomerController
{
    public function customers():JsonResponse
    {
        return new JsonResponse('ok');
    }
}
