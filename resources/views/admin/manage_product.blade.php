@extends('admin/layout')
@section('page_title', 'Manage Product')
@section('product_select', 'active')
@section('container')
    <div style="visibility:hidden">
        @if ($id > 0)
            {{ $image_required = '' }}
        @else
            {{ $image_required = 'required' }}
        @endif
    </div>
    <h1 class="mb10">Manage Product</h1>
    @if (session()->has('sku_error'))
        <div class="alert alert-danger" role="alert">
            {{ session('sku_error') }}
        </div>
    @endif
    @error('attr_image.*')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror
    @error('image.*')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror
    <a href="{{ route('product') }}">
        <button type="button" class="btn btn-success">Back</button>
    </a>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <div class="row m-t-30">
        <div class="col-md-12">
            <form action="{{ route('product.manage_product_process') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name" class="control-label mb-1">Product Name</label>
                                    <input id="name" value="{{ $name }}" name="name" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required>
                                </div>
                                <div class="form-group">
                                    <label for="slug" class="control-label mb-1">Product Slug</label>
                                    <input id="slug" value="{{ $slug }}" name="slug" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('slug')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="category_id" class="control-label mb-1">Category</label>
                                            <select id="category_id" name="category_id" type="text" class="form-control"
                                                aria-required="true" aria-invalid="false" required>
                                                <option value="">Select Category</option>
                                                @foreach ($category as $list)
                                                    @if ($category_id == $list->id)
                                                        <option selected value="{{ $list->id }}">
                                                        @else
                                                        <option value="{{ $list->id }}">
                                                    @endif
                                                    {{ $list->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <label for="brand" class="control-label mb-1">Brand</label>
                                            <input id="brand" value="{{ $brand }}" name="brand" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false" required>
                                        </div> --}}
                                        <div class="col-md-4">
                                            <label for="brand" class="control-label mb-1">Brand</label>
                                            <select id="brand_id" name="brand_id" type="text" class="form-control"
                                                aria-required="true" aria-invalid="false" required>
                                                <option value="">Select Brand</option>
                                                @foreach ($brand as $list)
                                                    @if ($brand_id == $list->id)
                                                        <option selected value="{{ $list->id }}">
                                                        @else
                                                        <option value="{{ $list->id }}">
                                                    @endif
                                                    {{ $list->brand }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="model" class="control-label mb-1">Model</label>
                                            <input id="model" value="{{ $model }}" name="model" type="text"
                                                class="form-control" aria-required="true" aria-invalid="false" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="short_desc" class="control-label mb-1">Short Description</label>
                                    <textarea id="short_desc" name="short_desc" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" required>{{ $short_desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="desc" class="control-label mb-1">Description</label>
                                    <textarea id="desc" name="desc" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                        required>{{ $desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="keywords" class="control-label mb-1">Keywords</label>
                                    <textarea id="keywords" name="keywords" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" required>{{ $keywords }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="technical_specification" class="control-label mb-1">Technical
                                        Specification</label>
                                    <textarea id="technical_specification" name="technical_specification" type="text" class="form-control"
                                        aria-required="true" aria-invalid="false" required>{{ $technical_specification }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="uses" class="control-label mb-1">Uses</label>
                                    <textarea id="uses" name="uses" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" required>{{ $uses }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="warranty" class="control-label mb-1">Warranty</label>
                                    <input id="warranty" value="{{ $warranty }}" name="warranty" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="lead_time" class="control-label mb-1">Lead Time</label>
                                            <input id="lead_time" value="{{ $lead_time }}" name="lead_time"
                                                type="text" class="form-control" aria-required="true"
                                                aria-invalid="false" required>
                                        </div>
                                        <div class="col-md-8">
                                            <label for="tax_id" class="control-label mb-1">Tax</label>
                                            <select id="tax_id" name="tax_id" type="text" class="form-control"
                                                aria-required="true" aria-invalid="false" required>
                                                <option value="">Select Tax</option>
                                                @foreach ($tax as $list)
                                                    @if ($tax_id == $list->id)
                                                        <option selected value="{{ $list->id }}">
                                                        @else
                                                        <option value="{{ $list->id }}">
                                                    @endif
                                                    {{ $list->tax_desc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">Promo</label>
                                                </div>
                                                <div class="col col-md-9">
                                                    @if ($is_promo == '1')
                                                        <div class="form-check">
                                                            <div class="radio">
                                                                <label for="is_promo1" class="form-check-label ">
                                                                    <input type="radio" id="is_promo1" name="is_promo"
                                                                        value="1" class="form-check-input"
                                                                        checked>Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label for="is_promo2" class="form-check-label ">
                                                                    <input type="radio" id="is_promo2" name="is_promo"
                                                                        value="0" class="form-check-input">No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-check">
                                                            <div class="radio">
                                                                <label for="is_promo1" class="form-check-label ">
                                                                    <input type="radio" id="is_promo1" name="is_promo"
                                                                        value="1" class="form-check-input">Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label for="is_promo2" class="form-check-label ">
                                                                    <input type="radio" id="is_promo2" name="is_promo"
                                                                        value="0" class="form-check-input" checked>No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">Featured</label>
                                                </div>
                                                <div class="col col-md-9">
                                                    @if ($is_featured == '1')
                                                        <div class="form-check">
                                                            <div class="radio">
                                                                <label for="is_featured1" class="form-check-label ">
                                                                    <input type="radio" id="is_featured1"
                                                                        name="is_featured" value="1"
                                                                        class="form-check-input" checked>Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label for="is_featured2" class="form-check-label ">
                                                                    <input type="radio" id="is_featured2"
                                                                        name="is_featured" value="0"
                                                                        class="form-check-input">No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-check">
                                                            <div class="radio">
                                                                <label for="is_featured1" class="form-check-label ">
                                                                    <input type="radio" id="is_featured1"
                                                                        name="is_featured" value="1"
                                                                        class="form-check-input">Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label for="is_featured2" class="form-check-label ">
                                                                    <input type="radio" id="is_featured2"
                                                                        name="is_featured" value="0"
                                                                        class="form-check-input"checked>No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">Discounted</label>
                                                </div>
                                                <div class="col col-md-9">
                                                    @if ($is_discounted == '1')
                                                        <div class="form-check">
                                                            <div class="radio">
                                                                <label for="is_discounted1" class="form-check-label ">
                                                                    <input type="radio" id="is_discounted1"
                                                                        name="is_discounted" value="1"
                                                                        class="form-check-input" checked>Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label for="is_discounted2" class="form-check-label ">
                                                                    <input type="radio" id="is_discounted2"
                                                                        name="is_discounted" value="0"
                                                                        class="form-check-input">No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-check">
                                                            <div class="radio">
                                                                <label for="is_discounted1" class="form-check-label ">
                                                                    <input type="radio" id="is_discounted1"
                                                                        name="is_discounted" value="1"
                                                                        class="form-check-input">Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label for="is_discounted2" class="form-check-label ">
                                                                    <input type="radio" id="is_discounted2"
                                                                        name="is_discounted" value="0"
                                                                        class="form-check-input"checked>No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">Tranding</label>
                                                </div>
                                                <div class="col col-md-9">
                                                    @if ($is_tranding == '1')
                                                        <div class="form-check">
                                                            <div class="radio">
                                                                <label for="is_tranding1" class="form-check-label ">
                                                                    <input type="radio" id="is_tranding1"
                                                                        name="is_tranding" value="1"
                                                                        class="form-check-input" checked>Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label for="is_tranding2" class="form-check-label ">
                                                                    <input type="radio" id="is_tranding2"
                                                                        name="is_tranding" value="0"
                                                                        class="form-check-input">No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-check">
                                                            <div class="radio">
                                                                <label for="is_tranding1" class="form-check-label ">
                                                                    <input type="radio" id="is_tranding1"
                                                                        name="is_tranding" value="1"
                                                                        class="form-check-input">Yes
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label for="is_tranding2" class="form-check-label ">
                                                                    <input type="radio" id="is_tranding2"
                                                                        name="is_tranding" value="0"
                                                                        class="form-check-input"checked>No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        {{-- <input type="text" value="{{ $image }}"> --}}
                                        <a href="{{ asset('storage/upload/Product_Image/' . $image) }}" target="blank">
                                            <img width="50px"
                                                src="{{ asset('storage/upload/Product_Image/' . $image) }}"
                                                alt=""></td>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h3 class="mb10">Product Images</h3>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row" id="product_image_box">
                                        @php
                                            $loop_count_num = 1;
                                        @endphp
                                        @foreach ($ProductImages as $key => $val)
                                            @php
                                                $loop_count_prev = $loop_count_num;
                                                $pImages = (array) $val;
                                            @endphp
                                            <input id="pimages_id" type="hidden" value="{{ $pImages['id'] }}"
                                                name="pimages_id[]">
                                            <div class="col-md-4 product_images_{{ $loop_count_num++ }}">
                                                <label for="images" class="control-label mb-1">Image</label>
                                                <input id="images" name="images[]" type="file"
                                                    class="form-control" aria-required="true" aria-invalid="false">
                                                @error('images')
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                @if ($pImages['image'] != '')
                                                    <a href="{{ asset('storage/upload/product_images/' . $pImages['image']) }}"
                                                        target="blank"><img
                                                            width="50px"src="{{ asset('storage/upload/product_images/' . $pImages['image']) }}"
                                                            alt="">
                                                    </a>
                                                @endif
                                            </div>
                                            @if ($loop_count_num == 2)
                                                <div class="col-md-2">
                                                    <label for="image" class="control-label mb-1"></label>
                                                    <button type="button" class="btn btn-success btn-lg"
                                                        onclick="add_image_more()">
                                                        <i class="fa fa-plus"></i>&nbsp; Add</button>
                                                </div>
                                            @else
                                                <div class="col-md-2">
                                                    <a
                                                        href="{{ url('admin/product/product_images/delete/') }}/{{ $pImages['id'] }}/{{ $id }}">
                                                        <button type="button" class="btn btn-danger btn-lg remove"
                                                            onclick="remove_more_image({{ $loop_count_prev }})">
                                                            <i class="fa fa-minus"></i>&nbsp; Remove
                                                        </button>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" id="product_attr_box">
                        <h3 class="mb10">Product Attributes</h3>
                        @php
                            $loop_count_num = 1;
                        @endphp
                        @foreach ($ProductAttrArr as $key => $val)
                            @php
                                $loop_count_prev = $loop_count_num;
                                $pArr = (array) $val;
                            @endphp
                            <input id="pattr_id" type="hidden" value="{{ $pArr['id'] }}" name="pattr_id[]">
                            <div class="card" id="product_attr_{{ $loop_count_num++ }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="sku" class="control-label mb-1">SKU</label>
                                                <input id="sku" value="{{ $pArr['sku'] }}" name="sku[]"
                                                    type="text" class="form-control" aria-required="true"
                                                    aria-invalid="false" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="mrp" class="control-label mb-1">MRP</label>
                                                <input id="mrp" value="{{ $pArr['mrp'] }}" name="mrp[]"
                                                    type="text" class="form-control" aria-required="true"
                                                    aria-invalid="false" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="price" class="control-label mb-1">Price</label>
                                                <input id="price" value="{{ $pArr['price'] }}" name="price[]"
                                                    type="text" class="form-control" aria-required="true"
                                                    aria-invalid="false" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="size_id" class="control-label mb-1">Size</label>
                                                <select id="size_id" name="size_id[]" type="text"
                                                    class="form-control" aria-required="true" aria-invalid="false"
                                                    required>
                                                    <option value="">Select Size</option>
                                                    @foreach ($size as $list)
                                                        @if ($pArr['size_id'] == $list->id)
                                                            <option selected value="{{ $list->id }}">
                                                            @else
                                                            <option value="{{ $list->id }}">
                                                        @endif
                                                        {{ $list->size }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="color_id" class="control-label mb-1">Color</label>
                                                <select id="color_id" name="color_id[]" type="text"
                                                    class="form-control" aria-required="true" aria-invalid="false"
                                                    required>
                                                    <option value="">Select Color</option>
                                                    @foreach ($color as $list)
                                                        @if ($pArr['color_id'] == $list->id)
                                                            <option selected value="{{ $list->id }}">
                                                            @else
                                                            <option value="{{ $list->id }}">
                                                        @endif
                                                        {{ $list->color }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="qty" class="control-label mb-1">Qty</label>
                                                <input id="qty" value="{{ $pArr['qty'] }}" name="qty[]"
                                                    type="text" class="form-control" aria-required="true"
                                                    aria-invalid="false" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="attr_image" class="control-label mb-1">Image</label>
                                                <input id="attr_image" name="attr_image[]" type="file"
                                                    class="form-control" aria-required="true" aria-invalid="false">
                                                @error('attr_image')
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                @if ($pArr['attr_image'] != '')
                                                    <a
                                                        href="{{ asset('storage/upload/product_attribute_images/' . $pArr['attr_image']) }}"target="blank">
                                                        <img width="50px"
                                                            src="{{ asset('storage/upload/product_attribute_images/' . $pArr['attr_image']) }}"
                                                            alt="">
                                                    </a>
                                                @endif
                                            </div>
                                            @if ($loop_count_num == 2)
                                                <div class="col-md-2">
                                                    <label for="attr_image" class="control-label mb-1"></label>
                                                    <button type="button" class="btn btn-success btn-lg"
                                                        onclick="add_more()">
                                                        <i class="fa fa-plus"></i>&nbsp; Add</button>
                                                </div>
                                            @else
                                                <div class="col-md-2">
                                                    <a
                                                        href="{{ url('admin/product/product_attr/delete/') }}/{{ $pArr['id'] }}/{{ $id }}">
                                                        <button type="button" class="btn btn-danger btn-lg remove"
                                                            onclick="remove_more({{ $loop_count_prev }})">
                                                            <i class="fa fa-minus"></i>&nbsp; Remove
                                                        </button>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                        Submit
                    </button>
                    <input type="hidden" name="id" value="{{ $id }}" />
                </div>
            </form>
        </div>
    </div>
    <script>
        var loop_count = 1;

        function add_more() {
            //alert('hello');
            loop_count++;
            var html = '<input id="pattr_id" type="hidden" name="pattr_id[]"><div class="card" id="product_attr_' +
                loop_count +
                '"><div class="card-body"><div class="form-group"><div class="row">';
            html +=
                '<div class="col-md-3"><label for="sku" class="control-label mb-1">SKU</label><input id="sku" value="" name="sku[]" type="text"class="form-control" aria-required="true" aria-invalid="false" required></div>';
            html +=
                '<div class="col-md-3"><label for="mrp" class="control-label mb-1">MRP</label><input id="mrp" value="" name="mrp[]" type="text"class="form-control" aria-required="true" aria-invalid="false" required></div>';
            html +=
                '<div class="col-md-3"><label for="price" class="control-label mb-1">Price</label><input id="price" value="" name="price[]" type="text"class="form-control" aria-required="true" aria-invalid="false" required></div>';
            // html +=
            //     '<div class="col-md-3"><label for="size_id" class="control-label mb-1">Size</label><select id="size_id" name="size_id" type="text" class="form-control"aria-required="true" aria-invalid="false" required><option value="">Select Size</option>@foreach ($size as $list)<option value="{{ $list->id }}">{{ $list->size }}</option>@endforeach</select></div>';
            var size_id_html = jQuery('#size_id').html();
            size_id_html = size_id_html.replace("selected", "");
            html +=
                '<div class="col-md-3"><label for="size_id" class="control-label mb-1">Size</label><select id="size_id" name="size_id[]" type="text" class="form-control"aria-required="true" aria-invalid="false" required>' +
                size_id_html + '</select></div>';
            // html +=
            //     '<div class="col-md-3"><label for="color_id" class="control-label mb-1">Color</label><select id="color_id" name="color_id" type="text" class="form-control"aria-required="true" aria-invalid="false" required><option value="">Select Color</option>@foreach ($color as $list)<option value="{{ $list->id }}">{{ $list->color }}</option>@endforeach</select></div>';
            var color_id_html = jQuery('#color_id').html();
            color_id_html = color_id_html.replace("selected", "");
            html +=
                '<div class="col-md-3"><label for="color_id" class="control-label mb-1">Color</label><select id="color_id" name="color_id[]" type="text" class="form-control"aria-required="true" aria-invalid="false" required>' +
                color_id_html + '</select></div>';
            html +=
                '<div class="col-md-3"><label for="qty" class="control-label mb-1">Qty</label><input id="qty" value="" name="qty[]" type="text"class="form-control" aria-required="true" aria-invalid="false" required></div>';
            html +=
                '<div class="col-md-6"><label for="attr_image" class="control-label mb-1">Image</label><input id="attr_image" name="attr_image[]" type="file" class="form-control"aria-required="true" aria-invalid="false">@error('attr_image')<div class="alert alert-danger" role="alert">{{ $message }}</div>@enderror</div>';
            html +=
                '<div class="col-md-2"><label for="attr_image" class="control-label mb-1"></label><button type="button" class="btn btn-danger btn-lg" onclick=remove_more("' +
                loop_count + '")><i class="fa fa-minus"></i>&nbsp; Remove</button></div>';
            html += '</div></div></div></div>';

            jQuery('#product_attr_box').append(html);
        }

        function remove_more(loop_count) {
            jQuery('#product_attr_' + loop_count).remove();
            //location.reload();
        }
        var loop_image_count = 1;

        function add_image_more() {
            loop_image_count++;
            var html =
                '<input id="pimages_id" type="hidden" value="" name="pimages_id[]"> <div class="col-md-4 product_images_' +
                loop_image_count +
                '"><label for="images" class="control-label mb-1">Image</label><input id="images" name="images[]" type="file" class="form-control"aria-required="true" aria-invalid="false">@error('images')<div class="alert alert-danger" role="alert">{{ $message }}</div>@enderror</div>';
            html +=
                '<div class="col-md-2 product_images_' + loop_image_count +
                '"><label for="images" class="control-label mb-1"></label><button type="button" class="btn btn-danger btn-lg" onclick=remove_more_image("' +
                loop_image_count + '")><i class="fa fa-minus"></i>&nbsp; Remove</button></div>';

            jQuery('#product_image_box').append(html);
        }

        function remove_more_image(loop_image_count) {
            jQuery('.product_images_' + loop_image_count).remove();
            //location.reload();
        }
        CKEDITOR.replace('short_desc');
        CKEDITOR.replace('desc');
        CKEDITOR.replace('technical_specification');
    </script>

@endsection
