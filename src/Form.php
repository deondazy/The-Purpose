<?php 

namespace Core;

class Form
{
    private $session;
    private $flash;

    public function __construct(Session $session, Flash $flash)
    {
        $this->session = $session;
        $this->flash = $flash;
    }

    public function setData($data)
    {
        $this->session->set('form_data', $data);
    }

    public function getData()
    {
        $data = $this->session->get('form_data');
        $this->session->remove('form_data');
        return $data;
    }

    public function fill($name)
    {
        $value = $this->flash->get($name);
        if ($value) {
            return 'value="' . htmlspecialchars($value) . '"';
        }
        return '';
    }
}
