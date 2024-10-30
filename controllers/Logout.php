<?php

class Logout extends Controller
{
    public function index($id = '', $slug = '')
    {
        $this->view('logout');
    }
}
?>