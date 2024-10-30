<?php

class Home extends Controller
{

    public function index($id = '')
    {
        $modelNews = new ModelNews();
        $list = $modelNews->getAll();
        $this->view('home', $list);
    }
}

?>