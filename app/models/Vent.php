<?php
// file: app/models/Post.php
class Vent extends Eloquent {
 
    /*protected $fillable = array(
    	'title', 'read_more', 'content','images_path');*/

    public function students() {
		return $this->belongsToMany('Student','vents_students','vent_id','student_id');
	}
	public function nonprofits()
	{
		return $this->belongsToMany('Nonprofit','vents_nonprofits','vent_id','nonprofit_id');
	}

	public function volunteers() {
		return $this->belongsToMany('Volunteer','vents_volunteers','vent_id','volunteer_id');
	}
 
}