<?php

/**
 * Collections let us define groups of routes that will all use the same controller.
 * We can also set the handler to be lazy loaded.  Collections can share a common prefix.
 * @var $exampleCollection
 */

// This is an Immeidately Invoked Function in php.  The return value of the
// anonymous function will be returned to any file that "includes" it.
// e.g. $collection = include('example.php');
return call_user_func(function () {
    
    $collection = new \Phalcon\Mvc\Micro\Collection();
    
    $collection
    
    // VERSION NUMBER SHOULD BE FIRST URL PARAMETER, ALWAYS
    ->setPrefix('/api/translation')
    
    // Must be a string in order to support lazy loading
    ->setHandler('\Base\Controllers\Dictionary\TranslationController')->setLazy(true);
    
    // Set Access-Control-Allow headers.
    $collection->options('/', 'optionsBase');
    $collection->options('/{id}', 'optionsOne');
    
    // First paramter is the route, which with the collection prefix here would be GET /example/
    // Second paramter is the function name of the Controller.
    $collection->get('/', 'get');
    
    // This is exactly the same execution as GET, but the Response has no body.
    $collection->head('/', 'get');
    
    // $id will be passed as a parameter to the Controller's specified function
    $collection->get('/{id:[0-9]+}', 'getOne');
    $collection->head('/{id:[0-9]+}', 'getOne');
    $collection->post('/create', 'create');
    $collection->post('/search', 'search');
    $collection->post('/update', 'update');
    $collection->delete('/{id:[0-9]+}', 'delete');
    $collection->put('/{id:[0-9]+}', 'put');
    $collection->patch('/{id:[0-9]+}', 'patch');
    
    return $collection;
});
