@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Editing Student
                    <small>{{{ $student->name}}}</small>
                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.students.index','Student orgs' ) }}
                    </li>
                    <li class="active">Editing {{{ $student->name}}}</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="col-lg-12">

        {{--Display all errors--}}
        @if ($errors->has())
        
            <div class="alert alert-danger" role="alert">
            
                @foreach ($errors->all() as $error)
            
                    <li>{{ $error }}</li>        
            
                @endforeach
            </div>
        @endif

        <!--Begin Form-->

             
        {{ Form::model($student,array('route' => array('admin.students.update', $student->id), 'method' => 'PUT',
            'files' => true
        )) }}
            
            <div class="form-group">    
                {{ Form::label('name', 'Name:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('name', 'use the Name of the student organization',$student->name )}}
            </div>

            <div class="form-group">
                {{ Form::label('title', 'Read More:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('readMore','', 'NOTE! this can only be 120 characters long',$student->read_more) }}
            </div>

            <div class="form-group">
                {{ Form::label('content', 'Content:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('content',10, 'Make this as long as you wish!',$student->content) }}
            </div>

            <div class="form-group">    
                {{ Form::label('rank', 'Rank:', array('class' => 'awesome')) }}
                {{ Form::BSnumIn('rank', 'Enter rank here (Higest number will be displayed first)',e($student->rank)) }}
            </div>
            

            <div class="form-group">
            
                {{ Form::label('Events', 'Events this group participated in:') }}
                <p class="help-block">Check all that apply.</p>
                    <div class="row">
                        @foreach($vents as $vent)

                           
                           <div class="col-sm-2">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox("vID$vent->id", "$vent->id",($student->vents->contains($vent->id) ? true : false) );}}
                                    {{{$vent->title}}}
                                </label>
                            </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr>

                <div class="form-group">
                    {{ Form::label('images[]', 'Select Photos to upload:', array('class' => 'awesome')) }}
                    <p class="help-block"> When selecting hold Ctrl and click to upload multipule photos.</p>
                    {{ Form::file('images[]',['multiple' => true]) }}

            </div>
            
            <hr>
            <div class="form-group">
                {{ Form::submit('Submit', array('class'=>'btn')) }}
            </div>
        {{ Form::close() }}
        </form>
    </div>

@stop