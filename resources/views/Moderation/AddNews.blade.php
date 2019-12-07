@extends('layout.master')

@push('Style')
    <style>

    </style>
@endpush


@section('content')

    <div class="container">
        <div class="alert alert-success" style="display:none"></div>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{session()->get('error')}}
            </div>
        @endif
        <div class="row">
            <br>
            <div class="col-md-12">
                <h2>Post News At {{$LOBSName[0]['Lob_name']}}</h2>
            </div>
            <br>
            <div class="col-md-12">
                <form id="myForm">
                    <div class="form-group">
                        <label for="header" style="color: #7c7c7d">Header :</label>
                        <input type="text" class="form-control" id="header" name="header" required>
                    </div>
                    <div class="form-group">
                        <label for="header" style="color: #7c7c7d">Body :</label>
                        <textarea class="form-control" name="body" id="body" required></textarea>
                    </div>
                    <input type="submit" id="Submit" class="btn btn-success btn-block" value="Post">
                </form>
            </div>
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"><a class="btn btn-success btn-sm" id="refresh">Refresh</a></th>
                        <th scope="col">Title</th>
                        <th scope="col">Body</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    @foreach($Posts as $Post)
                        <tr>
                            <th scope="row">{{$Post['id']}}</th>
                            <td>{{$Post['Header']}}</td>
                            <td>{{$Post['body']}}</td>
                            <td>{{date('Y-m-d H:i',strtotime($Post['created_at']))}}</td>
                            <td>{{date('Y-m-d H:i',strtotime($Post['updated_at']))}}</td>
                            <td><a  class="btn btn-primary" data-toggle="modal" data-target="#EditModal_{{$Post['id']}}">Edit</a></td>
                            <td><a  class="btn btn-danger" data-toggle="modal" data-target="#DeleteModal_{{$Post['id']}}">Delete</a></td>
                            <td></td>
                        </tr>
                        {{--    Edit Modal--}}
                        <div class="modal fade" id="EditModal_{{$Post['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Post</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('create.news.update')}}" method="post">
                                        <div class="modal-body">

                                            {!! csrf_field() !!}
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input  type="text" class="form-control" name="title" >
                                            </div>
                                            <div class="form-group">
                                                <label for="Body">Post Body</label>
                                                <textarea class="form-control" id="Body" name="Body"></textarea>
                                            </div>
                                            <input type="hidden" name="id_post" value="{{$Post['id']}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <input type="submit" class="btn btn-primary" value="Save Changes">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{--    End Edit Modal--}}

{{--                            Delete Modal--}}
                        <div class="modal fade" id="DeleteModal_{{$Post['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabe2" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabe2">Delete Post</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('create.news.Delete')}}" method="post">
                                        <div class="modal-body">
                                            <strong style="color: green">Are you want delete this post ?</strong>
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="id_post" value="{{$Post['id']}}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                            <input type="submit" class="btn btn-primary" value="Yes, Delete">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{--    End Delete Modal--}}
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>



@endsection

@push('JavaScript')
    <script>
        jQuery(document).ready(function(){
            jQuery('#Submit').click(function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ route('create.news.action',['id'=>$LOBSName[0]['id']])}}",
                    method: 'post',
                    data: {
                        name: jQuery('#header').val(),
                        body: jQuery('#body').val(),
                    },
                    success: function(result){
                        // console.log(result);
                        jQuery('.alert').show();
                        jQuery('.alert').html(result.success);
                        jQuery('#tableBody').append('<tr>' +
                            '<th scope="row">'+result.id+'</th>' +
                            '<td>'+result.Header+'</td>'+
                            '<td>'+result.body+'</td>'+
                            '<td>'+result.created_at+'</td>'+
                            '<td>'+result.updated_at+'</td>'+
                            '<td></td>'+
                            '<td></td>' +
                            '</tr>');
                    }});
            });
            jQuery('#refresh').click(function(e) {
                e.preventDefault();
                location.reload(true);
            });
        });
    </script>
@endpush








