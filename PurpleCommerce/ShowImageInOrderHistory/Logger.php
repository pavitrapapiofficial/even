<?php

namespace PurpleCommerce\ShowImageInOrderHistory;

class Logger
{
    private static $defaultLogFile = 'orderhistoryitems.log';

    public function addLog($message)
    {
        $this->writeLog($message);
    }

    private function writeLog($message, $file = '')
    {
        $writer = new \Zend\Log\Writer\Stream($this->getLogFile($file));
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        if (is_array($message)) {
            $logger->info(print_r($message));
        } elseif (is_object($message)) {
            $logger->info($message->getData());
        } else {
            $logger->info($message);
        }
    }

    /**
     * @param $file
     * @return string
     */
    private function getLogFile($file)
    {
        if ($file == '') {
            $file = self::$defaultLogFile;
        }

        $logFileDir = BP . '/var/log/';

        if (!file_exists($logFileDir)) {
            mkdir($logFileDir, 0750, true);
        }

        return $logFileDir . $file;
    }
}