<?php
namespace Bellpi\ConnectHubUsers\Utilities;


class Helpers {	  
    static function httpPost($url, $data)
    {
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($curl);
      curl_close($curl);
      return $response;
    }

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