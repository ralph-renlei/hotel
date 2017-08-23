<?php
namespace WxHotel\Services;
class Power
{
    protected $client_id = NULL;
    protected $app_secert = NULL;
    protected $redirect_url = NULL;

    public function __construct($client_id,$app_secert,$redirect_url)
    {
        $this->client_id  = $client_id;
        $this->app_secert = $app_secert;
        $this->redirect_url = $redirect_url;
    }


}
