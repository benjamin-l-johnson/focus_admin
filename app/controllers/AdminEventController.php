<?php
 


class AdminEventController extends BaseController {

	
	public function index()
	{
		//
		$events = Vent::orderBy('date','desc')->paginate(10);
		
		
		//$files = File::files($public_path);
		$data = array(
			//'files'=> $images_path,
			'events'=> $events

			);
		return View::make('admin.events.index',$data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$volunteers = Volunteer::all();
		return View::make('admin.events.create')->withVolunteers($volunteers);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		

		$rules = array(
			'title'       => 'required',
			'content'      => 'required',
			'readMore' => 'required',
			'date' => 'required|date_format:"m/d/Y"'
		);
		
		//Validating input from the post
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('admin.events.create')
				->withErrors($validator)
				->withInput(Input::except('images'));
		} 

		
		if(Input::hasFile('images'))
		{
			$files = Input::file('images');
			$uploadSuccess;
			$newFileName;
			$dir = Str::random(12);
			$dir = "images/$dir/";
			//validate the image
			$rules = array(
       				'file' => 'required|image'
    				);

			//validate the images
			$valid = $this->imagesValid($files,$rules);

			//images were not valid return error
			if(!$valid)
			{

				$error = 'You can only upload png,gif,jpg, and jpeg';
				return Redirect::route('admin.events.create')
					->withErrors([$error])->withInput();
			}


			//get number of volunteers
			$vols = Volunteer::all();
			$volsList= array();
			
			foreach($vols as $vol)
			{ 
				//id they selected a volunteer	
				if(Input::has("vID$vol->id"))
				{
					$volsList[] = $vol->id;
				}
			}

			$images = array();

			//save and move images
			foreach($files as $file) 
			{        		
        		
        		$destinationPath = Config::get('otherapp.images_path')."/$dir";
		        
		        $newFileName =  Str::random(12);
		        
		        $uploadSuccess = $file->move($destinationPath, $newFileName);


		        //some file was not moved properly return an error
		       	if($uploadSuccess==false)
				{
		        	$error = 'Failed to move the file. Contact the sysadmin';
					return Redirect::route('admin.events.create')
					->withErrors([$error])->withInput();
				}


		        $images[] = new Image(array(
		        						'path'=>$destinationPath.$newFileName,
		        						'name'=>$newFileName,
		        						'folder'=>$dir
		        						)
		        	);

		    }
			
			// store it
			$vent = new Vent;

			$vent->title      		= e(Input::get('title'));
			$vent->read_more   		= e(Input::get('readMore'));
			$vent->content 			= e(Input::get('content'));
			$vent->date 			= e(Input::get('date'));
			$vent->images_path  	= $dir;

		 	$vent->cover_photo_name = $newFileName;
			$vent->save();

			//Now that it has been saved, sync the list
			$vent->volunteers()->sync($volsList);
			
			$vent->images()->saveMany($images);
			
			//report success
			Session::flash('message', "Successfully created new event! $vent->title");
			return Redirect::route('admin.events.index');
		}
		else
		{	//didn't attach photo return error
			return Redirect::route('admin.events.create')
				->withErrors(['No images attachted!'])->withInput();
		}
		

	}

	/**
	*	A quick function to validate all the images we're passed
	*	@return bool
	*/
	private function imagesValid($files,$rules)
	{
		foreach($files as $file) 
		{
			$validator = Validator::make(array('file'=> $file), $rules);
    		
    		if(!$validator->passes())
    		{
    			return false;
    		}
		}

		return true;
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	
		$events = Vent::find($id);
		$images_path = Config::get('otherapp.images_path').e("/$events->images_path");

		//get all of the base names of the files
		$files = array_map('basename', File::files($images_path));

		$data = array(
			'event'=>$events,
			'files'=>$files,
			'ipath'=>$images_path
			);

		return View::make('events.show',$data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
		$vent = Vent::find($id);
		$volunteers = Volunteer::all();
		return View::make('admin.events.edit')->withVent($vent)->withVolunteers($volunteers);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{		

		$rules = array(
			'title'       => 'required',
			'content'      => 'required',
			'readMore' => 'required',
			'date' => 'required|date_format:"m/d/Y"'
		);
		
		//Validating input from the post
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::route('admin.events.create')
				->withErrors($validator)
				->withInput(Input::except('images'));
		} 

		//if it did not fail find the event
		$vent = Vent::find($id);

		//get number of volunteers
		$vols = Volunteer::all();
		$volsList= array();
			
		foreach($vols as $vol)
		{ 
			//id they selected a volunteer	
			if(Input::has("vID$vol->id"))
			{
				$volsList[] = $vol->id;
			}
		}

		if(Input::hasFile('images'))
		{
			$files = Input::file('images');
			$uploadSuccess;
			$newFileName;
			$dir = Str::random(12);

			//validate the image
			$rules = array(
       				'file' => 'required|image'
    				);

			//validate the images
			$valid = $this->imagesValid($files,$rules);

			//images were not valid return error
			if(!$valid)
			{

				$error = 'You can only upload png,gif,jpg, and jpeg';
				return Redirect::route('admin.events.create')
					->withErrors([$error])->withInput();
			}


			$images = array();

			//save and move images
			foreach($files as $file) 
			{        		
        		
        		$destinationPath = Config::get('otherapp.images_path')."/$vent->images_path";
		        
		        $newFileName =  Str::random(12);
		        
		        $uploadSuccess = $file->move($destinationPath, $newFileName);


		        //some file was not moved properly return an error
		       	if($uploadSuccess==false)
				{
		        	$error = 'Failed to move the file. Contact the sysadmin';
					return Redirect::route('admin.events.create')
					->withErrors([$error])->withInput();
				}


		        $images[] = new Image(array(
		        		'path'=>$destinationPath.$newFileName,
		        		'name'=>$newFileName,
		        		'folder'=>$vent->images_path
		        						)
		        	);

		    }
			
			$vent->title      		= e(Input::get('title'));
			$vent->read_more   		= e(Input::get('readMore'));
			$vent->content 			= e(Input::get('content'));
			$vent->date 			= e(Input::get('date'));
		 	$vent->cover_photo_name = $newFileName;
			$vent->save();


			//Now that it has been saved, sync the list
			$vent->volunteers()->sync($volsList);

			$vent->images()->saveMany($images);
			
			//report success
			Session::flash('message', "Successfully created new event! $vent->title");
			return Redirect::route('admin.events.index');
		}
		else
		{	

			$vent->title      		= e(Input::get('title'));
			$vent->read_more   		= e(Input::get('readMore'));
			$vent->content 			= e(Input::get('content'));
			$vent->date 			= e(Input::get('date'));
			$vent->save();
			
			Session::flash('message', "Successfully edited event $vent->title!");
				return Redirect::route('admin.events.index');
		}
		

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$vent = Vent::find($id);

		$vent->delete();
		Session::flash('message', "Successfully deleted event #$id!");
				return Redirect::route('admin.events.index');
	}


}
