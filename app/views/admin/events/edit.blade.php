@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit Event
                    <small>Subheading</small>
                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.events.index','events' ) }}
                    </li>
                    <li class="active">Edit</li>
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

             
        {{ Form::model($vent,array('route' => array('admin.events.update', $vent->id), 'method' => 'PUT',
            'files' => true
        )) }}
            
            <div class="form-group">    
                {{ Form::label('title', 'Title:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('title', 'use the Name of the event',$vent->title )}}
            </div>

            <div class="form-group">
                {{ Form::label('title', 'Read More:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('readMore','', 'NOTE! this can only be 120 characters long',$vent->read_more) }}
            </div>

            <div class="form-group">
                {{ Form::label('content', 'Content:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('content',10, 'Make this as long as you wish!',$vent->content) }}
            </div>

            <div class="form-group">
            {{ Form::label('volunteers', 'Volunteers that helped (check all that apply):') }}
            @foreach($volunteers as $volunteer)

               
                <div class="checkbox">
                <label>
                    {{ Form::checkbox("vID$volunteer->id", "$volunteer->id",($vent->volunteers->contains($volunteer->id) ? true : false) ); }}
                    {{{$volunteer->name}}}
                </label>
                </div>
            @endforeach

            </div>

            <div class="form-group">
                {{ Form::file('images[]',['multiple' => true]) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Submit', array('class'=>'btn')) }}
            </div>
        {{ Form::close() }}
        </form>

@stop