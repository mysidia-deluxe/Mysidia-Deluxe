<?php

namespace Resource\Utility;

use Resource\Native\Object;

/**
 * The Curl Class, it is part of the utility package and extends from the Object Class.
 * It implements PHP basic curl functions, and adds enhanced features upon them.
 * @category Resource
 * @package Utility
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not sure, but will come in handy.
 */

final class Curl extends Object
{

    /**
     * The handle property, it stores an initialized curl request.
     * @access private
     * @var String
    */
    private $handle = null;
    
    /**
     * The status property, it stores the status of the curl request.
     * @access private
     * @var String
    */
    private $status = null;
 
 
    /**
     * The constructor for Curl Class, retrieves language vars from directory /lang.
     * @param String|URL  $url
     * @access public
     * @return Void
     */
    public function __construct($url = "")
    {
        $this->init();
        if (!empty($url)) {
            $this->setUrl($url);
        }
    }
    
    /**
     * The Magic method __Call, it handle calls to undefined methods.
     * Allows calling set_XXXX where XXXX is a value CURLOPT_XXXX -- e.g., set_post(true) would be the same as set_opt(CURLOPT_POST, true).
     * For a list of options, see http://us.php.net/curl_setopt
     * @param String  $name
     * @param Array  $args
     * @access public
     * @return Boolean
     */
    public function __call($name, $args)
    {
        if (strpos($name, "set") !== 0 or count($args) !== 0) {
            return;
        }
        $args = $args[0];
        $option = substr($name, 4);
        $option = "CURLOPT_" . strtoupper($option);
        return $this->setOpt($option, $args);
    }
 
    /**
     * The init method, initialize the Curl object.
     * @access private
     * @return Boolean
     */
    private function init()
    {
        if (!is_null($this->handle)) {
            @curl_close($this->handle);
        }
        $this->handle = curl_init();
        $this->status = null;
        $this->set_return(true);
    }
 
    /**
     * The setOpt method, execute a curl with any given info.
     * @param String  $option
     * @param String  $value
     * @access public
     * @return Boolean
     */
    public function setOpt($option, $value)
    {
        return curl_setopt($this->handle, $option, $value);
    }
 
    /**
     * The setUrl method, execute a curl with the provided url.
     * @param String|URL  $url
     * @access public
     * @return Boolean
     */
    public function setUrl($url)
    {
        if ($url instanceof URL) {
            $url = $url->getUrl();
        }
        return $this->setOpt(CURLOPT_URL, $url);
    }
 
    /**
     * The setReturn method, execute a curl and return the transfer of string.
     * @param String  $value
     * @access public
     * @return Boolean
     */
    public function setReturn($value)
    {
        return $this->setOpt(CURLOPT_RETURNTRANSFER, $value);
    }
    
    /**
     * The setHeader method, execute a curl with header included in output.
     * @access public
     * @return Boolean
     */
    public function setHeader()
    {
        return $this->setOpt(CURLOPT_HEADER, 0);
    }
 
    /**
     * The exec method, which execute a cURL call via curl_exec().
     * Returns the data from curl_exec if $return_status is false, or returns an array with both the data and the status if true.
     * @param Boolean $returnStatus
     * @access public
     * @return Void|ArrayObject
     */
    public function exec($returnStatus = false)
    {
        $this->status = null;
        $data = curl_exec($this->handle);
        $info = $this->getInfo();
        $this->status = $info['http_code'];
        if ($returnStatus == true) {
            $data = new ArrayObject;
            $data->offsetSet("data", $data);
            $data->offsetSet("status", $this->status);
        }
        return $data;
    }
 
    /**
     * The getInfo method, get the info regarding a specific curl transfer.
     * @param int  $opt
     * @access public
     * @return String|Array
     */
    public function getInfo($opt = "")
    {
        return curl_getinfo($this->handle, (int)$opt);
    }
    
    /**
     * The triggerError method, triggers a curl error message if an error is found.
     * @access public
     * @return String
     */
    public function triggerError()
    {
        return curl_error($this->handle);
    }
 
    /**
     * The status method, gets the HTTP status code from the last call to exec().
     * Returns null if exec hasn't been called.
     * @access public
     * @return String
     */
    public function status()
    {
        return $this->status;
    }
 
    /**
     * The reset method, reset the current curl session.
     * @access public
     * @return Void
     */
    public function reset()
    {
        $this->init();
    }
    
    /**
     * The close method, close the current curl session.
     * @access public
     * @return Void
     */
    public function close()
    {
        curl_close($this->handle);
    }
}
