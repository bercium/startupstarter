<?php

class VanityUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='person/view'){
            if (isset($params['vanityURL'])) return $params['vanityURL'];
        }else
        if ($route==='project/view'){
            if (isset($params['vanityURL'])) return $params['vanityURL'];
        }
        return false;  // this rule does not apply
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (preg_match('%^(\w+)%', $pathInfo, $matches)){
          
          // get vanity name for users
          $user = User::model()->findByAttributes(array('vanityURL'=>$matches[1],'status'=>1));
          if ($user){
            $_GET['id'] = $user->id;
            return "person/view";
          }
          
          // if user was not found or we specified language 
          if (preg_match('%(-(\w{2}))?$%', $pathInfo, $lang)) {
            if (count($lang) > 1){
              $lang = $lang[2];
              $matches[1] = str_replace("-".$lang, "", $matches[1]);
            }
          }
          $idea = Idea::model()->findByAttributes(array('vanityURL'=>$matches[1],'deleted'=>0));
          if ($idea){
            $_GET['id'] = $idea->id;
            if (isset($lang)) $_GET['lang'] = $lang;
            return "project/view";
          }
          
        }
        return false;  // this rule does not apply
    }
}