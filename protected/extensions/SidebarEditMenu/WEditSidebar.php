<?php

class WEditSidebar extends CWidget
{
    public $ideas = array();
  
    public function init()
    {

			if ($this->ideas == array()){
				$sqlbuilder = new SqlBuilder;
				$filter['user_id'] = Yii::app()->user->id;
			   $user = $sqlbuilder->load_array("user", $filter);

				$this->ideas = $user['idea'];
        Yii::log(arrayLog($this->ideas), CLogger::LEVEL_INFO, 'WEdistSidebar.info.idea');

			}
			
      $this->render("start",array("ideas"=>$this->ideas));
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
}
