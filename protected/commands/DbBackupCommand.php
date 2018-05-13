<?php

class DbBackupCommand extends CConsoleCommand{

  /**
   * making a DB backup
   */
	public function actionBackup(){
    Yii::import('ext.yii-database-dumper.SDatabaseDumper');
    $dumper = new SDatabaseDumper;
    // Get path to backup file
    $folder = Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.Yii::app()->params['dbbackup'];
    $file = 'dump_'.date('Y-m-d_H_i_s').'.sql';

    if (!is_dir($folder)) {
			mkdir($folder, 0777, true);
		}
    // Gzip dump
    if(function_exists('gzencode')) file_put_contents($folder.$file.'.gz', gzencode($dumper->getDump()));
    else file_put_contents($folder.$file, $dumper->getDump());
    return 0;
	}
  
  
  public function actionRemoveOld(){
    // remove old backups (older than a week)
    $files = glob(realpath(Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.Yii::app()->params['dbbackup']).DIRECTORY_SEPARATOR."dump_*");
    foreach($files as $file) {
        if(is_file($file)
           && (time() - filemtime($file) > 7*24*60*60)) { // 7 days
//           && (time() - filemtime($file) > 3*60)) { // 2 days
          unlink($file);
        }
    }
    return 0;
  }
  
  /**
   * restoring DB
   */
	public function actionRestore(){
    echo "Restore not implemented yet!";
    return 1;
	}
  
}
