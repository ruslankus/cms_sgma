<?php

class MainController extends Controller
{
    /**
     * Entry
     */
    public function actionIndex()
    {
        $this->title = "SIGMA";
        $this->description = "Index Page";

        $this->renderText("Hello world");
    }
}