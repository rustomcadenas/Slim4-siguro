<?php

use Slim\App;

return function (App $app){ 
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware(true, true, true);
};
