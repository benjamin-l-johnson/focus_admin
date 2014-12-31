<?php
 


class AdminStudentsController extends BaseController {

	
	public function index()
	{
		//
		$stu = Student::orderBy('id')->paginate(5);
		
		
		//$files = File::files($public_path);
		$data = array(
			//'files'=> $images_path,
			'students'=> $stu

			);
		return View::make('admin.students.index',$data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$vent = Vent::all();
		return View::make('admin.students.create')->withVents($vent);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		

		$rules = array(
			'name'       => 'required',
			'content'      => 'required',
			'readMore' => 'required'
		);
		
		//Vaildating input from the post
		$validator = Validator::make(Input::all(), $rules);

		
		if ($validator->fails())
		{
			return Redirect::route('admin.students.create')
				->withErrors($validator)
				->withInput(Input::except('images'));
		} 

		//find all events
		$vents = Vent::all();

		$ventsList= array();
		foreach($vents as $vent)
		{ 
			//id they selected of event	
			if(Input::has("vID$vent->id"))
			{
				$ventsList[] = $vent->id;
			}
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
    			if($validator->passes()){

	        		$fid = Str::random(12);
	        		
	        		$destinationPath = Config::get('otherapp.images_path')."/images/$dir/";
			        $newFileName = "$fid";
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg';
					return Redirect::route('admin.students.create')
						->withErrors([$error])->withInput();
				}
			}
			if( $upload_success )
			{

				// store
				$stu = new Student;
				$stu->name      		= Input::get('name');
				$stu->read_more   		= Input::get('readMore');
				$stu->content 			= Input::get('content');
				$stu->images_path  	= "images/$dir/";
				$stu->cover_photo_name = $newFileName;
				$stu->save();

				//sync it
				$stu->vents()->sync($ventsList);
				
				Session::flash('message', 'Successfully created new student group!');
				return Redirect::route('admin.students.index');
			}
			else
			{
				$error = 'Failed to move the file. Contact the sysadmin';
				return Redirect::route('admin.students.create')
					->withErrors([$error])->withInput();
			}
		}
		else
		{
			return Redirect::route('admin.students.create')
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

		$stu = Student::find($id);
		$images_path = Config::get('otherapp.images_path').e("/$stu->images_path");

		//get all of the base names of the files
		$files = array_map('basename', File::files($images_path));

		$data = array(
			'event'=>$stu,
			'files'=>$files,
			'ipath'=>$images_path
			);

		return View::make('students.show',$data);
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
		$stu = Student::find($id);
		$vent = Vent::all();
		return View::make('admin.students.edit')->withStudent($stu)->withVents($vent);
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
			'content'      => 'required',
			'readMore' => 'required|Max:120'
		);
		
		//Vaildating input from the post
		$validator = Validator::make(Input::all(), $rules);

		// process the input
		if ($validator->fails())
		{
			return Redirect::route('admin.students.edit',$id)
				->withErrors($validator)
				->withInput(Input::except('images'));
		} 

		//if it did not fail find the student group
		$stu = Student::find($id);

		//find all events
		$vents = Vent::all();

		$ventsList= array();
		foreach($vents as $vent)
		{ 
			//id they selected of event	
			if(Input::has("vID$vent->id"))
			{
				$ventsList[] = $vent->id;
			}
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
    			if($validator->passes()){

	        		$fid = Str::random(12);
	        		
	        		$destinationPath = Config::get('otherapp.images_path').'/'.$stu->images_path;
			        $newFileName = "$fid";
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg';
					return Redirect::route('admin.students.edit',$id)
						->withErrors($validator)->withInput(Input::except('images'));
				}
			}
			if( $upload_success )
			{
			

				$stu->vents()->sync($ventsList);
				$stu->name      		= Input::get('name');
				$stu->read_more   		= Input::get('readMore');
				$stu->content 			= Input::get('content');
				$stu->save();

				Session::flash('message', "Successfully edited student group #$stu->id");
				return Redirect::route('admin.students.index');
			}
			else
			{
				$error = 'Failed to move the file. Contact the sysadmin';
				return Redirect::route('admin.students.edit',$id)
					->withErrors([$error])->withInput(Input::except('images'));
			}
		}
		else
		{
				$stu->vents()->sync($ventsList);
				$stu->name      		= Input::get('name');
				$stu->read_more   		= Input::get('readMore');
				$stu->content 			= Input::get('content');
				$stu->save();

				Session::flash('message', "Successfully edited student group #$id!");
				return Redirect::route('admin.students.index');
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
		$stu = Student::find($id);
		$stu->delete();
		Session::flash('message', "Successfully deleted Student #$id!");
				return Redirect::route('admin.students.index');
	}


}
