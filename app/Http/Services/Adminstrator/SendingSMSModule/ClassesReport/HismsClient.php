<?php
namespace App\Http\Services\Adminstrator\SendingSMSModule\ClassesReport;

use GuzzleHttp\Client;

class HismsClient
{


    private $client;
    private $headers;
    private $username ;
    private $password ;
    private $senderName;
    private $additionalParams;
    public $configs;
    private $sms;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = ['headers' => []];
        $this->additionalParams = [];
        $this->username   = config('hisms.Username');
        $this->password   = config('hisms.Password');
        $this->senderName = config('hisms.SenderName');
        $this->sms = 'http://www.hisms.ws/api.php';
    }

    /**
     * @param $message
     * @param $numbers
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public static function sendSMS($message,$numbers)
    {
        return (new HismsClient())->fireSMS($message,$numbers);
    }


    /**
     * @param string $message
     * @param string $to
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    private function fireSMS(string $message, array $to)
    {
        if (is_null($message) or !isset($message) or is_null($to) or !isset($to)) {
            throw new \Exception('MESSAGE And TO Number are Require');
        }
        $message = str_limit($message,config('constants.MaxMessageSMS'));
        // handle to variable
        if (is_array($to)) {
            $to = implode(',', $to);
        }

        $response= $this->client->request(
            'GET',
            $this->sms,
            [
                'query' => [
                    'send_sms' => '1',
                    'username' => $this->username,
                    'password' => $this->password,
                    'numbers' => $to,
                    'sender' => $this->senderName,
                    'message' => $message
                ]
            ]
        )->getBody();

        $api_response = mb_substr($response, 0, 1, "UTF-8");
//        return $api_response;
        return ($api_response == config('constants.SMSSentSuccessfully')) ? true : false;
    }
}
