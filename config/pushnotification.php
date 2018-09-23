<?php

return [
  'gcm' => [
      'priority' => 'normal',
      'dry_run' => false,
      'apiKey' => env('FIREBASE_SERVER_KEY', 'AAAAAldQN2A:APA91bE_JM-ZP2LgFXflnT5oG1gINc6ZUdEpkywNUjhZ_sdc402aJFVUCqQWJwug2umLX0-mfTUILaG-BfXBJ150GcxPFICS0qhTxn7gUvWDvaZTDDcNFSOcKs6p-vSZtDrFHeNV5oS3'),
  ],
  'fcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => env('FIREBASE_SERVER_KEY', 'AAAAAldQN2A:APA91bE_JM-ZP2LgFXflnT5oG1gINc6ZUdEpkywNUjhZ_sdc402aJFVUCqQWJwug2umLX0-mfTUILaG-BfXBJ150GcxPFICS0qhTxn7gUvWDvaZTDDcNFSOcKs6p-vSZtDrFHeNV5oS3'),
  ],
  'apn' => [
      'certificate' => __DIR__ . '/iosCertificates/apns-dev-cert.pem',
      'passPhrase' => '1234', //Optional
      'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
      'dry_run' => true
  ]
];