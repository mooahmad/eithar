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
        0 => "father",
        1 => "mother",
        2 => "brother",
        3 => "sister",
        4 => "son",
        5 => "daughter"
    ]
];