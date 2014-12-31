@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Create New Team Member
                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.members.index','members' ) }}
                    </li>
                    <li class="active">Create</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        @if ($errors->has())
        
            <div class="alert alert-danger" role="alert">
            
                @foreach ($errors->all() as $error)
            
                    <li>{{ $error }}</li>        
            
                @endforeach
            </div>
        @endif
        <!--Begin Form-->

             
        {{-- Form::model($vent, array('route' => array('admin.events.update', $vent->id))) --}}
        {{ Form::open( array(
            'route' => 'admin.members.store',
            'files' => true,
            'class' => 'form-horizontal'

        )) }}
            
            <div class="form-group">    
                {{ Form::label('Name', 'Name:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('name', 'New members name',Input::old('content')) }}
            </div>

            <div class="form-group">    
                {{ Form::label('JobTitle', 'Job Title:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('jobTitle', 'Enter Job Title here',Input::old('content')) }}
            </div>

            <div class="form-group">    
                {{ Form::label('email', 'Email:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('email', 'Enter email here',Input::old('content')) }}
            </div>
            
            <div class="form-group">    
                {{ Form::label('password', 'Password:', array('class' => 'awesome')) }}
                {{ Form::BSpass('password', 'Must be at least 6 characters') }}
            </div>

            <div class="form-group">    
                {{ Form::label('password_confirmation', 'Re-type password:', array('class' => 'awesome')) }}
                {{ Form::BSpass('password_confirmation', 'Make sure they match!') }}
            </div>

            <div class="form-group">    
                {{ Form::label('linkedin', 'Linkedin:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('linkedin', 'Enter linkedin url here',Input::old('content')) }}
            </div>
            
            <div class="form-group">    
                {{ Form::label('JobTitle', 'Facebook:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('facebook', 'Enter Facebook url here',Input::old('content')) }}
            </div>

            <div class="form-group">    
                {{ Form::label('twitter', 'Twitter:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('twitter', 'Enter Twitter url here',Input::old('content')) }}
            </div>

            <div class="form-group">
                {{ Form::label('about', 'About You:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('about',10, 'Put some information about your self here',Input::old('content')) }}
            </div>

            {{--Give them the ability to make admin users--}}
            @if(Auth::user()->isAdmin())
                <div class="form-group">  
                    <div class="btn-group" data-toggle="buttons">
                      <label class="btn btn-default">
                        <input type="radio" name="admin" id="option2"> Admin
                      </label>
                      <label class="btn btn-primary active">
                        <input type="radio" name="notAdmin" id="option1" checked> Not Admin
                      </label>
                    </div>
                </div>
            @endif


            <div class="form-group">
                {{ Form::file('image') }}
            </div>

            <div class="form-group">
                {{ Form::submit('Submit', array('class'=>'btn')) }}
            </div>
        {{ Form::close() }}
        </form>

@stop