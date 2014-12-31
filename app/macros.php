<?php

Form::macro('datetime', function($value) {
    return '<input type="datetime" name="my_custom_datetime_field" value="'.$value.'"/>';
});

/*
	Text area for bootstrap, 
*/
Form::macro('BStextArea', function($name,$rows=3,$place,$val='') {
	
	return '<textarea name="'.$name.'"class="form-control" rows="'.$rows.'" placeholder="'.$place.'" id="'.$name.'" >'.$val.'</textarea>';
    
});

/*
	Text input for bootstrap
*/
Form::macro('BStextIn', function($name,$place,$val='',$class='') {
	
	return '<input name="'.$name.'" class="form-control '.$class.'"type="text" value="'.$val.'" placeholder="'.$place.'" id="'.$name.'">';
    
});

Form::macro('BSnumIn', function($name,$place,$val='',$class='') {
	
	return '<input name="'.$name.'" class="form-control '.$class.'"type="number" value="'.$val.'" placeholder="'.$place.'" id="'.$name.'">';
    
});

Form::macro('BSpass', function($name,$place,$class='') {
	
	return '<input name="'.$name.'"type="password" class="form-control'.$class.'" id="'.$name.'" placeholder="'.$place.'">';
});