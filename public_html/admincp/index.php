<?php

require("../classes/class_controller.php");
require("../classes/class_frontcontroller.php");
require("../classes/class_initializer.php");

//***************//
//  START SCRIPT //
//***************//

class AdminCP extends FrontController
{
    const DENIED = "You do not have permission to access Admin Control Panel.";
    const BLANK = "You have not entered all of your login information yet.";
    const INCORRECT = "Wrong information entered, please fill in login form again.";
    private $session;
    
    public function __construct()
    {
        $mysidia = Registry::get("mysidia");
        parent::__construct();
        $this->session = $mysidia->session->getid();
    }
    
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $mysidia->session->terminate("status");
        if (!$mysidia->user->isloggedin()) {
            if ($mysidia->input->post("submit")) {
                $this->handleLogin();
                $mysidia->session->assign("status", "handle");
            } else {
                $mysidia->session->assign("status", "prepare");
            }
            return;
        }
    }
    
    private function handleLogin()
    {
        $mysidia = Registry::get("mysidia");
        if (!$mysidia->input->post("username") or !$mysidia->input->post("password")) {
            $this->setFlags("global_error", self::BLANK);
        } else {
            $user = new Admin($mysidia->user->username);
            if ($user->username == $mysidia->input->post("username") and $user->getpassword() == passencr($mysidia->input->post("username"), $mysidia->input->post("password"), $user->getsalt())) {
                $user->acplogin();
                $mysidia->cookies->setAdminCookies();
            } else {
                $mysidia->cookies->loginAdminCookies();
                $this->setFlags("global_error", self::INCORRECT);
            }
        }
        return true;
    }
    
    public function handleRequest()
    {
        $mysidia = Registry::get("mysidia");
        $class = $mysidia->input->get("appcontroller")->capitalize();
        $controller = "ACP{$mysidia->input->get("appcontroller")->capitalize()}Controller";
        $action = $mysidia->input->action();

        try {
            $this->appController = new $controller;
            $this->appController->setFrontController($this);
            $this->appController->$action();
            $this->action = $action;
            return true;
        } catch (InvalidActionException $iae) {
            $this->setFlags("global_action_title", $iae->getmessage());
            return false;
        } catch (NoPermissionException $npe) {
            $this->setFlags("global_error", $npe->getmessage());
            return false;
        } catch (BlankFieldException $bfe) {
            $this->setFlags("global_blank_title", $bfe->getmessage());
            header("Refresh:3; URL='../index'");
            return false;
        } catch (InvalidIDException $iie) {
            $this->setFlags("global_id_title", $iie->getmessage());
            return false;
        } catch (DuplicateIDException $die) {
            $this->setFlags("global_id_title", $die->getmessage());
            return false;
        } catch (UnsupportedFileException $ufe) {
            $this->setFlags("global_error", $ufe->getmessage());
            return false;
        } catch (Exception $e) {
            $error = strtolower(str_replace("Exception", "_error", get_class($e)));
            $this->setFlags($error, $e->getmessage());
            return false;
        }
    }
    
    public static function main()
    {
        $init = new Initializer;
        $mysidia = Registry::get("mysidia");
        $acp = new AdminCP;
        if (!($mysidia->user instanceof Admin)) {
            $acp->setFlags("global_error", self::DENIED);
        } elseif ($mysidia->user->isloggedin() == true and $acp->getRequest()) {
            $acp->handleRequest();
        } else {
            $acp->index();
        }
        $acp->getView();
        $acp->render();
    }
}

AdminCP::main();
