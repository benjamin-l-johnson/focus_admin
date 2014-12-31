<?php
 


class AdminNonProfitController extends BaseController {

	
	public function index()
	{
		//
		$nonprofits = Nonprofit::orderBy('id')->paginate(5);
		
		
		//$files = File::files($public_path);
		$data = array(
			//'files'=> $images_path,
			'nonprofits'=> $nonprofits

			);
		return View::make('admin.nonprofits.index',$data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$vent = Vent::all();
		return View::make('admin.nonprofits.create')->withVents($vent);
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

		//Failed to validate
		if ($validator->fails())
		{
			return Redirect::route('admin.nonprofits.create')
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
	        		
	        		$destinationPath = get_os_image_path()."/images/$dir/";
			        $newFileName = "$fid";
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg';
					return Redirect::route('admin.nonprofits.create')
						->withErrors([$error])->withInput();
				}
			}
			if( $upload_success )
			{
			
				// store
				$nonProf = new Nonprofit;

				// sync it
				
				$nonProf->name      		= Input::get('name');
				$nonProf->read_more   		= Input::get('readMore');
				$nonProf->content 			= Input::get('content');
				$nonProf->images_path  	= "images/$dir/";
				$nonProf->cover_photo_name = $newFileName;
				$nonProf->save();
				$nonProf->vents()->sync($ventsList);

				Session::flash('message', 'Successfully created new nonprofit!');
				return Redirect::route('admin.nonprofits.index');
			}
			else
			{
				$error = 'Failed to move the file. Contact the sysadmin';
				return Redirect::route('admin.nonprofits.create')
					->withErrors([$error])->withInput();
			}
		}
		else
		{
			return Redirect::route('admin.nonprofits.create')
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

		$nonprofits = Nonprofit::find($id);
		$images_path = get_os_image_path().e("/$nonprofits->images_path");

		//get all of the base names of the files
		$files = array_map('basename', File::files($images_path));

		$data = array(
			'event'=>$nonprofits,
			'files'=>$files,
			'ipath'=>$images_path
			);

		return View::make('nonprofits.show',$data);
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
		$nonprof = Nonprofit::find($id);
		$vent = Vent::all();
		return View::make('admin.nonprofits.edit')->withNonprof($nonprof)->withVents($vent);
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
			return Redirect::route('admin.nonprofits.edit',$id)
				->withErrors($validator)
				->withInput(Input::except('images'));
		} 

		//if it did not fail, find the nonprofit
		$nonProf = Nonprofit::find($id);

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
	        		
	        		$destinationPath = get_os_image_path().'/'.$nonProf->images_path;
			        $newFileName = "$fid";
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg';
					return Redirect::route('admin.nonprofits.edit',$id)
						->withErrors($validator)->withInput(Input::except('images'));
				}
			}
			if( $upload_success )
			{
				// store it
				$nonProf->name      		= Input::get('name');
				$nonProf->read_more   		= Input::get('readMore');
				$nonProf->content 			= Input::get('content');
				$nonProf->save();

				// sync it
				$nonProf->vents()->sync($ventsList);

				Session::flash('message', "Successfully edited nonprofit #$nonProf->id");
				return Redirect::route('admin.nonprofits.index');
			}
			else
			{
				$error = 'Failed to move the file. Contact the sysadmin';
				return Redirect::route('admin.nonprofits.edit',$id)
					->withErrors([$error])->withInput(Input::except('images'));
			}
		}
		else
		{				
				//store it
				$nonProf->name      		= Input::get('name');
				$nonProf->read_more   		= Input::get('readMore');
				$nonProf->content 			= Input::get('content');
				$nonProf->save();
				
				// sync it
				$nonProf->vents()->sync($ventsList);
				
				Session::flash('message', "Successfully edited nonprofit #$id!");
				return Redirect::route('admin.nonprofits.index');
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
		$nonProf = Nonprofit::find($id);
		$nonProf->delete();
		Session::flash('message', "Successfully deleted nonprofit #$id!");
				return Redirect::route('admin.nonprofits.index');
	}


}
