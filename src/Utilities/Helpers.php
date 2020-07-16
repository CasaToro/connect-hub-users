<?php
namespace Bellpi\ConnectHubUsers\Utilities;
use Bellpi\ConnectHubUsers\Utilities\Helpers;


class Helpers {	
     private static $data_error_token=[
        "status"=>"ERROR",
        "statusCode"=>103,
        "message"=>"No se ha encotrado token",
        "data"=>""
    ]; 

    static function httpPostJsonWithOutToken($url, $data)
    {
      $curl = curl_init($url);
      $data_encode = json_encode($data);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data_encode);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
         "Content-Type:application/json"
      ));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($curl);
      curl_close($curl);
      return $response;
    }


    static function httpPostJson($url, $data)
    {
      if(!$data['access_token']){
        return json_encode(self::$data_error_token);
      }
      $curl = curl_init($url);
      $data_encode = json_encode($data);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data_encode);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
         "Content-Type:application/json",
         "Authorization:Bearer {$data['access_token']}"
      ));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($curl);
      curl_close($curl);
      return $response;
    }

    static function httpGetJson($url,$data)
    {  
      if(!$data['access_token']){
        return json_encode(self::$data_error_token);
      }
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type:application/json",
          "Authorization: {$data['token_type']} {$data['access_token']}"
      ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_exec($ch);
      curl_close($ch);
    
      return $response;
    }
}