@extends('includes.header')

@section('content')

<div class="container">

<!--Pageheading-->
<h2>Reset Password</h2>
<hr>

        @if (isset($error))
        
            <div class="alert alert-danger" role="alert">
            
                
            
                    <li>{{{ $error }}}</li>        
               
            </div>
        @endif

    
        <div class="row">
            <div class="col-lg-12">
               
				<form action="{{ action('RemindersController@postRemind') }}" method="POST">
				    <input type="email" name="email">
				    <input type="submit" value="Send Reminder">
				</form>

			</div>
		</div>
</div>

@stop