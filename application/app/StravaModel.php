<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class StravaModel extends Model
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $client;
    private $strava_uri = 'https://www.strava.com/api/v3';

    public function __construct()
    {
        $this->client_id = env('CT_STRAVA_CLIENT_ID', ''); # Strava Client ID
        $this->client_secret = env('CT_STRAVA_SECRET_ID', ''); # Strava Secrect
        $this->redirect_uri = env('CT_STRAVA_REDIRECT_URI', ''); # Strava Redirect URi
        $this->client = new Client();
    }

    public function getToken($code)
    {
        $url = 'https://www.strava.com/oauth/token';
        $config = [
          'form_params' => [
              'client_id' => $this->client_id,
              'client_secret' => $this->client_secret,
              'code' => $code,
              'grant_type' => 'authorization_code'
          ]
        ];
        $res = $this->post($url, $config);
        return $res;
    }

    public function refreshToken($refreshToken)
    {
        $url = 'https://www.strava.com/oauth/token';
        $config = [
          'form_params' => [
              'client_id' => $this->client_id,
              'client_secret' => $this->client_secret,
              'refresh_token' => $refreshToken,
              'grant_type' => 'refresh_token'
          ]
        ];
        $res = $this->post($url, $config);
        return $res;
    }

    public function athlete($token)
    {
        $url = $this->strava_uri . '/athlete';
        $config = $this->bearer($token);
        $res = $this->get($url, $config);
        return $res;
    }

    public function gear($token, $gearID)
    {
        $url = $this->strava_uri . '/gear/' . $gearID;
        $config = $this->bearer($token);
        $res = $this->get($url, $config);
        return $res;
    }

    private function post($url, $config)
    {
        $res = $this->client->post( $url, $config );
        $result = json_decode($res->getBody()->getContents());
        return $result;
    }

    public function get($url, $config)
    {
        $res = $this->client->get( $url, $config );
        $result = json_decode($res->getBody()->getContents());
        return $result;
    }

    private function bearer($token)
    {
      $config = [
        'headers' => [
            'Authorization' => 'Bearer '.$token.''
        ],
      ];
      return $config;
    }
}
