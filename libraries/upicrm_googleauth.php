<?php

require_once 'Google/Client.php';
require_once 'Google/Service/Gmail.php';

class GoogleAuth {
  
  protected $client;
  protected $scopes;
  protected $auth;

  function __construct() {
    $this->client_id = get_option('upicrm_google_client_id');
    $this->secret = get_option('upicrm_secret'); 
    $this->scopes = implode(' ', array(Google_Service_Gmail::GMAIL_READONLY));
  }

  public function auth($user, $password) {
    
    $this->client = new Google_Client();
    $this->client->setApplicationName('Login to UPICRM');
    $this->client->setClientId($this->client_id);
    $this->client->setClientSecret($this->secret);
    $this->client->setScopes($this->scopes);
    $this->client->setRedirectUri(get_admin_url());
    
    $auth = new Google_Oauth2Service($this->client);
     
  }
}
