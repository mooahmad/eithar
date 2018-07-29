<?php

return [
    "requestTypes"            => [
        "web" => "WEB",
        "api" => "API"
    ],
    "responseStatus"          => [
        "success"          => 0,
        "operationFailed"  => 1,
        "missingInput"     => 2,
        "errorUploadImage" => 3,
        "userNotFound"     => 4,
    ],
    "gender"                  => [
        "none"   => 0,
        "male"   => 1,
        "female" => 2
    ],
    "customerMemberRelations" => [
        "father"   => 0,
        "mother"   => 1,
        "brother"  => 2,
        "sister"   => 3,
        "son"      => 4,
        "daughter" => 5
    ],
    "userTypes"               => [
        "superAdmin"      => 0,
        "serviceProvider" => 1,
        "customerService" => 2
    ],
    "roles"                   => [
        "customers"             => 1,
        "medicalServices"       => 2,
        "doctors"               => 3,
        "meetings"              => 4,
        "invoices"              => 5,
        "trackMedicalTeam"      => 6,
        "promoCode"             => 7,
        "medicalReports"        => 8,
        "survey"                => 9,
        "reports"               => 10,
        "services"              => 11,
        "calender"              => 12,
        "searchCustomer"        => 13,
        "appointmentsPurchased" => 14,
        "familyMembers"         => 15
    ],
    "userRoles"               => [
        "superAdmin"      => [
            "customers"        => config('constants.roles.customers'),
            "medicalServices"  => config('constants.roles.medicalServices'),
            "doctors"          => config('constants.roles.doctors'),
            "meetings"         => config('constants.roles.meetings'),
            "invoices"         => config('constants.roles.invoices'),
            "trackMedicalTeam" => config('constants.roles.trackMedicalTeam'),
            "promoCode"        => config('constants.roles.promoCode'),
            "medicalReports"   => config('constants.roles.medicalReports'),
            "survey"           => config('constants.roles.survey'),
            "reports"          => config('constants.roles.reports'),
            "services"         => config('constants.roles.services'),
        ],
        "serviceProvider" => [
            "trackMedicalTeam"      => config('constants.roles.trackMedicalTeam'),
            "calender"              => config('constants.roles.calender'),
            "searchCustomer"        => config('constants.roles.searchCustomer'),
            "appointmentsPurchased" => config('constants.roles.appointmentsPurchased'),
        ],
        "customerService" => [
            "customers"             => config('constants.roles.customers'),
            "familyMembers"         => config('constants.roles.familyMembers'),
            "survey"                => config('constants.roles.survey'),
            "trackMedicalTeam"      => config('constants.roles.trackMedicalTeam'),
            "appointmentsPurchased" => config('constants.roles.appointmentsPurchased'),
        ]
    ]
];