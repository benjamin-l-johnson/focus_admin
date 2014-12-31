<?php
// file: app/models/Post.php
class Nonprofit extends Eloquent {
 
    /*protected $fillable = array(
    	'title', 'read_more', 'content','images_path');*/

    public function vents() {
		return $this->belongsToMany('Vent', 'vents_nonprofits', 'nonprofit_id', 'vent_id');
	}
 
 
}