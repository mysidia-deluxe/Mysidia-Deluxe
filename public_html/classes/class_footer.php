<?php

/**
 * The Footer Class, defines a standard HTML footer component.
 * It extends from the Widget class, while adding its own implementation.
 * @category Resource
 * @package Widget
 * @author Hall of Famer
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 *
 */

class Footer extends Widget
{

    /**
     * The ads property, specifies the advertisement block on the footer.
     * @access protected
     * @var Division
    */
    protected $ads;
    
    /**
     * The credits property, stores the credits content of the site.
     * @access protected
     * @var Paragraph
    */
    protected $credits;

    /**
     * Constructor of Footer Class, it initializes basic footer properties
     * @access public
     * @return Void
     */
    public function __construct()
    {
        parent::__construct(5, "footer");
    }
    
    /**
     * The setDivision method, setter method for property $division.
     * It is set internally upon object instantiation, cannot be accessed in client code.
     * @param GUIComponent  $module
     * @access protected
     * @return Void
     */
    protected function setDivision(GUIComponent $module)
    {
        if (!$this->division) {
            $this->division = new Division;
            $this->division->setClass("footer");
        }
        $this->division->add($module);
    }
    
    /**
     * The getAds method, getter method for property $ads.
     * @access public
     * @return Paragraph
     */
    public function getAds()
    {
        return $this->ads;
    }
    
    /**
     * The setAds method, setter method for property $ads.
     * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setAds()
    {
        $mysidia = Registry::get("mysidia");
        $this->ads = new Division;
        $page = $mysidia->file->getBasename();
        $text = "";
        $ads = $mysidia->db->select("ads", array(), "page = '{$page}' and status = 'active' ORDER BY RAND() LIMIT 1")->fetchObject();
        if (is_object($ads)) {
            $text = stripslashes($ads->text);
            $aid = $ads->id;
            $actualimpressions= $ads->actualimpressions;
            $impressions= $ads->impressions;
            if ($impressions == "") {
                $impressions = 0;
            }
            $actualimpressions = $actualimpressions + 1;
            $mysidia->db->update("ads", array("actualimpressions" => $actualimpressions), "id='{$aid}'");
            if ($actualimpressions >= $impressions and $impressions != 0) {
                $mysidia->db->update("ads", array("status" => "inactive"), "id='{$aid}'");
            }
        }
        $this->ads->add(new Comment($text));
        $this->setDivision($this->ads);
    }

    /**
     * The getCredits method, getter method for property $credits.
     * @access public
     * @return Paragraph
     */
    public function getCredits()
    {
        return $this->credits;
    }
    
    /**
     * The setCredits method, setter method for property $credits.
     * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setCredits()
    {
        $mysidia = Registry::get("mysidia");
        $this->credits = new Paragraph;
        
        $this->credits->add(new Comment("&#9733; Powered by ", false));
        $creditsLink = new Link("http://www.mysidiaadoptables.com");
        $creditsLink->setText("Mysidia Adoptables v".Mysidia::version);
        $this->credits->add($creditsLink);
        $this->credits->add(new Comment("&#9733;"));
        $this->credits->add(new Comment("Copyright © 2011-" . date('Y') . " Mysidia RPG, Inc. All rights reserved."));
        
        $this->setDivision($this->credits);
    }
}
