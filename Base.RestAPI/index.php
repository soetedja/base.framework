<?php



/**
 * By default, namespaces are assumed to be the same as the path.
 * This function allows us to assign namespaces to alternative folders.
 * It also puts the classes into the PSR-0 autoLoader.
 */

include __DIR__ . '/AppStart/Loader.php';

/**
 * Start the services
 */
include __DIR__ . '/AppStart/Services.php';

$app->handle();