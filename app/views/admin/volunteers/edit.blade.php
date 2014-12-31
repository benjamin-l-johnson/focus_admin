@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Editing Volunteer  
                    <small>{{{$vol->name}}}</small>
                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.volunteers.index','volunteers' ) }}
                    </li>
                    <li class="active">Editing {{{$vol->name}}} </li>
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

             
        {{ Form::model($vol,array('route' => array('admin.volunteers.update', $vol->id), 'method' => 'PUT',
            'files' => true
        )) }}
                    <div class="form-group">    
                {{ Form::label('Name', 'Name:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('name', 'New members name',e($vol->name)) }}
            </div>
            <div class="form-group">    
                {{ Form::label('email', 'Email:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('email', 'Enter email here',e($vol->email)) }}
            </div>
            <div class="form-group">    
                {{ Form::label('rank', 'Rank:', array('class' => 'awesome')) }}
                {{ Form::BSnumIn('rank', 'Enter rank here',e($vol->rank)) }}
            </div>


            <div class="form-group">
            {{ Form::label('volunteers', 'Volunteers that helped (check all that apply):') }}
            @foreach($vents as $vent)

               
                <div class="checkbox">
                <label>
                    {{ Form::checkbox("vID$vent->id", "$vent->id",($vent->volunteers->contains($vol->id) ? true : false) ); }}
                    {{{$vent->title}}}
                </label>
                </div>
            @endforeach

            </div>

            
            <div class="form-group">
                {{ Form::file('image') }}
            </div>

            <div class="form-group">
                {{ Form::submit('Submit', array('class'=>'btn')) }}
            </div>
        {{ Form::close() }}
        </form>

@stop