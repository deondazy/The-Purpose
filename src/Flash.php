<?php 

namespace Core;

class Flash 
{
    private $session;
  
    public function __construct($session) 
    {
        $this->session = $session;
    }
  
    public function set($type, $message) 
    {
        $this->session->set($type, $message);
    }
  
    public function get($type) 
    {
        $message = $this->session->get($type);
        $this->session->remove($type);
        return $message;
    }

    public function has($type)
    {
        return $this->session->has($type);
    }
}