@extends('layout.master')

@push('Style')

@endpush

@section('content')

<div class="container">
    <div class="alert alert-success" style="display:none"></div>
    <form id="myForm" >
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name">
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price">
        </div>
        <button class="btn btn-primary" id="ajaxSubmit">Submit</button>
    </form>
</div>

@endsection

@push('JavaScript')
    <script>
        jQuery(document).ready(function(){
            jQuery('#ajaxSubmit').click(function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/grocery/post') }}",
                    method: 'post',
                    data: {
                        name: jQuery('#name').val(),
                        type: jQuery('#type').val(),
                        price: jQuery('#price').val()
                    },
                    success: function(result){
                        jQuery('.alert').show();
                        jQuery('.alert').html(result.success);
                    }});
            });
        });
    </script>
@endpush
