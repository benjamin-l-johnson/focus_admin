<?php

class AdminMemebersController extends BaseController {

	public function index()
	{
		//
		$members = Member::orderBy('order')->paginate(50);
		
		
		$data = array(
			'members'=> $members

			);
		return View::make('admin.members.index',$data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('admin.members.create');
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
			'jobTitle'      => 'required',
			'about' => 'required',
			'email'    => 'required|email|Unique:members', // make sure the email is an actual email
			'password' => 'required|alphaNum|min:5|Confirmed', //only alpha numeric and must be confirmed
			'password_confirmation'=>'required|alphaNum|min:5' 
		);
		
		//Vaildating input from the post
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails())
		{
			return Redirect::route('admin.members.create')
				->withErrors($validator)
				->withInput(Input::except('image'));
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
    			if($validator->passes()){

	        		$fid = Str::random(12);
	        		
	        		$destinationPath = Config::get('otherapp.images_path')."/images/$dir/";
			        $newFileName = "$fid";
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg, under 2000KB';
					return Redirect::route('admin.members.create')
						->withErrors([$error])->withInput();
				}
			
			if( $upload_success )
			{
			
				// store
				$memb = new Member;
				$memb->name      		= e(Input::get('name'));
				$memb->job_title   		= e(Input::get('jobTitle'));
				$memb->about 			= e(Input::get('about'));
				$memb->email 			= e(Input::get('email'));
				$memb->password 		= Hash::make(e(Input::get('password')));
				$memb->linkedin			= e(Input::get('linkedin'));
				$memb->twitter			= e(Input::get('twitter'));
				$memb->facebook			= e(Input::get('facebook'));
				$memb->instagram		= e(Input::get('instagram'));				
				$memb->photo_path	= "images/$dir/$newFileName";
				$memb->save();
				
				if(Auth::user()->isAdmin() && Input::get('admin'))
				{
					$memb->makeAdmin('admin');
				}
				else
				{
					$memb->roles()->detach();
				}

				Session::flash('message', 'Successfully created new member!');
				return Redirect::route('admin.members.index');
			}
			else
			{
				$error = "Failed to move the file. Contact the sysadmin $newFileName";
				return Redirect::route('admin.members.create')
					->withErrors()->withInput();
			}
		}
		else
		{
			return Redirect::route('admin.members.create')
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

		$members = Member::find($id);
		$images_path = Config::get('otherapp.images_path').e("/$members->images_path");

		//get all of the base names of the files
		$files = array_map('basename', File::files($images_path));

		$data = array(
			'ememb'=>$members,
			'files'=>$files,
			'ipath'=>$images_path
			);

		return View::make('members.show',$data);
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
		$memb = Member::find($id);
		$volunteers = Volunteer::all();
		return View::make('admin.members.edit')->withmemb($memb)->withVolunteers($volunteers);
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
			'jobTitle'      => 'required',
			'about' => 'required',
			//'email'    => 'email|Unique:members', // make sure the email is an actual email
			//'password' => 'required|alphaNum|min:5|Confirmed', //only alpha numeric and must be confirmed
			//'password_confirmation'=>'required|alphaNum|min:5' 
		);
		
		//Vaildating input from the post
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails())
		{
			return Redirect::route('admin.members.edit',$id)
				->withErrors($validator)
				->withInput(Input::except('images'));
		} 

		$memb = Member::find($id);
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
    			if($validator->passes()){

	        		$fid = Str::random(12);
	        		
	        		$destinationPath = Config::get('otherapp.images_path')."/images/$dir/";
			        $newFileName = "$fid";
			        $upload_success = $file->move($destinationPath, $newFileName);
			    }
			    else
				{
					$error = 'You can only upload png,gif,jpg, and jpeg';
					return Redirect::route('admin.members.edit',$id)
						->withErrors([$error])->withInput();
				}
			
			if( $upload_success )
			{
			
			/*
			* Password commented out as of now
			*/
				// store
				$memb->name      		= e(Input::get('name'));
				$memb->job_title   		= e(Input::get('jobTitle'));
				$memb->about 			= e(Input::get('about'));
				//$memb->email 			= e(Input::get('email'));
				//$memb->password 		= Hash::make(e(Input::get('password')));
				$memb->linkedin			= e(Input::get('linkedin'));
				$memb->twitter			= e(Input::get('twitter'));
				$memb->facebook			= e(Input::get('facebook'));
				$memb->instagram		= e(Input::get('instagram'));					
				$memb->photo_path	= "images/$dir/$newFileName";
				$memb->save();

				if(Auth::user()->isAdmin() && Input::get('admin'))
				{
					$memb->makeAdmin('admin');
				}
				else
				{
					$memb->roles()->detach();
				}
				
				Session::flash('message', "Successfully edited  $memb->name!");
				return Redirect::route('admin.members.index');
			}
			else
			{
				$error = "Failed to move the file. Contact the sysadmin $newFileName";
				return Redirect::route('admin.members.edit')
					->withErrors([$error])->withInput();
			}
		}
		else
		{
			$memb->name      		= e(Input::get('name'));
			$memb->job_title   		= e(Input::get('jobTitle'));
			$memb->about 			= e(Input::get('about'));
			//$memb->email 			= e(Input::get('email'));
			//$memb->password 		= Hash::make(e(Input::get('password')));
			$memb->linkedin			= e(Input::get('linkedin'));
			$memb->twitter			= e(Input::get('twitter'));
			$memb->facebook			= e(Input::get('facebook'));	
			$memb->instagram		= e(Input::get('instagram'));	
			$memb->save();

			if(Auth::user()->isAdmin() && Input::get('admin'))
			{
				$memb->makeAdmin('admin');
			}
			else
			{
				$memb->roles()->detach();
			}

			Session::flash('message', "Successfully edited  $memb->name!");
				return Redirect::route('admin.members.index');
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
		if(Auth::user()->isAdmin()){
			$memb = Member::find($id);
			$memb->delete();
			Session::flash('message', "Successfully deleted ememb #$id!");
				return Redirect::route('admin.members.index');
		}
		else
		{
			$error = "Must be Admin to do that";
				return Redirect::route('admin.members.index')->withErrors([$error]);
		}

	}

	public function saveOrder()
	{
		$input = Input::json();
		$order = 0;
		foreach (Input::get("data") as $something) {
			$memb = Member::find($something["id"]);
			$memb->order = $order++;
			$memb->save();
		}
		return Response::json(array("Ok" => "Ok"));
	}


}
