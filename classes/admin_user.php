<?php
/*
*Elizabeth Benner and Jeff Church
*6/2/17
*admin_user.php
*The AdminUser class represents an administartive user of bark-parks
*/

/**
* The AdminUser class represents an administrative user of bark parks
*
* The AdminUser class represents an administrative user of bark parks,
* it stores basic user info as well as an array of permissions for admin-specific
* actions.
* @author Elizabeth Benner
* @author Jeff Church
* @copyright 2017
*
*/

class AdminUser extends User
{
    private $_permissions;
    
    /**
     *Contructor to create the admin user and save the details
     *and permissions
     *
     *@param array $permissions the user's admin permissions
     */
    function __construct($permissions)
    {
        parent::__construct();
        $this->permissions = $permissions;
    }
    
    //Setter
    
    /**
     *Setter for the permissions array
     *
     *@param array $permissions the user's admin permissions
     */
    function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }
    
    //Getter
    /**
     *Getter for the permissions array
     *
     *@return $permissions the array of admin permissions
     */
    function getPermissions()
    {
        return $this->permissions;
    }
    
    
    
}