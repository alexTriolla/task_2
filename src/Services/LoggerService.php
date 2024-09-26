<?php

class LoggerService
{
    private $errorLogFile;
    private $infoLogFile;

    public function __construct($errorLogFile = '../Logs/error.log', $infoLogFile = '../Logs/info.log')
    {
        $this->errorLogFile = $errorLogFile;
        $this->infoLogFile = $infoLogFile;
        $this->createLogFileIfNotExists($this->errorLogFile);
        $this->createLogFileIfNotExists($this->infoLogFile);
    }

    public function logError($message)
    {
        $this->logMessage('ERROR', $message, $this->errorLogFile);
    }

    public function logInfo($message)
    {
        $this->logMessage('INFO', $message, $this->infoLogFile);
    }

    private function logMessage($level, $message, $logFile)
    {
        $formattedMessage = "[" . date("Y-m-d H:i:s") . "] $level: " . $message . "\n";
        if (is_writable($logFile)) {
            error_log($formattedMessage, 3, $logFile);
        } else {
            error_log("[$level] Unable to write to log file: " . $logFile, 0);
        }
    }

    private function createLogFileIfNotExists($logFile)
    {
        $logDir = dirname($logFile);

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        if (!file_exists($logFile)) {
            file_put_contents($logFile, "");
            chmod($logFile, 0666);
        }
    }
}
