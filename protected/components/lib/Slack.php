<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Slack
{
  
    public static function message($message, $icon = "", $room = "activity") {
        $data = "payload=" . json_encode(array(
                "channel"       =>  "#".$room,
                "text"          =>  $message,
                "icon_emoji"    =>  $icon
            ));
	
	// You can get your webhook endpoint from your Slack settings
        $ch = curl_init("https://cofinder.slack.com/services/hooks/slackbot?token=UdtpiGlSqC5VcjSm2O0xotwV");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
	
	// Laravel-specific log writing method
        // Log::info("Sent to Slack: " . $message, array('context' => 'Notifications'));
        return $result;
    }
    
}