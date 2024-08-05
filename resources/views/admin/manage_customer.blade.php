@extends('admin/layout')
@section('page_title', 'Manage Customer')
@section('customer_select', 'active')
@section('container')
    <h1 class="mb10">Customer Data</h1>
    <a href="{{ route('customer') }}">
        <button type="button" class="btn btn-success">Back</button>
    </a>
    <div class="row m-t-30">
        <div class="col-md-4">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $customer_list->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $customer_list->email }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $customer_list->mobile }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $customer_list->address }}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ $customer_list->city }}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{ $customer_list->state }}</td>
                        </tr>
                        <tr>
                            <td>Zip Code</td>
                            <td>{{ $customer_list->zip }}</td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>{{ $customer_list->company }}</td>
                        </tr>
                        <tr>
                            <td>GST NO</td>
                            <td>{{ $customer_list->gstin }}</td>
                        </tr>
                        <tr>
                            <td>Added On</td>
                            <td>{{ $customer_list->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td>Updated On</td>
                            <td>{{ $customer_list->updated_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>

@endsection
