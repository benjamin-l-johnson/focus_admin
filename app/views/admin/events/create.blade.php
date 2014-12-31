@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Create new Event
                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.events.index','events' ) }}
                    </li>
                    <li class="active">Create New Event</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        {{--Display all errors--}}
        @if ($errors->has())
        
            <div class="alert alert-danger" role="alert">
            
                @foreach ($errors->all() as $error)
            
                    <li>{{ $error }}</li>        
            
                @endforeach
            </div>
        @endif

        <!--Begin Form-->


        {{ Form::open( array(
            'url' => 'admin/events',
            'files' => true,
            'class' => 'form-horizontal'

        )) }}
            
            <div class="form-group">    
                {{ Form::label('title', 'Title:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('title', 'use the Name of the event',Input::old('content')) }}
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
                {{ Form::label('volunteers', 'Volunteers that helped (check all that apply):') }}
                @foreach($volunteers as $volunteer)

               
                    <div class="checkbox">
                        <label>
                            {{ Form::checkbox("vID$volunteer->id", "$volunteer->id") }}
                            {{{$volunteer->name}}}
                        </label>
                    </div>
                @endforeach
            </div>


            <div class="form-group">
                {{ Form::label('images[]', 'Select Photos to upload:', array('class' => 'awesome')) }}
                {{ Form::file('images[]',['multiple' => true]) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Submit', array('class'=>'btn')) }}
            </div>
        {{ Form::close() }}
        </form>

@stop
