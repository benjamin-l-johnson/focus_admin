@extends('admin.includes.header')

@section('content')

<div class="container">

      <!--Pageheading-->
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Students
              <small>Subheading</small>
          </h1>
          <ol class="breadcrumb">
              <li><a href="/">Home</a>
              </li>
              <li class="active">Students</li>
          </ol>
      </div>
  </div>
  <!--/Pageheading-->

  <hr>
  <!-- will be used to show any messages -->
  @if (Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert">
       <span aria-hidden="true">&times;</span>
       <span class="sr-only">Close</span>
     </button><strong>{{ Session::get('message') }}</strong>
    </div>
  @endif

  <!--Table starting-->
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-info">
              <div class="panel-heading">
                  <h3 class="panel-title">All Students</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-hover">

                    <a href="{{ URL::route('admin.students.create') }}"
                      class="btn btn-success center-block"><i class="fa fa-plus fa-fw fa-lg"></i> Create 
                    </a>
                      
                      <thead>
                          <tr>
                              <th>rank</th>
                              <th>Title</th>
                              <th>View</th>
                              <th>Edit</th>
                              <th>Delete</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($students as $student)
                          <tr>
                              <td>{{{$student->rank}}}</td>
                              <td>{{{$student->name}}}</td>

                              <td>
                                <a href="#"
                                class="btn btn-primary"><i class="fa fa-university fa-fw fa-lg"></i> View 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.students.edit', array($student->id)) }}"
                                class="btn btn-warning"><i class="fa fa-pencil fa-fw fa-lg"></i> Edit
                                </a>
                              </td>

                              <td>
                              <a href="{{ route('admin.students.destroy',array($student->id)) }}" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?" class="btn btn-danger"><i class="fa fa-trash-o fa-fw fa-lg"></i> Delete</a>                  
                                
                                </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>
          </div>
       </div>
      </div>
  </div>
  {{$students->links()}}
  <hr>
    
@stop