<?php
// file: app/models/Post.php
class Student extends Eloquent {
 
    /*protected $fillable = array(
    	'title', 'read_more', 'content','images_path');*/

    public function vents() {
		return $this->belongsToMany('Vent', 'vents_students', 'student_id', 'vent_id');
	}
 
}