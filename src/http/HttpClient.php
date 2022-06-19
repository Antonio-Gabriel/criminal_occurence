<?php

namespace CriminalOccurence\http;

use Slim\App;

use CriminalOccurence\configs\Views;

use CriminalOccurence\modules\picket\api\http\PicketRoutes;

use CriminalOccurence\modules\generic\controllers\{
    CreateAccountController,
    AuthenticationController,
    UpdateAccountController
};

use CriminalOccurence\middleware\security\Authorization;

trait HttpClient
{
    public static function getViewIstance()
    {
        return new Views("generic/views/");
    }

    public static function routes(App $route)
    {
        $route->get("/", function () {

            Authorization::isAuthorizated();

            self::getViewIstance()->render("index.html", [
                "status" => status()["status"] ?? 0,
                "msg" => status()["msg"]
            ]);

            unset($_SESSION["result"]);
        });

        $route->post("/auth", [new AuthenticationController, "handle"]);

        $route->get("/create-account", function () {

            Authorization::isAuthorizated();

            self::getViewIstance()->render("create-account.html", [
                "status" => status()["status"] ?? 0,
                "msg" => status()["msg"]
            ]);

            unset($_SESSION["result"]);
        });

        $route->get("/update-account", function () {

            Authorization::notAuthorizated();

            self::getViewIstance()->render("update-account.html", [
                "user" => $_SESSION['user'] ?? null,
                "status" => status()["status"] ?? 0,
                "msg" => status()["msg"]
            ]);

            unset($_SESSION["result"]);
        });

        $route->post("/create-account", [new CreateAccountController, "handle"]);
        $route->post("/update-account", [new UpdateAccountController, "handle"]);

        $route->get("/home", function () {

            Authorization::notAuthorizated();

            self::getViewIstance()->render("home.html", [
                "user" => $_SESSION['user'] ?? null
            ]);

            unset($_SESSION["result"]);
        });

        $route->get("/logout", function () {
            session_regenerate_id();
            unset($_SESSION['user']);
            redirect("");
        });

        self::externalRoutes($route);
    }

    public static function externalRoutes(App $route)
    {
        PicketRoutes::routes($route);
    }
}
