<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . env('MYSQL_HOST') .';port='. getenv('MYSQL_PORT') .';dbname=' . env('MYSQL_DATABASE'),
    'username' => env('MYSQL_USER'),
    'password' => env('MYSQL_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
