<?php

namespace App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class SendingSMSClass
{
    private $username;
    private $password;
    private $sender;
    private $client;
    private $sms_url;

    /**
     * SendingSMSClass constructor.
     */
    public function __construct()
    {
        $this->username = '966555822781';
        $this->password = 'Eithar@sms123';
        $this->sender   = 'Eithar';
        $this->client   = new Client();
        $this->sms_url  = 'https://www.hisms.ws/api.php';

    }

    /**
     * @param $message
     * @param $numbers
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function sendSMS($message,$numbers)
    {
        return (new SendingSMSClass())->fireSMS($message,$numbers);
    }

    /**
     * @param string $message
     * @param array $numbers
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function fireSMS(string $message,array $numbers)
    {
        if (!$message || empty($numbers)) return false;

        $message = str_limit($message,config('constants.MaxMessageSMS'));
        $numbers = implode(',',$numbers);

        $response = $this->client->request('GET',$this->sms_url,[
            'form_params'=>[
                'send_sms',
                'username'=>$this->username,
                'password'=>$this->password,
                'sender'=>$this->sender,
                'domainName'=>'Eithar',
                'numbers'=>$numbers,
                'message'=>$message,
//                'return'=>'json',
//                'Rmduplicated'=>0
            ]
        ])->getBody();

        $api_response = json_decode($response,true);
//        return $api_response;
        return ($api_response['Code'] == config('constants.SMSSentSuccessfully')) ? true : false;
    }
}