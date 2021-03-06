@extends('admin.includes.header')

@section('content')

<div class="container">
<style type="text/css">
  body.dragging, body.dragging * {
  cursor: move !important;
}

.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}
</style>
      <!--Pageheading-->
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">Team
              <small>Subheading</small>
          </h1>
          <ol class="breadcrumb">
              <li><a href="/">Home</a>
              </li>
              <li class="active">Team</li>
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
   @if ($errors->has())
        
            <div class="alert alert-danger" role="alert">
            
                @foreach ($errors->all() as $error)
            
                    <li>{{ $error }}</li>        
            
                @endforeach
            </div>
        @endif

  <!--Table starting-->
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-info">
              <div class="panel-heading">
                  <h3 class="panel-title">Team Memebers</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-hover sorted_table">

                    <a href="{{ URL::route('admin.members.create') }}"
                      class="btn btn-success center-block"><i class="fa fa-plus fa-fw fa-lg"></i> Create 
                    </a>


                      
                      <thead>
                          <tr>
                              <th>Order</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>View</th>
                              <th>Edit</th>

                              {{--Only admin can delete--}}
                              @if(Auth::user()->isAdmin())
                                <th>Delete</th>
                              @endif
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($members as $member)
                          <tr data-id="{{$member->id}}" data-name="{{$member->name}}" data-order="{{$member->order}}">
                              <td>{{{$member->order}}}</td>
                              <td>{{{$member->name}}}</td>
                              <td>{{{$member->email}}}</td>
                              <td>
                                <a href="#"
                                class="btn btn-primary"><i class="fa fa-university fa-fw fa-lg"></i> View 
                                </a>
                              </td>
                              <td>
                                <a href="{{ URL::route('admin.members.edit', array($member->id)) }}"
                                class="btn btn-warning"><i class="fa fa-pencil fa-fw fa-lg"></i> Edit
                                </a>
                              </td>

                              @if(Auth::user()->isAdmin())
                              <td>
                              <a href="{{ route('admin.members.destroy',array($member->id)) }}" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this team member?" class="btn btn-danger"><i class="fa fa-trash-o fa-fw fa-lg"></i> Delete</a>                  
                                
                                </td>
                              @endif
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>
          </div>
       </div>
      </div>
  </div>
<hr>
                    <a href="#"
                      class="btn btn-primary center-block" id="save_order"><i class="fa fa-plus fa-fw fa-lg"></i>Save Order </a>

  {{$members->links()}}
  <hr>


@section('scripts')
<script type="text/javascript">
var group = $('.sorted_table').sortable({
        containerSelector: 'table',
        itemPath: '> tbody',
        itemSelector: 'tr',
        nested: 'false',
        placeholder: '<tr class="placeholder"/>',
        onDrop: function ($item, container, _super, event) {
          $item.removeClass("dragged").removeAttr("style")
          $("body").removeClass("dragging")
          
       }
    })

/*When we click the save order button, it will run our function!*/
$(function() {
      $("#save_order").click( function(e)
        {
          e.preventDefault();
          var data = group.sortable("serialize").get();
          var jsonString = {data:data[0]}
          
          console.log(jsonString)

          var pathname = window.location.pathname;

          //post the jsonString to the current route/order, on success refresh the page
          $.post(pathname.concat('/order'),jsonString,function()
            {
              location.reload();
            });
        }
      );
});

</script>
@stop