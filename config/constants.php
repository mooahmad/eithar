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
    "gender_desc_en" => [
        0 => "None",
        1 => "Male",
        2 => "Female",
    ],
    "gender_desc_ar" => [
        0 => "لا شئ",
        1 => "ذكر",
        2 => "أنثي",
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
        "addItemToInvoice" => 7,
        "appointmentcanceled" => 8,
        "approveItemToInvoice" => 9,
        "assignProviderToMeeting" => 10,
        "payment" => 11,
        "cancelItemInvoice" => 12,
    ],
    "pushTypesDesc" => [
        1=>"Services",
        2=>"Doctors",
        3=>"Appointment Reminder",
        4=>"Appointment Confirmed",
        5=>"Medical Report Added",
        6=>"Invoice Generated",
        7=>"Add Item To Invoice",
        8=>"Appointment Canceled",
        9=> "Approve Item To Invoice",
        10 => "assign Provider To Meeting",
    ],
    'invoice_code' => 'INV-00',
    'payment_methods' => [
        1 => 'Cash',
        2 => 'Credit Card',
        3 => 'Debit Card',
        4 => 'Mada',
    ],
    'searchTypes' => [
        'category' => 1,
        'lapcategory' => 2,
        'subcategory' => 3,
        'subcategorydoctor' => 4,
        'provider' => 5,
        'serviceonevisit' => 6,
        'servicepackage' => 7,
        'servicelap' => 8,
    ],
    'provider' => [
        'service_doctor' => 0,
        'doctor' => 1,
        'active' => 1,
    ],
    'MaxMessageSMS'=>160,
    'SMSSentSuccessfully'=>3,
    'items'=>[
        'pending'=>1,
        'approved'=>2,
    ],
    'DefaultPassword'=>'secret',
    'MobileNumberStart'=>'966',
    'CustomerEitharID'=>'ETHR-0000',
    'invoice_paid'=>[
        'paid'=>1,
        'pending'=>0
    ],
    'customer_message_cloud' => 'AAAAAldQN2A:APA91bE_JM-ZP2LgFXflnT5oG1gINc6ZUdEpkywNUjhZ_sdc402aJFVUCqQWJwug2umLX0-mfTUILaG-BfXBJ150GcxPFICS0qhTxn7gUvWDvaZTDDcNFSOcKs6p-vSZtDrFHeNV5oS3',
    'provider_message_cloud' => 'AAAAyUDBn-A:APA91bE6U2AdfemfC-LjLNZ1DZpWXYlm0LLoSSdrLltePvh-1mWQ9VmD6xo7EHx_yQgPPR3K0SP6dauwTv6o_8zCVVHZV7J43qAx24vW-eiwI8GaEQEBzcBYc-N-8i37bZVM9CaBR_fm',
    'paggination_items_per_page' => 20,
    'monthNames_en' => ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ],
    'monthNames_ar' => ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو",
        "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"
    ],
    'dayNames_en' => ["Mon", "Tue", "Wed", "Thur", "Fri", "Sat","Sun"],
    'dayNames_ar' => ["الأثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت","الأحد"],
	'is_active'=>1,
];