@extends('admin.includes.header')

@section('content')
<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Create new Volunteer
                </h1>
                <ol class="breadcrumb">
                    <li>{{ HTML::linkRoute('admin', 'Admin Portal') }}</li>
                    <li>{{ HTML::linkRoute('admin.volunteers.index','volunteers' ) }}
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
            'route' => 'admin.volunteers.store',
            'files' => true,
            'class' => 'form-horizontal'

        )) }}
            
            <div class="form-group">    
                {{ Form::label('Name', 'Name:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('name', 'New volunteers name',Input::old('content')) }}
            </div>


            <div class="form-group">    
                {{ Form::label('email', 'Email:', array('class' => 'awesome')) }}
                {{ Form::BStextIn('email', 'Enter email here',Input::old('content')) }}
            </div>
            
            <div class="form-group">    
                {{ Form::label('rank', 'Rank:', array('class' => 'awesome')) }}
                {{ Form::BSnumIn('rank', 'Enter rank here',Input::old('content')) }}
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
            </div>
            <hr>

            {{ Form::label('image', 'Select Photo to upload:', array('class' => 'awesome')) }}
            <div class="form-group">
                {{ Form::file('image') }}
            </div>

            <div class="form-group">
                {{ Form::submit('Submit', array('class'=>'btn')) }}
            </div>
        {{ Form::close() }}
        </form>

@stop