@extends('admin/layout')
@section('page_brand', 'Manage Home Banner')
@section('homebanner_select', 'active')
@section('container')
    <div style="visibility:hidden">
        @if ($id > 0)
            {{ $image_required = '' }}
        @else
            {{ $image_required = 'required' }}
        @endif
    </div>
    @error('image')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror
    <h1 class="mb10">Manage Home Banner</h1>
    <a href="{{ route('homebanner') }}">
        <button type="button" class="btn btn-success">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('homebanner.manage_homebanner_process') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="btn_text" class="control-label mb-1">Button Text</label>
                                    <input id="btn_text" value="{{ $btn_text }}" name="btn_text" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                                <div class="form-group">
                                    <label for="btn_link" class="control-label mb-1">Button Link</label>
                                    <input id="btn_link" value="{{ $btn_link }}" name="btn_link" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false">
                                </div>
                                <div class="form-group">
                                    <label for="image" class="control-label mb-1">Image</label>
                                    <input id="image" name="image" type="file" class="form-control"
                                        aria-required="true" aria-invalid="false" {{ $image_required }}>
                                    @error('image')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @if ($image != '')
                                        <a href="{{ asset('storage/upload/homebanner_images/' . $image) }}"target="blank">
                                            <img width="50px"
                                                src="{{ asset('storage/upload/homebanner_images/' . $image) }}"
                                                alt="">
                                        </a>
                                    @endif
                                </div>
                                {{-- <div class="form-group">
                                    <label for="is_home" class="control-label mb-1">Show in Home Page</label>
                                    <input id="is_home" name="is_home" type="checkbox" {{ $is_home_selected }}>
                                </div> --}}
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
