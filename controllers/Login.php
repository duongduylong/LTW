<?php

class Login extends Controller
{
    public function index($id = '', $slug = '')
    {
        $this->view('login');
    }
}
?>