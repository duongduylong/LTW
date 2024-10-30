<?php

class Forgot extends Controller
{
    public function index($id = '', $slug = '')
    {
        $this->view('forgot');
    }
}


?>