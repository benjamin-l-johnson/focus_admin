<?php

class AdminVolunteersController extends BaseController {

	public function index()
	{
		//
		$volunteers = Volunteer::orderBy('id')->paginate(10);
		
		
		$data = array(
			//'files'=> $images_path,
			'volunteers'=> $volunteers

			);
		return View::make('admin.volunteers.index',$data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$vents = Vent::all();
		return View::make('admin.volunteers.create')->withVents($vents);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//The volunteer table
		//	$table->increments('id');
		//  $table->string('name');
		//  $table->string('photo_path');
		//  $table->integer('rank');
		//	$table->string('email')
		$rules = array(
			'name'       => 'required',
			'rank' => 'required|numeric', 
			'email'    => 'required|email|Unique:volunteers' // make sure the email is an actual email

		);
		
		//Vaildating input from the post
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails())
		{
			return Redirect::route('admin.volunteers.create')
				->withErrors($validator)
				->withInput(Input::except('image'));
		} 
			
		$vents = Vent::all();
		$ventsList= array();
				
		foreach($vents as $vent)
		{ 
			//id they selected a volunteer	
			if(Input::has("vID$vent->id"))
			{
				$ventsList[] = $vent->id;
			}
		}

		if(Input::hasFile('image'))
		{
			$file = Input::file('image');
			$upload_success='';
			$newFileName;
			$dir = Str::random(12);

    			$rules = array('file' => 'required|image');
		    	$validator = Validator::make(array('file'=> $file), $rules);
    			
    			if($validator->passes())
    			{
	        		
	        		$destinationPath = Config::get('otherapp.images_path')."/images/$dir/";
			        $newFileName = Str::random(12);
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg, under 2000KB';
					return Redirect::route('admin.volunteers.create')
						->withErrors([$error])->withInput();
				}
			
			if( $upload_success )
			{
			
				$vol = new Volunteer;
				$vol->name      		= Input::get('name');
				$vol->email 			= Input::get('email');
				$vol->rank 				= Input::get('rank');			
				$vol->photo_path	= "images/$dir/$newFileName";
				$vol->save();

				//Now that it has been created, sync the list
				$vol->vents()->sync($ventsList);

				//report success 
				Session::flash('message', 'Successfully created new volunteer!');
				return Redirect::route('admin.volunteers.index');
			}
			else
			{
				$error = "Failed to move the file. Contact the sysadmin $newFileName";
				return Redirect::route('admin.volunteers.create')
					->withErrors([$error])->withInput();
			}
		}
		else
		{
			return Redirect::route('admin.volunteers.create')
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

		$volunteers = Member::find($id);
		$images_path = Config::get('otherapp.images_path').e("/$volunteers->images_path");

		//get all of the base names of the files
		$files = array_map('basename', File::files($images_path));

		$data = array(
			'evol'=>$volunteers,
			'files'=>$files,
			'ipath'=>$images_path
			);

		return View::make('volunteers.show',$data);
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
		$vol = Volunteer::find($id);
		$vents = Vent::all();
		//$volunteers = Volunteer::all();
		return View::make('admin.volunteers.edit')->withVol($vol)->withVents(
			$vents);
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
			'name'       => 'required',
			'rank' => 'required|numeric', 
			'email'    => "required|email|Unique:volunteers,email,$id" // make sure the email is an actual email

		);
		
		//Validating input from the post
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails())
		{
			return Redirect::route('admin.volunteers.edit',$id)
				->withErrors($validator)
				->withInput(Input::except('image'));
		} 

		$vol = Volunteer::find($id);

		$vents = Vent::all();

		$ventsList= array();
				
		foreach($vents as $vent)
		{ 
			//id they selected a volunteer	
			if(Input::has("vID$vent->id"))
			{
				$ventsList[] = $vent->id;
			}
		}
		if(Input::hasFile('image'))
		{
			$file = Input::file('image');
			$upload_success='';
			$newFileName;
			$dir = Str::random(12);

			$rules = array(
   				'file' => 'required|image'
				);
	    	$validator = Validator::make(array('file'=> $file), $rules);
			if($validator->passes())
			{
        		
        		$destinationPath = Config::get('otherapp.images_path')."/images/$dir/";
		        $newFileName = Str::random(12);
		        $upload_success = $file->move($destinationPath, $newFileName);
		    }
		    else
			{
				$error = 'You can only upload png,gif,jpg, and jpeg';
				return Redirect::route('admin.volunteers.edit',$id)
					->withErrors([$error])->withInput();
			}
			
			if( $upload_success )
			{
			
				// store
				$vol->name      		= Input::get('name');
				$vol->email 			= Input::get('email');
				$vol->rank 				= Input::get('rank');	
				$vol->photo_path	= "images/$dir/$newFileName";
				$vol->save();

				//Now that it has been created, sync the list
				$vol->vents()->sync($ventsList);
				
				Session::flash('message', "Successfully edited  $vol->name!");
				return Redirect::route('admin.volunteers.index');
			}
			else
			{
				$error = "Failed to move the file. Contact the sysadmin $newFileName";
				return Redirect::route('admin.volunteers.edit')
					->withErrors([$error])->withInput();
			}
		}
		else
		{
			$vol->name      		= Input::get('name');
			$vol->email 			= Input::get('email');
			$vol->rank 				= Input::get('rank');
			$vol->save();

			//Now that it has been created, sync the list
			$vol->vents()->sync($ventsList);
			
			Session::flash('message', "Successfully edited  $vol->name!");
				return Redirect::route('admin.volunteers.index');
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
		$vol = Volunteer::find($id);
		$vol->delete();
		Session::flash('message', "Successfully deleted volunteer #$id!");
				return Redirect::route('admin.volunteers.index');
	}


}
