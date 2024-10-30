<?php

class Schedules extends Controller
{
    public function index($id = '', $slug = '')
    {
        $this->view('schedule');
    }
}
?>