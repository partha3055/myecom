@extends('admin/layout')
@section('page_title', 'Manage Category')
@section('category_select', 'active')
@section('container')
    <div style="visibility:hidden">
        @if ($id > 0)
            {{ $image_required = '' }}
        @else
            {{ $image_required = 'required' }}
        @endif
    </div>
    <h1 class="mb10">Manage Category</h1>
    <a href="{{ route('category') }}">
        <button type="button" class="btn btn-success">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('category.manage_category_process') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="parent_category_id" class="control-label mb-1">Parent Category</label>
                                    <select id="parent_category_id" name="parent_category_id" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false">
                                        <option value="0">Select Category</option>
                                        @foreach ($category as $list)
                                            @if ($parent_category_id == $list->id)
                                                <option selected value="{{ $list->id }}">
                                                @else
                                                <option value="{{ $list->id }}">
                                            @endif
                                            {{ $list->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category_name" class="control-label mb-1">Category Name</label>
                                    <input id="category_name" value="{{ $category_name }}" name="category_name"
                                        type="text" class="form-control" aria-required="true" aria-invalid="false"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                    <input id="category_slug" value="{{ $category_slug }}" name="category_slug"
                                        type="text" class="form-control" aria-required="true" aria-invalid="false"
                                        required>
                                    @error('category_slug')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category_image" class="control-label mb-1">Category Image</label>
                                    <input id="category_image" name="category_image" type="file" class="form-control"
                                        aria-required="true" aria-invalid="false" {{ $image_required }}>
                                    @error('category_image')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @if ($category_image != '')
                                        <a
                                            href="{{ asset('storage/upload/category_images/' . $category_image) }}"target="blank">
                                            <img width="50px"
                                                src="{{ asset('storage/upload/category_images/' . $category_image) }}"
                                                alt="">
                                        </a>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="is_home" class="control-label mb-1">Show in Home Page</label>
                                    <input id="is_home" name="is_home" type="checkbox" {{ $is_home_selected }}>
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        Submit
                                    </button>
                                </div>
                                <input type="hidden" name="id" value="{{ $id }}" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
