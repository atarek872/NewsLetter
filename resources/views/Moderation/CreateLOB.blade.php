@extends('layout.master')

@push('Style')
    <style>

    </style>
@endpush


@section('content')

    <div class="container-fluid p-3 mb-2 bg-light text-white">

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

            <div class="col-md-5">
                <form id="myForm">
                    <div class="form-group">
                        <label for="name" style="color: #7c7c7d">LOB Name :</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="Description" style="color: #7c7c7d">Description :</label>
                        <textarea class="form-control" name="Description" id="Description"  cols="30" rows="10"required></textarea>
                    </div>

                    <input type="submit" id="Submit" class="btn btn-success " value="Create New">
                </form>
            </div>
                <div class="offset-md-1 col-md-6" style="margin-top: 30px;">

                        <ul class="list-group" id="list">
                            @foreach($LOBS as $LOB)

                            <li class="list-group-item list-group-item-secondary">
                                    <a href="{{route('create.news',['id'=>$LOB['id']])}}" style="color:#7c7c7d;text-decoration: none">{{$LOB['Lob_name']}}</a>
                                <span style="float: right">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#EditModal_{{$LOB['id']}}" >Edit</a>
                                <a class="btn btn-danger" data-toggle="modal" data-target="#DeleteModal_{{$LOB['id']}}">Delete</a>
                                </span>
                            </li>

{{--                                Edit MOdal--}}

                                <div class="modal fade" id="EditModal_{{$LOB['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color: #1d68a7;font-weight: bolder">Edit LOB</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('create.lob.update')}}" method="post" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="name" style="color: #7c7c7d">LOB Name :</label>
                                                        <input type="text" class="form-control" id="name" name="name" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Description" style="color: #7c7c7d">Description :</label>
                                                        <textarea class="form-control" name="Description" id="Description"  cols="30" rows="10"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image" style="color: #7c7c7d">Upload Logo Image :</label>
                                                        <input type="file" class="form-control" name="image" >
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="{{$LOB['id']}}" name="ID">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <input  type="submit" class="btn btn-primary" value="Save changes">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
{{--                                Delete Modal--}}
                                <div class="modal fade" id="DeleteModal_{{$LOB['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel" style="color: #1d68a7;font-weight: bolder">Delete LOB</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('create.lob.delete')}}" method="post">
                                                @csrf
                                                <div class="modal-body" style="color: #7c7c7d">
                                                    Are You Sure ?
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="{{$LOB['id']}}" name="ID">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                    <input type="submit" class="btn btn-danger" value="Yes">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </ul>

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
                    url: "{{ route('create.lob.action')}}",
                    method: 'post',
                    data: {
                        name: jQuery('#name').val(),
                        Description: jQuery('#Description').val(),
                    },
                    success: function(result){
                        jQuery('.alert').show();
                        jQuery('.alert').html(result.success);
                        jQuery('#list').append('<li class="list-group-item list-group-item-secondary">'+
                            '<a href="/Create_News/'+result.id+'" style="color:#7c7c7d;text-decoration: none">'+result.name+'</a>' +
                            '<span style="float: right">' +
                            '<a href="" class="btn btn-primary btn-sm" >Edit</a>' +
                            '<a href="" class="btn btn-danger btn-sm">Delete</a>' +
                            '</span>' +
                            '</li>');
                    }});
            });
        });
    </script>
@endpush

