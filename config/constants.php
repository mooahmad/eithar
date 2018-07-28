<?php

return [
    "requestTypes" => [
        "web" => "WEB",
        "api" => "API"
    ],
    "responseStatus" => [
        "success" => 0,
        "operationFailed" => 1,
        "missingInput" => 2,
        "errorUploadImage" => 3,
        "userNotFound" => 4,
    ],
    "customerMemberRelations" => [
        1 => "father",
        2 => "mother",
        3 => "brother",
        4 => "sister",
        5 => "son",
        6 => "daughter"
    ]
];