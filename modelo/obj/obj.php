<?php
    class obj{
        private $data = array();
        public function __set($index, $val){
            $this->data[$index] = $val;
        }
        public function __get($index){
            if(array_key_exists($index, $this->data))
                return $this->data[$index];
            return null;
        }
        public function __isset($index){
            return isset($this->data[$index]);
        }
        public function __unset($index){
            unset($this->data[$index]);
        }
    }
?>