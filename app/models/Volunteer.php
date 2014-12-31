<?php
// file: app/models/Post.php
class Volunteer extends Eloquent {
 
    /*protected $fillable = array(
    	'title', 'read_more', 'content','images_path');*/

    public function vents() {
		return $this->belongsToMany('Vent', 'vents_volunteers', 'volunteer_id', 'vent_id');
	}
 
}