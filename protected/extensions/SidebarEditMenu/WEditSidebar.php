<?php

class WEditSidebar extends CWidget
{
    public $data = array();
  
    public function init()
    {
      $ideaArray = array(
        array("id"=>1,"title"=>"Prva ideja s super naslovom","viewCount"=>13),
        array("id"=>1,"title"=>"Moja super ideja 2","viewCount"=>150),
      );
      
      $this->render("start",array("ideas"=>$this->data['user']['idea']));
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
}