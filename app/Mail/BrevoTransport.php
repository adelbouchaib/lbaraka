<?php

namespace App\Mail;

use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;
use GuzzleHttp\Client;

class BrevoTransport extends Transport
{
    protected $client;
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->client = new Client(['base_uri' => 'https://api.brevo.com/v3/']);
        $this->apiKey = $apiKey;
    }

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $payload = [
            'sender' => [
                'name'  => optional($message->getSender())[0]->getName(),
                'email' => optional($message->getSender())[0]->getAddress(),
            ],
            'to' => collect($message->getTo())->map(function ($name, $email) {
                return ['email' => $email, 'name' => $name];
            })->values()->toArray(),
            'subject' => $message->getSubject(),
            'htmlContent' => $message->getBody(),
        ];

        $this->client->post('smtp/email', [
            'headers' => [
                'api-key' => $this->apiKey,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        return $this->numberOfRecipients($message);
    }
}
