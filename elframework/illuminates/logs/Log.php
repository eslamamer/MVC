<?php
    namespace illuminates\logs;
    use Exception;


    class Log extends Exception{

        protected string $logFile;
        public function __construct(string $message, $code = 0 , Exception $previous = null , $logFile = 'logs/.logs'){
           
            parent::__construct($message, $code, $previous);
            
            $this->logFile = $logFile;
            $this->displayError();
            $this->logError();
            
        }

        public function logError(){
            if(!is_dir(storage_path(dirname($this->logFile)))){
                mkdir(storage_path(dirname($this->logFile)),0755, true);
                touch(dirname($this->logFile));
            }
            $logContent = date('y-m-d  H:i:s')." error: ".$this->getMessage()." in ".$this->getFile()." at line : ".$this->getLine();
            file_put_contents(storage_path($this->logFile), $logContent.PHP_EOL, FILE_APPEND);
            var_dump(storage_path($this->logFile));
        }

        public function displayError(){
            $message = $this->getMessage();
            $line    = $this->getLine();
            $file    = $this->getFile();
            $trace   = $this->getTraceAsString();
            include base_path('app/views/errors/exception.tpl.php');  
        }
    }