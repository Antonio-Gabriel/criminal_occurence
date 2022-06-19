<?php

namespace CriminalOccurence\modules\generic\controllers\contract;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface IHandle
{
    public function handle(Request $request, Response $response);
}
