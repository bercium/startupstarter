<?php

class WPagination extends CWidget
{
    public $page = 1;
    public $maxPage = 1;
    public $pageNumbers = true;
		public $url = '';
		public $getParams = array();
  
    public function init()
    {
			$this->render("view",array("url"=>$this->url,
                                 "page"=>$this->page,
                                 "maxPage"=>$this->maxPage,
                                 "pageNumbers"=>$this->pageNumbers,
                                 "getParams" =>$this->getParams));
    }
 
    public function run()
    {
        // this method is called by CController::endWidget()
    }
    
}
