<?php
/*
*Elizabeth Benner and Jeff Church
*5/30/17
*park.php
*The Park class represents a dog park listing
*/

/**
* The Park class represents a dog park listing
*
* The Park class represents a dog park listing,
* it stores park name, location, and description
* @author Elizabeth Benner
* @author Jeff Church
* @copyright 2017
*
*/

class Park
{
    protected $name;
    protected $location;
    protected $description;
    
    /**
     *Contructor to create the park object and save the details
     *
     *@param String $name the name of the park
     *@param String $location the location of the park
     *@param String $description the description text about the park
     */
    function __construct($title, $text, $bloggerId)
    {
        $this->name = $name;
        $this->location = $location;
        $this->description = $description;
    }
    
    //Setters
    /**
     *Setter for the park name
     *
     *@param String $name the name of the park
     */
    function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     *Setter for the park location
     *
     *@param String $location the location of the park
     */
    function setLocation($location)
    {
        $this->location = $location;
    }
    
    /**
     *Setter for the description
     *
     *@param String $description the description of the park
     */
    function setDescription($description)
    {
        $this->description = $description;
    }
    
    //Getters
    /**
     *Getter for the park name
     *
     *@return String the name of the park
     */
    function getName()
    {
        return $this->name;
    }
    
    /**
     *Getter for the park location
     *
     *@return String the location of the park
     */
    function getLocation()
    {
        return $this->location;
    }
    
    /**
     *Getter for the park description
     *
     *@return String the description of the park
     */
    function getDescription()
    {
        return $this->description;
    }
    
    
    
    
    
}