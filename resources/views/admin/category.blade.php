@extends('admin.layout')
@section('page_title', 'Category')
@section('category_select', 'active')
@section('container')
    @if (session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <h1 class="mb10">Category</h1>
    <a href="{{ route('manage_category') }}">
        <button type="button" class="btn btn-success">Add Category</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Category Name</th>
                            <th>Category Slug</th>
                            <th>Category Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $list)
                            <tr>
                                <td>{{ $list->id }}</td>
                                <td>{{ $list->category_name }}</td>
                                <td>{{ $list->category_slug }}</td>
                                @if ($list->category_image != '')
                                    <td><img width="50px"
                                            src="{{ asset('storage/upload/category_images/' . $list->category_image) }}"
                                            alt=""></td>
                                @endif
                                <td>
                                    <a href="{{ url('admin/category/manage_category/') }}/{{ $list->id }}"><button
                                            type="button" class="btn btn-success">Edit</button></a>
                                    @if ($list->status == 1)
                                        <a href="{{ url('admin/category/status/0') }}/{{ $list->id }}"><button
                                                type="button" class="btn btn-primary">Active</button></a>
                                    @elseif($list->status == 0)
                                        <a href="{{ url('admin/category/status/1') }}/{{ $list->id }}"><button
                                                type="button" class="btn btn-warning">Deactive</button></a>
                                    @endif
                                    <a href="{{ url('admin/category/delete/') }}/{{ $list->id }}"><button
                                            type="button" class="btn btn-danger">Delete</button></a>
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
