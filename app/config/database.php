<?php

return new \Phalcon\Config([
    'database' => [
        'db' => [
            'adapter' => getenv('DB_ADAPTER'),
            'host' => getenv('DB_HOST'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'dbname' => getenv('DB_DBNAME'),
            'charset' => getenv('DB_CHARSET'),
            'persistent' => getenv('DB_PERSISTENT'),
            'schema' => getenv('DB_SCHEMA'),
        ],
        'rmDb' => [
            'adapter' => getenv('RM_DB_ADAPTER'),
            'host' => getenv('RM_DB_HOST'),
            'username' => getenv('RM_DB_USER'),
            'password' => getenv('RM_DB_PASS'),
            'dbname' => getenv('RM_DB_DBNAME'),
            'charset' => getenv('RM_DB_CHARSET'),
            'persistent' => getenv('RM_DB_PERSISTENT'),
            'schema' => getenv('RM_DB_SCHEMA'),
        ],
        'protheusDb' => [
            'adapter' => getenv('PROTHEUS_DB_ADAPTER'),
            'host' => getenv('PROTHEUS_DB_HOST'),
            'username' => getenv('PROTHEUS_DB_USER'),
            'password' => getenv('PROTHEUS_DB_PASS'),
            'dbname' => getenv('PROTHEUS_DB_DBNAME'),
            'charset' => getenv('PROTHEUS_DB_CHARSET'),
            'persistent' => getenv('PROTHEUS_DB_PERSISTENT'),
            'schema' => getenv('PROTHEUS_DB_SCHEMA'),
        ],
        'cnabDb' => [
            'adapter' => getenv('CNAB_DB_ADAPTER'),
            'host' => getenv('CNAB_DB_HOST'),
            'username' => getenv('CNAB_DB_USER'),
            'password' => getenv('CNAB_DB_PASS'),
            'dbname' => getenv('CNAB_DB_DBNAME'),
            'charset' => getenv('CNAB_DB_CHARSET'),
            'persistent' => getenv('CNAB_DB_PERSISTENT'),
            'schema' => getenv('CNAB_DB_SCHEMA'),
        ],
        'otrsDb' => [
            'adapter' => getenv('OTRS_DB_ADAPTER'),
            'host' => getenv('OTRS_DB_HOST'),
            'username' => getenv('OTRS_DB_USER'),
            'password' => getenv('OTRS_DB_PASS'),
            'dbname' => getenv('OTRS_DB_DBNAME'),
            'charset' => getenv('OTRS_DB_CHARSET'),
            'persistent' => getenv('OTRS_DB_PERSISTENT'),
            'schema' => getenv('OTRS_DB_SCHEMA'),
        ],
        'telefoniaDb' => [
            'adapter' => getenv('TELEFONIA_DB_ADAPTER'),
            'host' => getenv('TELEFONIA_DB_HOST'),
            'username' => getenv('TELEFONIA_DB_USER'),
            'password' => getenv('TELEFONIA_DB_PASS'),
            'dbname' => getenv('TELEFONIA_DB_DBNAME'),
            'charset' => getenv('TELEFONIA_DB_CHARSET'),
            'persistent' => getenv('TELEFONIA_DB_PERSISTENT'),
            'schema' => getenv('TELEFONIA_DB_SCHEMA'),
        ],
        'helpersDb' => [
            'adapter' => getenv('HELPERS_DB_ADAPTER'),
            'host' => getenv('HELPERS_DB_HOST'),
            'username' => getenv('HELPERS_DB_USER'),
            'password' => getenv('HELPERS_DB_PASS'),
            'dbname' => getenv('HELPERS_DB_DBNAME'),
            'charset' => getenv('HELPERS_DB_CHARSET'),
            'persistent' => getenv('HELPERS_DB_PERSISTENT'),
            'schema' => getenv('HELPERS_DB_SCHEMA'),
        ],
    ]
          ]
);
