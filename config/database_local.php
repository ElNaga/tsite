<?php
// Local Database Configuration
return [
    'host' => 'localhost',
    'database' => 'teatar_zatebe',
    'username' => 'root',
    'password' => '', // Add your MySQL password here if you have one
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];








