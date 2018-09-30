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
    "gender" => [
        "none" => 0,
        "male" => 1,
        "female" => 2
    ],
    "gender_desc" => [
        0 => "None",
        1 => "Male",
        2 => "Female",
    ],
    "customerMemberRelations" => [
        "father" => 1,
        "mother" => 2,
        "son" => 3,
        "daughter" => 4,
        "wife" => 5,
        "husband" => 6,
        "grandfather" => 7,
        "grandmother" => 8,
        "grandson" => 9,
        "granddaughter" => 10,
    ],
    "MemberRelations_desc" => [
        1 => "Father",
        2 => "Mother",
        3 => "Son",
        4 => "Daughter",
        5 => "Wife",
        6 => "Husband",
        7 => "Grand Father",
        8 => "Grand Mother",
        9 => "Grand Son",
        10 => "Grand Daughter",
    ],
    "userTypes" => [
        "superAdmin" => 0,
        "serviceProvider" => 1,
        "customerService" => 2
    ],
    "roles" => [
        "customers" => 1,
        "medicalServices" => 2,
        "doctors" => 3,
        "meetings" => 4,
        "invoices" => 5,
        "trackMedicalTeam" => 6,
        "promoCode" => 7,
        "medicalReports" => 8,
        "survey" => 9,
        "reports" => 10,
        "services" => 11,
        "calender" => 12,
        "searchCustomer" => 13,
        "appointmentsPurchased" => 14,
        "familyMembers" => 15
    ],
    "userRoles" => [
        "superAdmin" => [
            "customers" => config('constants.roles.customers'),
            "medicalServices" => config('constants.roles.medicalServices'),
            "doctors" => config('constants.roles.doctors'),
            "meetings" => config('constants.roles.meetings'),
            "invoices" => config('constants.roles.invoices'),
            "trackMedicalTeam" => config('constants.roles.trackMedicalTeam'),
            "promoCode" => config('constants.roles.promoCode'),
            "medicalReports" => config('constants.roles.medicalReports'),
            "survey" => config('constants.roles.survey'),
            "reports" => config('constants.roles.reports'),
            "services" => config('constants.roles.services'),
        ],
        "serviceProvider" => [
            "trackMedicalTeam" => config('constants.roles.trackMedicalTeam'),
            "calender" => config('constants.roles.calender'),
            "searchCustomer" => config('constants.roles.searchCustomer'),
            "appointmentsPurchased" => config('constants.roles.appointmentsPurchased'),
        ],
        "customerService" => [
            "customers" => config('constants.roles.customers'),
            "familyMembers" => config('constants.roles.familyMembers'),
            "survey" => config('constants.roles.survey'),
            "trackMedicalTeam" => config('constants.roles.trackMedicalTeam'),
            "appointmentsPurchased" => config('constants.roles.appointmentsPurchased'),
        ]
    ],
    "languages" => [
        'en' => "english",
        'ar' => "arabic"
    ],
    "categories" => [
        "Doctor" => 1,
        "Lap" => 2,
        "Physiotherapy" => 3,
        "Nursing" => 4,
        "WomanAndChild" => 5
    ],
    "serviceTypes" => [
        1 => "One time visit with Calendar",
        2 => "Package",
        3 => "Items sold part of visit",
        4 => "Lab Service",
        5 => "Provider Service"
    ],
    "calendarSections" => [
        "all",
        "old",
        "inTime",
        "upcoming"
    ],
    "questionnaireTypes" => [
        "radio" => "Single",
        "checkbox" => "Multiple",
        "text" => "Text",
        "longText" => "LongText",
        "dateTime" => "DateTime",
        "rating" => "Rating"
    ],
    "questionnaireTypesIndexed" => [
        "radio" => 0,
        "checkbox" => 1,
        "text" => 2,
        "longText" => 3,
        "dateTime" => 4,
        "rating" => 5
    ],
    "ratingSymbols" => [
        "stars" => ["type" => 0, "name" => "Stars", "max_rating_level" => 5],
        "numeric" => ["type" => 1, "name" => "Numeric", "max_rating_level" => 10]
    ],
    "max_questionnaire_pages" => 20,
    "max_questionnaire_per_page" => 5,
    "promoCodeTypes" => [
        0 => "All services will be discounted",
        1 => "One time visit with Calendar",
        2 => "Package",
        3 => "Items sold part of visit",
        4 => "Lab Service",
        5 => "Provider Service"
    ],
    "vat_percentage" => 5,
    "transactions" => [
        "follow" => 1,
        "like" => 2,
        "rate" => 3,
        "review" => 4,
        "view" => 5
    ],
    "transactionsTypes" => [
        "service" => 1,
        "provider" => 2
    ],
    "bookingStatus" => [
        "inprogress" => 1,
        "confirmed" => 2,
        "canceled" => 3
    ],
    "pushTypes" => [
        "services" => 1,
        "doctors" => 2,
        "appointmentReminder" => 3,
        "appointmentConfirmed" => 4,
        "medicalReportAdded" => 5,
        "invoiceGenerated" => 6,
        "addItemToInvoice" => 7
    ],
    'invoice_code'=>'INV-00',
    'payment_methods'=>[
        1 =>'Cash',
        2 =>'Credit Card',
        3 =>'Debit Card',
        4 =>'Mada',
    ]
];