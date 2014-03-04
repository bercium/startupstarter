<?php
/**
 * JsTrans
 *
 * Use Yii translations in Javascript
 *
 */

/**
 * Publish translations in JSON and append to the page
 *
 * @param mixed $categories the categories that are exported (accepts array and string)
 * @param mixed $languages the languages that are exported (accepts array and string)
 * @param string $defaultLanguage the default language used in translations
 */
class JsTrans
{
    public function __construct($categories, $languages, $defaultLanguage = null)
    {
        // set default language
        if (!$defaultLanguage) $defaultLanguage = Yii::app()->language;

        // create arrays from params
        if (!is_array($categories)) $categories = array($categories);
        if (!is_array($languages)) $languages = array($languages);

        // publish assets folder
        $assets = dirname(__FILE__) . DIRECTORY_SEPARATOR.'assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);

        // create hash
        $hash = substr(md5(implode($categories) . ':' . implode($languages)), 0, 10);

        $dictionaryFile = "dictionary-{$hash}.js";

        // generate dictionary file if not exists or YII DEBUG is set
        if (!file_exists(Yii::app()->params['tempFolder'] .  $dictionaryFile) || YII_DEBUG) {
            // declare config (passed to JS)
            $config = array('language' => $defaultLanguage);

            // base folder for message translations
            $messagesFolder = rtrim(Yii::app()->messages->basePath, '\/');

            // loop message files and store translations in array
            $dictionary = array();
            foreach ($languages as $lang) {
                if (!isset($dictionary[$lang])) $dictionary[$lang] = array();

                foreach ($categories as $cat) {
                    $messagefile = $messagesFolder . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . $cat . '.php';
                    if (file_exists($messagefile)) $dictionary[$lang][$cat] = array_filter(require($messagefile));
                }
            }

            // save config/dictionary
            $data = 'Yii.translate.config=' . CJSON::encode($config) . ';' .
                    'Yii.translate.dictionary=' . CJSON::encode($dictionary);


            // save to dictionary file
            if(!file_put_contents(Yii::app()->params['tempFolder'] .  $dictionaryFile, $data))
               Yii::log('Error: Could not write dictionary file, check file permissions', 'trace', 'jstrans');
        }

        // publish library and dictionary
        if (file_exists(Yii::app()->params['tempFolder'] .  $dictionaryFile)) {
            Yii::app()->getClientScript()
                    ->registerScriptFile($baseUrl . '/JsTrans.min.js', CClientScript::POS_END)
                    ->registerScriptFile(Yii::app()->baseUrl.'/'.Yii::app()->params['tempFolder'] .  $dictionaryFile, CClientScript::POS_END);
        } else {
            Yii::log('Error: Could not publish dictionary file, check file permissions', 'trace', 'jstrans');
        }
    }
}
