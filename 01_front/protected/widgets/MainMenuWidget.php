<?php

class MainMenuWidget extends CWidget
{
    public $view;

    public function init()
    {

    }

    public function run()
    {
        return $this->render($this->view);
    }
}
