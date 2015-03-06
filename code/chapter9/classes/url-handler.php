<?php
class UrlHandler {
    private $array_parts;
    private $query_parts;
    public function __construct() {
        
    }
    
    public function getUrl() {  
        $this->array_parts = explode("/",$_SERVER['REQUEST_URI']);     
        return $this->array_parts;
    }
    
    public function getQueryString() {  
        $querystring_array = array();
        $url_parts = explode("?",$_SERVER['REQUEST_URI']);
        if (strlen($query_parts)>1)
        {
            $querystring = $url_parts[1];
            $querystring_parts = explode("&", $querystring);
            for ($i=0;$i<strlen($querystring_parts);$i++)
            {
                if (($i % 2)==0)
                {
                    $querystring_array[$querystring_parts[$i]] = $querystring_parts[$i+i];
                }
            }
        }
        $this->query_parts = $querystring_array;
        return $this->query_parts;
    }
    
    public function getId($querystring_array) { 
        
    }
}
?>