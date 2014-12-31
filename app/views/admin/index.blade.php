@extends('admin.includes.header')

@section('content')

<div class="container">

      <!--Pageheading-->
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Admin Page
          </h1>
          <ol class="breadcrumb">
              <li><a href="/">Home</a>
              </li>
              <li class="active">Admin</li>
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
                  <h3 class="panel-title">All Pages</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                      <thead>
                          <tr >
                              <th>Page</th>
                              <th>View</th>
                              <th>Edit</th>
                              <th>Create New</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                      <!--begin events-->
                        <tr>
                              <td>Events</td>
                              <td>
                                <a href="#"
                                class="btn btn-primary"><i class="fa fa-futbol-o fa-fw fa-lg"></i> View
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.events.index') }}"
                                class="btn btn-warning"><i class="fa fa-wrench fa-fw fa-lg"></i> Edit 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.events.create') }}"
                                class="btn btn-success"><i class="fa fa-plus fa-fw fa-lg"></i> Create 
                                </a>
                              </td>

                          </tr>
                        <!--/events -->

                        <!--begin students-->
                        <tr>
                              <td>Students</td>
                              <td>
                                <a href="#"
                                class="btn btn-primary"><i class="fa fa-futbol-o fa-fw fa-lg"></i> View 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.students.index') }}"
                                class="btn btn-warning"><i class="fa fa-wrench fa-fw fa-lg"></i> Edit 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.students.create') }}"
                                class="btn btn-success"><i class="fa fa-plus fa-fw fa-lg"></i> Create
                                </a>
                              </td>

                          </tr>
                        <!--/students -->

                        <!--begin nonprofits-->
                        <tr>
                            <td>Nonprofs</td>
                              <td>
                                <a href="#"
                                class="btn btn-primary"><i class="fa fa-futbol-o fa-fw fa-lg"></i> View 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.nonprofits.index') }}"
                                class="btn btn-warning"><i class="fa fa-wrench fa-fw fa-lg"></i> Edit 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.nonprofits.create') }}"
                                class="btn btn-success"><i class="fa fa-plus fa-fw fa-lg"></i> Create 
                                </a>
                              </td>

                          </tr>
                        <!--/nonprofits -->



                      <!--begin team-->
                        <tr>
                              <td>Team</td>
                              <td>
                                <a href="#"
                                class="btn btn-primary"><i class="fa fa-futbol-o fa-fw fa-lg"></i> View 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.members.index') }}"
                                class="btn btn-warning"><i class="fa fa-wrench fa-fw fa-lg"></i> Edit 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.members.create') }}"
                                class="btn btn-success"><i class="fa fa-plus fa-fw fa-lg"></i> Create 
                                </a>
                              </td>

                          </tr>
                        <!--/team -->


                        <!--begin Volunteers-->
                        <tr>
                          <td>Volunteers</td>
                              <td>
                                <a href="#"
                                class="btn btn-primary"><i class="fa fa-futbol-o fa-fw fa-lg"></i> View 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.volunteers.index') }}"
                                class="btn btn-warning"><i class="fa fa-wrench fa-fw fa-lg"></i> Edit 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.volunteers.create') }}"
                                class="btn btn-success"><i class="fa fa-plus fa-fw fa-lg"></i> Create 
                                </a>
                              </td>

                          </tr>
                        <!--/volunteers -->
                      </tbody>
                  </table>
                </div>
          </div>
       </div>
      </div>
  </div>
  <hr>
    
@stop