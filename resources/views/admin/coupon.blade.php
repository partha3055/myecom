@extends('admin.layout')
@section('page_title', 'Coupon')
@section('coupon_select', 'active')
@section('container')
    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <h1 class="mb10">Coupon</h1>
    <a href="{{ route('manage_coupon') }}">
        <button type="button" class="btn btn-success">Add Coupon</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Coupon Title</th>
                            <th>Coupon Code</th>
                            <th>Coupon Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $list)
                            <tr>
                                <td>{{ $list->id }}</td>
                                <td>{{ $list->title }}</td>
                                <td>{{ $list->code }}</td>
                                <td>{{ $list->value }}</td>
                                <td>
                                    <a href="{{ url('admin/coupon/manage_coupon/') }}/{{ $list->id }}"><button
                                            type="button" class="btn btn-success">Edit</button></a>
                                    @if ($list->status == 1)
                                        <a href="{{ url('admin/coupon/status/0') }}/{{ $list->id }}"><button
                                                type="button" class="btn btn-primary">Active</button></a>
                                    @elseif($list->status == 0)
                                        <a href="{{ url('admin/coupon/status/1') }}/{{ $list->id }}"><button
                                                type="button" class="btn btn-warning">Deactive</button></a>
                                    @endif
                                    <a href="{{ url('admin/coupon/delete/') }}/{{ $list->id }}"><button type="button"
                                            class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
@endsection
