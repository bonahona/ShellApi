<?php

class HomeController extends Controller
{
    public function Index()
    {
        $this->Title = "Index";
        $this->View();
    }
}