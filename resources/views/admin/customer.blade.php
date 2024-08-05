@extends('admin.layout')
@section('page_title', 'Customer')
@section('customer_select', 'active')
@section('container')
    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <h1 class="mb10">Customer</h1>
    <a href="{{ route('manage_customer') }}">
        <button type="button" class="btn btn-success">Add Customer</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $list)
                            <tr>
                                <td>{{ $list->id }}</td>
                                <td>{{ $list->name }}</td>
                                <td>{{ $list->email }}</td>
                                {{-- @if ($list->customer_image != '')
                                    <td><img width="50px"
                                            src="{{ asset('storage/upload/customer_images/' . $list->customer_image) }}"
                                            alt=""></td>
                                @endif --}}
                                <td>
                                    <a href="{{ url('admin/customer/manage_customer/') }}/{{ $list->id }}"><button
                                            type="button" class="btn btn-success">Show</button></a>
                                    @if ($list->status == 1)
                                        <a href="{{ url('admin/customer/status/0') }}/{{ $list->id }}"><button
                                                type="button" class="btn btn-primary">Active</button></a>
                                    @elseif($list->status == 0)
                                        <a href="{{ url('admin/customer/status/1') }}/{{ $list->id }}"><button
                                                type="button" class="btn btn-warning">Deactive</button></a>
                                    @endif
                                    {{-- <a href="{{ url('admin/customer/delete/') }}/{{ $list->id }}"><button
                                            type="button" class="btn btn-danger">Delete</button></a> --}}
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
