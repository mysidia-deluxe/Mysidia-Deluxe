<?php

class LoginController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->access = "guest";
        $this->handleAccess();
        $mysidia = Registry::get("mysidia");

        if ($mysidia->input->post("submit")) {
            if (!$mysidia->input->post("username") or !$mysidia->input->post("password")) {
                throw new LoginException("fail_blank");
            } else {
                $validator = new UserValidator($mysidia->user, array("username" => $mysidia->input->post("username"), "password" => $mysidia->input->post("password")));
                $validator->validate("username");
                $validator->validate("password");
                
                if (!$validator->triggererror()) {
                    $mysidia->user->login($mysidia->input->post("username"));
                    if (isset($mybbenabled) && $mybbenabled == 1) {
                        $mysidia->user->loginforum();
                    }
                    $mysidia->session->terminate("clientip");
                } else {
                    throw new LoginException("fail_details");
                }
            }
            return;
        }
        $mysidia->session->assign("clientip", $_SERVER['REMOTE_ADDR']);
    }
    
    public function logout()
    {
        $this->access = "member";
        $this->handleAccess();
        $mysidia = Registry::get("mysidia");
        $mysidia->user->logout();
    }
}
