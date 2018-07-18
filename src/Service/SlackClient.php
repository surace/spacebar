<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 16/07/2018
 * Time: 23:31
 */

namespace App\Service;


use App\Helper\LoggerTrait;
use Nexy\Slack\Client;

class SlackClient
{
    use LoggerTrait;

    /**
     * @var Client
     */
    private $client;

    function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $from
     * @param string $slackMessage
     */
    function sendMessage(string $from, string $message): void
    {
        $this->logInfo('hellow from trait', [
            'message' => $message
        ]);

        $slackMessage = $this->client->createMessage()
            ->to('#spacebar')
            ->from($from)
            ->withIcon(':ghost:')
            ->setText($message)
        ;
        $this->client->sendMessage($slackMessage);
    }


}