<?php

interface Resizable{
    public function getWidth();
	public function setWidth($width);
	public function getHeight();
	public function setHeight($height);
    public function resize($dimension, $percent);
}
    
?>