@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Create New Student Group
                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.students.index','Student orgs' ) }}
                    </li>
                    <li class="active">Create New Student Group</li>
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

             
        {{-- Form::model($vent, array('route' => array('admin.events.update', $vent->id))) --}}
        {{ Form::open( array(
            'url' => 'admin/students',
            'files' => true,
            'class' => 'form'

        )) }}
            
            <div class="form-group">    
                {{ Form::label('name', 'Name:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('name', 'use the Name of the Student orginzation',Input::old('content')) }}
            </div>

            <div class="form-group">
                {{ Form::label('title', 'Read More:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('readMore','', 'NOTE! this can only be 120 characters long',Input::old('content')) }}
            </div>

            <div class="form-group">
                {{ Form::label('content', 'Content:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('content',10, 'Make this as long as you wish!',Input::old('content')) }}
            </div>
            
            <div class="form-group">    
                {{ Form::label('detail1', 'Detail 1:') }}
                {{ Form::BStextIn('detail1', 'Enter a detail about the group',Input::old('content')) }}
            </div>

            
            <div class="form-group">
            
            {{ Form::label('Events', 'Events this group participated in:') }}
            <p class="help-block">Check all that apply.</p>
                <div class="row">
                    @foreach($vents as $vent)

                       
                       <div class="col-sm-2">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox("vID$vent->id", "$vent->id")}}
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
