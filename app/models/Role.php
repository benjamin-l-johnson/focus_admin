<?php
 
class Role extends Eloquent
{
    /**
     * Set timestamps off
     */
    public $timestamps = false;
 
    /**
     * Get users with a certain role
     */
    public function members()
    {
        return $this->belongsToMany('Member', 'roles_members','role_id','member_id');
    }
}
