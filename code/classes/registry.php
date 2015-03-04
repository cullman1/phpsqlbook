<?php
class Registry {
    private $store = array();

    public static function instance() {
        if(self::$instance === null) {
            self::$instance = new Registry();
        }
        
        return self::$instance;
    }
    
    private function __construct() {}


    public function set($key, $value) {

        $this->registry[$key] = $value;
    }
    
    public function get($key) {
        if (isset($this-> store [$key])) {
            return $this-> store[$key];

        }
        
    }
}

?>