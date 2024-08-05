@extends('admin/layout')
@section('page_brand', 'Manage Brand')
@section('brand_select', 'active')
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
    <h1 class="mb10">Manage Brand</h1>
    <a href="{{ route('brand') }}">
        <button type="button" class="btn btn-success">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('brand.manage_brand_process') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="brand" class="control-label mb-1">Brand</label>
                                    <input id="brand" value="{{ $brand }}" name="brand" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('brand')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bimage" class="control-label mb-1">Image</label>
                                    <input id="bimage" name="bimage" type="file" class="form-control"
                                        aria-required="true" aria-invalid="false" {{ $image_required }}>
                                    @error('bimage')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @if ($bimage != '')
                                        <a href="{{ asset('storage/upload/brand_images/' . $bimage) }}"target="blank">
                                            <img width="50px" src="{{ asset('storage/upload/brand_images/' . $bimage) }}"
                                                alt="">
                                        </a>
                                    @endif
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
