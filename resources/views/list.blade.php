@extends('layout')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="flex items-center">
            <div class="ml-4 text-lg leading-7 font-semibold">
                <h3>Invoices</h3>
                <span>Here you may regenerate your old invoices.</span>
                <hr />
            </div>
        </div>
        <div class="ml-12">
            <div class="mt-3 text-gray-600 dark:text-gray-400 text-sm">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="bg-secondary text-white">
                            <th>Invoice&nbsp;ID</th>
                            <th>Billing Name</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Phone Number</th>
                            <th>Date Created</th>
                            <th width="180px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_id }}</td>
                                <td>{{ $invoice->billing_name }}</td>
                                <td>{{ $invoice->company_name }}</td>
                                <td>{{ $invoice->street_address }}</td>
                                <td>{{ $invoice->city }}</td>
                                <td>{{ $invoice->phone_number }}</td>
                                <td>{{ $invoice->created_at }}</td>
                                <td class="col-xs-12 col-md-2 text-center">
                                    <form class="form-control">
                                        <a class="btn btn-primary btn-sm" href="{{ route('generate', $invoice->invoice_id) }}" target="_blank">Download</a>
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex justify-center sm:items-center sm:justify-between">
        <div class="text-center text-sm text-gray-500 sm:text-right sm:ml-0">
            <hr />
            <a href="{{ URL::to('/') }}" class="link-warning">Home</a> | <a href="{{ Route('list') }}" class="link-warning">Invoices</a>
        </div>
    </div>
    
@endsection
