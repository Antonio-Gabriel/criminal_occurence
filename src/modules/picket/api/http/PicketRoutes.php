<?php

namespace CriminalOccurence\modules\picket\api\http;

use Slim\App;

trait PicketRoutes
{
    public static function routes(App $route)
    {
        $route->get("/picket", function () {
            echo "Welcome to picket route!";
        });
    }
}
