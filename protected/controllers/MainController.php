<?php

class MainController extends Controller
{
    /**
     * Entry
     */
    public function actionIndex()
    {
    	$this->layout = "site";
        $this->title = "SIGMA";
        $this->description = "Index Page";

        $this->renderText("Hello world");
    }
}