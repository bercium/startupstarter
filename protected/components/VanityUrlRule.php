<?php

class VanityUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
 
    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='person'){
          if (isset($params['id'])){
            $user = User::model()->findByPk($params['id']);
            // has vanity url or not
            if ($user && $user->vanityURL) return $user->vanityURL;
            else return "person/view/".$params['id'];
          }
        }else
        if ($route==='project'){
          if (isset($params['id'])){
            $idea = Idea::model()->findByPk($params['id']);
            $lang = '';
            // has vanity url or not
            if ($idea && $idea->vanityURL){
              // add language if needed
              if (isset($params['lang'])) $lang = '-'.$params['lang'];
              return $idea->vanityURL.$lang;
            }
            else{
              // add language if needed
              if (isset($params['lang'])) $lang = '?lang='.$params['lang'];
              return "project/view/".$params['id'].$lang;
            }
          }
        }
        return false;  // this rule does not apply
    }
 
    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (preg_match('%^(\w+)%', $pathInfo, $matches)){
          
          // get vanity name for users
          $user = User::model()->findByAttributes(array('vanityURL'=>$matches[1],'status'=>1));
          if ($user){
            Yii::log($user->id, CLogger::LEVEL_INFO, 'USERFOUND');
            $_GET['id'] = $user->id;
            return "person/view";
          }
          
          // if user was not found or we specified language 
          if (preg_match('%(-(\w{2}))?$%', $pathInfo, $lang)) {
            if (count($lang) > 1){
              $language = $lang[2];
              $matches[1] = str_replace("-".$language, "", $matches[1]);
            }
          }
          // redirect to the right url
          $idea = Idea::model()->findByAttributes(array('vanityURL'=>$matches[1],'deleted'=>0));
          if ($idea){
            Yii::log(" | ".$rawPathInfo." | ".  implode(",", $matches), CLogger::LEVEL_INFO, 'IDEA-FOUND');
            $_GET['id'] = $idea->id;
            $_GET['lang'] = '';
            if (isset($language)) $_GET['lang'] = $language;
            return "project/view";
          }
          
        }
        return false;  // this rule does not apply
    }
}