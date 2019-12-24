<?php

return [
    "defaults" => [
        "guard"     => env("AUTH_GUARD", "api"),
        "passwords" => "users",
    ],

    "guards" => [
        "api" => [
            "driver"   => "jwt",
            "provider" => "users"
        ],
        "shopper_api" => [
            "driver"   => "jwt",
            "provider" => "shopper"
        ],
    ],

    "providers" => [
        "users" => [
            "driver" => "eloquent",
            "model"  => \App\Models\User::class,
        ],
        "shopper" => [
            "driver" => "eloquent",
            "model"  => \App\Models\Shopper::class,
        ],
    ],
];
