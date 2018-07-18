<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 16/07/2018
 * Time: 23:53
 */

namespace App\Helper;


use Psr\Log\LoggerInterface;

trait LoggerTrait
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @required
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $message
     * @param array $context
     */
    function logInfo(string $message, array $context = [])
    {
        if($this->logger){
            $this->logger->info($message, $context);
        }
    }

}