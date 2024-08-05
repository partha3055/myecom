@extends('admin.layout')
@section('page_title', 'Brand')
@section('brand_select', 'active')
@section('container')
    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <h1 class="mb10">Brand</h1>
    <a href="{{ route('manage_brand') }}">
        <button type="button" class="btn btn-success">Add Brand</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Brand</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $list)
                            <tr>
                                <td>{{ $list->id }}</td>
                                <td>{{ $list->brand }}</td>
                                @if ($list->image != '')
                                    <td>
                                        <a href="{{ asset('storage/upload/brand_images/' . $list->image) }}"target="blank">
                                            <img width="50px"
                                                src="{{ asset('storage/upload/brand_images/' . $list->image) }}"
                                                alt="">
                                        </a>
                                    </td>
                                @endif
                                <td>
                                    <a href="{{ url('admin/brand/manage_brand/') }}/{{ $list->id }}"><button
                                            type="button" class="btn btn-success">Edit</button></a>
                                    @if ($list->status == 1)
                                        <a href="{{ url('admin/brand/status/0') }}/{{ $list->id }}"><button
                                                type="button" class="btn btn-primary">Active</button></a>
                                    @elseif($list->status == 0)
                                        <a href="{{ url('admin/brand/status/1') }}/{{ $list->id }}"><button
                                                type="button" class="btn btn-warning">Deactive</button></a>
                                    @endif
                                    <a href="{{ url('admin/brand/delete/') }}/{{ $list->id }}"><button type="button"
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
