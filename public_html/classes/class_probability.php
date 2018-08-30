<?php

use Resource\Native\Object;

/**
 * The Probability Class, extends from abstract Object class.
 * It generates one or a group of random events based on probability of each.
 * @category Resource
 * @package Utility
 * @author Hall of Famer(finalized version), xyph(initial script)
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.3
 * @todo Not much at this point.
 * @final
 *
 */
 
final class Probability extends Object{
 
    /**
	 * This will hold our possible outcomes along with thier probabilities. 
	 * I store them with the key being the name of teh event, and the value. it's probability to show up. $this->events['name'] = probability
	 * @access private
	 * @var Array
    */
    private $events = array();

	/**
     * Constructor of Probability Class, it can generates events list immediately.      
     * @access public
     * @return Void
     */	
	public function __construct($events = ""){
	    if($events instanceof ArrayObject) $this->events = $events->getArrayCopy();
	}
        
 	/**
	 * This method will add a new event to the array. I didn't include a check to make sure a duplicate exists. 
	 * So as it is, if you call $this->addEvent( 'blue', 20 );
     * followed by $this->addEvent( 'blue', 30 ); 
	 * 'blue' will now have a value of 30.
	 * @param String  $value
	 * @param Int  $probability
	 * @access public
	 * @return Void
	*/	
    public function addEvent($value, $probability) {
        $this->events[$value] = $probability;
    }
 
  	/**
	 * Simple method to remove an event. I don't think the array_key_exists() check is needed, but it's there.
	 * @param String  $value
	 * @access public
	 * @return Void
    */		
    public function removeEvent($value){
        if(array_key_exists($value, $this->events)) unset($this->events[$value]);
    }
        
    /**
	 * The randEvent method to remove an event. This is where one or multiple random events will be generated.
	 * @param Int  $num
	 * @access public
	 * @return String|Array
    */
    public function randomEvent($num = 1) {
	
        // Generate a reverse list of events, using our class method below to change the individual probabilities into comparable numbers.
        $events = array_reverse( $this->buildEvents(), TRUE);
        $sum = array_sum($this->events);
		
        // If only 1 result is needed, we want to return a string. Otherwise, we'll build an array.
        if($num == 1){
            // Generate the random number between 1 and the sum of all probabilities
            $rand = mt_rand( 1, $sum );
			
            // Loop through probabilities, greatest to lowest.
            foreach($events as $event => $probability){
  			    if($probability <= $rand) return $event;
			}	                
        } 		
		else{
            // Set up an empty array to hold the values.
            $eventList = array();
			
            // Loop through the following code $num times
            for($i = 0; $i < $num; $i++){
                // Generate our random number INSIDE the loop, so it gets changed every time
                $rand = mt_rand(1, $sum);
                foreach($events as $event => $probability){
                    if($probability <= $rand) {
                        // If so, add a new array entry. Since we don't need to loop through any more events until we generate a new random number, we use break to escape out of the foreach.
                        $eventList[] = $event; 
						break;
                    }
				}	
            }
            return $eventList;
        }
    }
	
    /**
	 * The buildEvents method, here's where we modify the events array to become more usable.
	 * We do this on the fly, rather than when we add an event because it makes removing events a much easier process. 
	 * @access private
	 * @return Array
    */        
    private function buildEvents() {
        // Create a local copy of the events array. We can change this all we want without modifying data that other class methods might still need.
        $events = $this->events;
        $total = 0;
		
        // Loop through each probability. The &$event will apply any changes made in the loop to the $events array.
        foreach($events as &$probability){
            $original = $probability;
            $probability = $total;
            $total += $original;
        }
		
        // Return the momdified event array
        return $events;
    }
}

?>