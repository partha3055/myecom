@extends('admin/layout')
@section('page_title', 'Manage Coupon')
@section('coupon_select', 'active')
@section('container')
    <h1 class="mb10">Manage Coupon</h1>
    <a href="{{ route('coupon') }}">
        <button type="button" class="btn btn-success">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('coupon.manage_coupon_process') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="title" class="control-label mb-1">Coupon Title</label>
                                    <input id="title" value="{{ $title }}" name="title" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required>
                                </div>
                                <div class="form-group">
                                    <label for="code" class="control-label mb-1">Coupon Code</label>
                                    <input id="code" value="{{ $code }}" name="code" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('code')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="value" class="control-label mb-1">Coupon Value</label>
                                    <input id="value" value="{{ $value }}" name="value" type="text"
                                        class="form-control" aria-required="true" aria-invalid="false" required>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="control-label mb-1">Coupon Type</label>
                                    <select id="type" name="type" type="text"class="form-control"
                                        aria-required="true" aria-invalid="false" required>
                                        <option value="">Select Type</option>
                                        @if ($type == 'Value')
                                            <option value="Value" selected>Value</option>
                                            <option value="Percentage">Percentage</option>
                                        @elseif ($type == 'Percentage')
                                            <option value="Value">Value</option>
                                            <option value="Percentage"selected>Percentage</option>
                                        @else
                                            <option value="Value">Value</option>
                                            <option value="Percentage">Percentage</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="min_order_amt" class="control-label mb-1">Minimum order Amount</label>
                                    <input id="min_order_amt" value="{{ $min_order_amt }}" name="min_order_amt"
                                        type="text" class="form-control" aria-required="true" aria-invalid="false"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="is_one_time" class="control-label mb-1">Is One Time</label>
                                    <select id="is_one_time" name="is_one_time" type="text"class="form-control"
                                        aria-required="true" aria-invalid="false" required>
                                        @if ($is_one_time == '1')
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                        @else
                                            <option value="1">Yes</option>
                                            <option value="0"selected>No</option>
                                        @endif
                                    </select>
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
