@extends('layout.master')
@section('title', 'PGN SHARE | Log Approval')
@section('content')
    <style>
        .model-huruf-family {
            font-family: "Trebuchet MS", Verdana, sans-serif;
        }

        .scroll-wbs {
            max-height: 1000px;
            overflow-y: auto;
        }

        .scroll-log {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>

    <div class="container">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="model-huruf-family font-weight-bold">LOG APPROVAL
                    <br>
                    <small class="text-danger">{{ "#".$id }}</small>
                </h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Realisasi CSR 517</li>
                        <li class="breadcrumb-item active">Log Approval</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="comment-widgets m-b-20 scroll-wbs">
                        @foreach($dataLog as $data)
                            <div class="d-flex flex-row comment-row">
                                <div class="p-2"><span class="round"><img
                                                src="{{ asset('template/assets/images/user.png') }}" alt="user"
                                                width="50"></span></div>
                                <div class="comment-text w-100">
                                    <h5 class="model-huruf-family font-weight-bold">{{ $data['user_name'] }}</h5>
                                    <div class="comment-footer">
                                        @if($data['status'] == 'DRAFT')
                                            <span class="badge text-dark"
                                                  style="background-color: #FFA900">{{ $data['status'] }}</span>
                                        @elseif($data['status'] == 'IN PROGRESS')
                                            <span class="badge text-white"
                                                  style="background-color: #1dc4e9">{{ $data['status'] }}</span>
                                        @elseif($data['status'] == 'PAID')
                                            <span class="badge text-white"
                                                  style="background-color: #1de9b6">{{ $data['status'] }}</span>
                                        @elseif($data['status'] == 'RELEASED')
                                            <span class="badge text-white"
                                                  style="background-color: #B23CFD">{{ $data['status'] }}</span>
                                        @elseif($data['status'] == 'REJECTED')
                                            <span class="badge text-white"
                                                  style="background-color: #f44236">{{ $data['status'] }}</span>
                                        @elseif($data['status'] == 'READY TO RELEASE')
                                            <span class="badge text-white"
                                                  style="background-color: #00B74A">{{ $data['status'] }}</span>
                                        @else
                                            <span class="badge badge-info">{{ $data['status'] }}</span>
                                        @endif
                                        <br>
                                        <small class="date">Task Date: {{ date('d-m-Y H:i:s', strtotime($data['created_at'])) }}</small>
                                        <br>
                                        <small class="date">Action Date: {{ date('d-m-Y H:i:s', strtotime($data['action_date'])) }}</small>
                                    </div>
                                    <p class="m-b-5 m-t-10" style="text-align: justify">{{ $data['note'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

@stop