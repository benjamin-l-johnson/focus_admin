@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Editing Team Memeber
                    <small>{{{$memb->name}}}</small>
                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.members.index','members' ) }}
                    </li>
                    <li class="active">Editing {{{$memb->name}}}</li>
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

             
        {{ Form::model($memb,array('route' => array('admin.members.update', $memb->id), 'method' => 'PUT',
            'files' => true
        )) }}
                    <div class="form-group">    
                {{ Form::label('Name', 'Name:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('name', 'New members name',e($memb->name)) }}
            </div>

            <div class="form-group">    
                {{ Form::label('JobTitle', 'Job Title:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('jobTitle', 'Enter Job Title here',e($memb->job_title)) }}
            </div>

            <div class="form-group">    
                {{ Form::label('linkedin', 'Linkedin:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('linkedin', 'Enter linkedin url here',e($memb->linkedin)) }}
            </div>
            
            <div class="form-group">    
                {{ Form::label('JobTitle', 'Facebook:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('facebook', 'Enter Facebook url here',e($memb->facebook)) }}
            </div>

            <div class="form-group">    
                {{ Form::label('twitter', 'Twitter:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('twitter', 'Enter Twitter url here',e($memb->twitter)) }}
            </div>

            <div class="form-group">    
                {{ Form::label('instagram', 'Instagram:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('instagram', 'Enter Instagram url here',e($memb->instagram)) }}
            </div>

            <div class="form-group">
                {{ Form::label('about', 'About You:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('about',10, 'Put some information about your self here, it will show up when you click on your picture',e($memb->about)) }}
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