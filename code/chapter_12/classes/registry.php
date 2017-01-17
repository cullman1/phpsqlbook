<?php
class Registry {
    private $store = array();
    private static $instance = null;
    private function __construct() {}

    public static function instance() {
        if(self::$instance === null) {
            self::$instance = new Registry();
        }
        return self::$instance;
    }

    public function set($key, $value) {
        $this->store[$key] = $value;
    }
    
    public function get($key) {
        if (isset($this->store[$key])) {
            return $this->store[$key];
        }
    }
}
?>