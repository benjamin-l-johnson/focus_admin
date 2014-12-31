<?php
// file: app/models/Post.php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Member extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

	public function roles()
    {
        return $this->belongsToMany('Role', 'roles_members','member_id','role_id');
    }
	
    /**
     * Find out if User is an Admin, based on if has any roles
     *
     * @return boolean
     */
    public function isAdmin()
    {
        $roles = $this->roles->toArray();
        return !empty($roles);
    }
 
    /**
     * Find out if user has a specific role
     *
     * $return boolean
     */
    public function can($check)
    {
        return in_array($check, array_fetch($this->roles->toArray(), 'name'));
    }
 
    /**
     * Get key in array with corresponding value
     *
     * @return int
     */
    private function getIdInArray($array, $term)
    {
        foreach ($array as $key => $value) {
            if ($value == $term) {
                return $key;
            }
        }
 
        throw new UnexpectedValueException;
    }
 
    /**
     * Add roles to user to make them a concierge
     */
    public function makeAdmin($title)
    {
        $assigned_roles = array();
 
        $roles_id = array_fetch(Role::all()->toArray(), 'id');
		$roles_name = array_fetch(Role::all()->toArray(), 'name');
		$roles = array_combine( $roles_id , $roles_name );

        switch ($title) {
             case 'admin':
                $assigned_roles[] = $this->getIdInArray($roles, 'delete_members');
                break;
            default:
                throw new Exception("The employee status entered does not exist");
        }
 
        $this->roles()->attach($assigned_roles);
    }


}