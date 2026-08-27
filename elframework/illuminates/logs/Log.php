<?php
    namespace illuminates\logs;


    class Log extends \Exception{

        public function __construct($message, $code = 0, \Exception $previous = null, $logFile = 'logs/logs.php'){
            parent::__construct($message, $code, $previous);
            $this->displayError();
        }

        public function logError(){
            $logContent = date('y-m-d  H:i:s')." error: ".$this->getMessage()." in ".$this->getFile()." at line : ".$this->getLine();
            file_put_contents(storage_path($this->logFile), $logContent, FILE_APPEND);
        }

        public function displayError(){
            $message = $this->getMessage();
            $line    = $this->getLine();
            $file    = $this->getFile();
            $trace   = $this->getTraceAsString();
            include base_path('app/Views/errors/exception.tpl.php');  
        }
    }