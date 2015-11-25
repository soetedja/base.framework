<?php
$loader = new Phalcon\Loader();
$loader->registerNamespaces(array(
    'Base\Controllers'                  => __DIR__ . '/../Controllers/',
    'Base\Controllers\Configurations'   => __DIR__ . '/../Controllers/Configurations/',
    'Base\Controllers\Dictionary'       => __DIR__ . '/../Controllers/Dictionary/',
    'Base\Controllers\Donation'         => __DIR__ . '/../Controllers/Donation/',
    'Base\Controllers\Resources'        => __DIR__ . '/../Controllers/Resources/',
    'Base\Controllers\Test'             => __DIR__ . '/../Controllers/Test/',
    'Base\Framework'                    => __DIR__ . '/../Framework/',
    'Base\Framework\Exceptions'         => __DIR__ . '/../Framework/Exceptions/',
    'Base\Framework\Library'            => __DIR__ . '/../Framework/Library/',
    'Base\Framework\Messages'           => __DIR__ . '/../Framework/Messages/',
    'Base\Framework\Responses'          => __DIR__ . '/../Framework/Responses/',
    'Base\Models'                       => __DIR__ . '/../Models/',
    'Base\Repositories'                 => __DIR__ . '/../Repositories/',
    'Base\Resources'                    => __DIR__ . '/../Resources/',
    'Base\Resources\Common'             => __DIR__ . '/../Resources/Common/',
    'Base\Resources\Configuration'      => __DIR__ . '/../Resources/Configuration/',
    'Base\Resources\Menu'               => __DIR__ . '/../Resources/Menu/',
    'Base\Resources\Dictionary'         => __DIR__ . '/../Resources/Dictionary/',
    'Base\Services'                     => __DIR__ . '/../Services/',
    'Base\Services\Interfaces'          => __DIR__ . '/../Services/Interfaces/',
))->register();
