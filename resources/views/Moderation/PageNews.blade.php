@extends('layout.master')

@push('Style')
    <style>
        ul.timeline {
            list-style-type: none;
            position: relative;
        }
        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
        }
        ul.timeline > li {
            margin: 20px 0;
            padding-left: 20px;
        }
        ul.timeline > li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }
    </style>
@endpush


@section('content')


<div class="container-fluid mt-5 mb-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h4>Latest News</h4>
            <ul class="timeline">
                @foreach($ListNews as $ListNew)

                <li>
                    <a  href="{{ url('/OnePost/' . $ListNew['id'] . '/' . $ListNew['Lob_id'].'')}}">{{$ListNew['Header']}}</a>
                    <a href="{{ url('/OnePost/' . $ListNew['id'] . '/' . $ListNew['Lob_id'].'')}}" class="float-right">{{date('d M, Y',strtotime($ListNew['updated_at']))}}</a>
                    <p>{{$ListNew['body']}}</p>
                </li>
                    @endforeach
            </ul>
        </div>
    </div>
</div>


@endsection

@push('JavaScript')
@endpush
