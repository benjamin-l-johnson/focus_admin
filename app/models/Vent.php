<?php

//needed for date conversion
use Carbon\Carbon;

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
   
   	public function setDateAttribute($value)
    {
    	//when we save the date attribute format it
        $this->attributes['date'] = Carbon::createFromFormat('m/d/Y', $value);
    }

    public function getDateAttribute($value)
    {
    	//var_dump($value);
    	//when we save the date attribute format it
        //var_dump(date_parse_from_format('d/m/Y', $value));

        return date("m/d/Y", strtotime($value));
    }
}