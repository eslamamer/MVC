<?php
    namespace illuminates\sessions;

    class SessionHandler implements \SessionHandlerInterface, \SessionIdInterface {

        public function __construct(public string $savePath, public string $prefix) {}
       
        /**
         * @return string
         */
        public function create_sid(): string{
            return "hi".bin2hex(random_bytes(8));
        }
        /**
         * @param string $path
         * @param string $name
         * 
         * @return bool
         */
        public function open(string $path, string $name): bool{
            if(!is_dir($this->savePath)){
                mkdir($this->savePath, 755, true);
            }
            return true;
        }
        /**
         * @param string $id
         * 
         * @return string
         */
        public function read(string $id): string|false{
            $file = $this->savePath.'/'.$this->prefix.'_'.$id;
            return file_exists($file) ? file_get_contents($file) : "";
        }
        /**
         * @param string $id
         * @param string $data
         * 
         * @return bool
         */
        public function write(string $id, string $data): bool{
            $file = $this->savePath.'/'.$this->prefix.'_'.$id;
            return file_put_contents($file, $data);
        }
        /**
         * @param string $id
         * 
         * @return bool
         */
        public function destroy(string $id): bool{
            $file = $this->savePath.'/'.$this->prefix.'_'.$id;
            if(file_exists($file)){
                unlink($file);
            }
            return true;
        }
        /**
         * @param int $max_lifetime
         * 
         * @return int
         */
        public function gc(int $max_lifetime): int|false{
            foreach(glob($this->savePath.'/'.$this->prefix.'*') as $file){
                if(file_exists($file) && $max_lifetime + filemtime($file) < time()){
                    unlink($file);
                }
            }
            return true;
        }

         /**
          * @return bool
          */
         public function close(): bool{
            return true;
        }
    }