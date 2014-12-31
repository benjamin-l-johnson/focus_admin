@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Editing Nonprofit 
                    <small>{{{$nonprof->name}}}</small>

                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.nonprofits.index','Nonprofits' ) }}
                    </li>
                    <li class="active">Edit</li>
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

             
        {{ Form::model($nonprof,array('route' => array('admin.nonprofits.update', $nonprof->id), 'method' => 'PUT',
            'files' => true
        )) }}
            
            <div class="form-group">    
                {{ Form::label('name', 'Name:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('name', 'use the Name of the event',$nonprof->name )}}
            </div>

            <div class="form-group">
                {{ Form::label('name', 'Read More:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('readMore','', 'NOTE! this can only be 120 characters long',$nonprof->read_more) }}
            </div>

            <div class="form-group">
                {{ Form::label('content', 'Content:', array('class' => 'awesome')) }}
                {{ Form::BStextArea('content',10, 'Make this as long as you wish!',$nonprof->content) }}
            </div>
            
            <div class="form-group">
            
                {{ Form::label('Events', 'Events this group participated in:') }}
                <p class="help-block">Check all that apply.</p>
                    <div class="row">
                        @foreach($vents as $vent)

                           
                           <div class="col-sm-2">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox("vID$vent->id", "$vent->id",($nonprof->vents->contains($vent->id) ? true : false) );}}
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