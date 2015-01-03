<?php
 


class AdminEventController extends BaseController {

	
	public function index()
	{
		//
		$events = Vent::orderBy('id')->paginate(5);
		
		
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
			'readMore' => 'required'
		);
		
		//Vaildating input from the post
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails())
		{
			return Redirect::route('admin.events.create')
				->withErrors($validator)
				->withInput(Input::except('images'));
		} 

		
		if(Input::hasFile('images'))
		{
			$files = Input::file('images');
			$upload_success='';
			$newFileName;
			
			$dir = Str::random(12);

			foreach($files as $file) 
			{
    			$rules = array(
       				'file' => 'required|image'
    				);
		    	$validator = Validator::make(array('file'=> $file), $rules);
    			if($validator->passes())
    			{	        		
	        		
	        		$destinationPath = Config::get('otherapp.images_path')."/images/$dir/";
			        
			        $newFileName =  Str::random(12);;
			        
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg';
					return Redirect::route('admin.events.create')
						->withErrors([$error])->withInput();
				}
			}
			if( $upload_success )
			{
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

				// store it
				$vent = new Vent;

				//sync all of them
				$vent->title      		= e(Input::get('title'));
				$vent->read_more   		= e(Input::get('readMore'));
				$vent->content 			= e(Input::get('content'));
				$vent->images_path  	= "images/$dir/";
				$vent->cover_photo_name = $newFileName;
				$vent->save();

				//Now that it has been saved, sync the list
				$vent->volunteers()->sync($volsList);

				//report success
				Session::flash('message', 'Successfully created new event!');
				return Redirect::route('admin.events.index');
			}
			else
			{
				$error = 'Failed to move the file. Contact the sysadmin';
				return Redirect::route('admin.events.create')
					->withErrors([$error])->withInput();
			}
		}
		else
		{
			return Redirect::route('admin.events.create')
				->withErrors(['No images attachted!'])->withInput();
		}
		

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//		

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
			'readMore' => 'required|Max:120'
		);
		
		//Vaildating input from the post
		$validator = Validator::make(Input::all(), $rules);

		// process the input
		if ($validator->fails())
		{
			return Redirect::route('admin.events.edit',$id)
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

		//if we uploaded images
		if(Input::hasFile('images'))
		{

			//get multiple files
			$files = Input::file('images');
			$upload_success='';
			
			$newFileName;

			//create random directory twelve letters long
			$dir = Str::random(12);
			

			foreach($files as $file) 
			{
    			
    			$rules = array('file' => 'required|image');
		    	$validator = Validator::make(array('file'=> $file), $rules);
    			
    			if($validator->passes()){

	        		//create a final path
	        		$destinationPath = Config::get('otherapp.images_path').'/'.$vent->images_path;
			        $newFileName = Str::random(12);
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg';
					return Redirect::route('admin.events.edit',$id)
						->withErrors($validator)->withInput(Input::except('images'));
				}
			}
			if( $upload_success )
			{

				// store it
				$vent->title      		= e(Input::get('title'));
				$vent->read_more   		= e(Input::get('readMore'));
				$vent->content 			= e(Input::get('content'));
				$vent->save();

				//sync all of them
				$vent->volunteers()->sync($volsList);


				Session::flash('message', "Successfully edited event #$vent->id");
				return Redirect::route('admin.events.index');
			}
			else
			{
				$error = 'Failed to move the file. Contact the sysadmin';
				return Redirect::route('admin.events.edit',$id)
					->withErrors([$error])->withInput(Input::except('images'));
			}
		}
		else
		{
				//store it
				$vent->title      		= e(Input::get('title'));
				$vent->read_more   		= e(Input::get('readMore'));
				$vent->content 			= e(Input::get('content'));
				$vent->save();

				//sync all of them
				$vent->volunteers()->sync($volsList);
				
				Session::flash('message', "Successfully edited event #$id!");
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
