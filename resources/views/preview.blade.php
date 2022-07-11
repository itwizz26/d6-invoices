<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- System title -->
    <title>D6 Invoice &trade;</title>
    
    <!-- Favicon --> 
    <link rel="icon" type="image/x-icon" href="{{ asset('img/invoice-icon.png') }}">

    <!-- Styles -->
    <style type="text/css">
        <?php
            include(public_path() . "/css/bootstrap.min.css");
        ?>
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 13px;
            color: black;
        }
        .pre-wrap {
            white-space: pre-wrap;
        }
        .head-size {
            color: #375076;
            font-size: 33px;
        }
        .color-light-blue {
            color: #385889;
        }
        .color-light-blue-bg {
            background-color: #a5bbdd !important;
        }
        .color-dark-blue-bg {
            background-color: #385889 !important;
        }
        .back-img {
            background-image: url("{{'data:image/png;base64,' . base64_encode(file_get_contents(public_path ('img/invoice-icon.png')))}}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            font-weight: bold;
        }
    </style>
</head>

<body class="border">
    <div class="container-fluid">
        <div class="row justify-content-center p-2">
            <div class="col-sm-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                @if(Route::current()->getName() !== 'generate')
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 p-3">
                            <a class="btn btn-secondary" onclick="history.back()">Back</a>
                            <a href="{{ route('list') }}" class="btn btn-secondary" target="_blank">Invoices</a>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 text-end p-3">
                            <a href="{{ route('generate', $invoice_id) }}" class="btn btn-success" target="_blank">Download</a>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="w-75">
                                    <span class="d-block head-size">{{ $company->name }}</span>
                                    <span class="d-block">{{ $company->address }}</span>
                                    <span class="d-block">{{ $company->city }}, {{ $company->area_code }}</span>
                                    <span class="d-block">Phone: +27{{ $company->phone_number }}</span>
                                    <span class="d-block">Fax: +27{{ $company->fax_number }}</span>
                                    <span class="d-block">Website: {{ $company->web_address }}</span>
                                </td>
                                <td class="w-25 text-end">
                                    <span class="text-uppercase d-block head-size color-light-blue fw-bold">Invoice</span>
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td scope="col" class="p-0"><span class="text-uppercase">Date</span></td>
                                                <td class="p-1"></td>
                                                <td scope="col" class="border p-0 text-center"><span>{{ $date }}</span></td>
                                            </tr>
                                            <tr>
                                                <td scope="col" class="p-0"><span class="text-uppercase">Invoice #</span></td>
                                                <td class="p-1"></td>
                                                <td scope="col" class="border p-0 text-center"><span>{{ $invoice_id }}</span></td>
                                            </tr>
                                            <tr>
                                                <td scope="col" class="p-0"><span class="text-uppercase">Customer ID</span></td>
                                                <td class="p-1"></td>
                                                <td scope="col" class="border p-0 text-center"><span>{{ $customer->id }}</span></td>
                                            </tr>
                                            <tr>
                                                <td scope="col" class="p-0"><span class="text-uppercase">Due Date</span></td>
                                                <td class="p-1"></td>
                                                <td scope="col" class="border color-light-blue-bg p-0 text-center"><span>{{ $due }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <table class="table table-borderless w-50">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="p-1 color-dark-blue-bg">
                                        <span class="text-white text-uppercase bold">Bill To</span>
                                    </div>
                                    <span class="d-block">{{ $customer->billing_name }}</span>
                                    <span class="d-block">{{ $customer->company_name }}</span>
                                    <span class="d-block">{{ $customer->street_address }}</span>
                                    <span class="d-block">{{ $customer->city }}, {{ $customer->area_code }}</span>
                                    <span class="d-block">+27{{ $customer->phone_number }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row m-0">
                    <table class="table table-striped back-img" style="border: 1px solid #dee2e6;">
                        <thead>
                            <tr class="color-dark-blue-bg text-uppercase text-center text-white">
                                <th class="p-1 w-75">Description</th>
                                <th class="p-1" style="border-left: 1px solid #dee2e6">Taxed</th>
                                <th class="p-1" style="border-left: 1px solid #dee2e6">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr style="border-bottom: 1px solid #dee2e6">
                                    <td class="col-md-8 p-1">{{ $invoice['description'] }}</td>
                                    <td class="text-center p-1" style="border-left: 1px solid #dee2e6">@if($invoice['is_taxed'] == 'on') x @endif</td>
                                    <td class="text-end p-1" style="border-left: 1px solid #dee2e6">{{ $invoice['amount'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="w-75">
                                    <div class="border w-100 pr-3">
                                        <div class="p-1 color-dark-blue-bg">
                                            <span class="text-white text-uppercase bold">Other Comments</span>
                                        </div>
                                        <div class="p-2">
                                            <span class="d-block pre-wrap">{{ $comments->comments }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="w-25">
                                    <table class="table mb-3 table-borderless">
                                        <tbody>
                                            <tr>
                                                <td scope="col" class="p-1"><span>Sub-total</span></td>
                                                <td scope="col" class="text-end p-1"><span>{{ $calculated['sub_total'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td scope="col" class="p-1"><span>Taxable</span></td>
                                                <td scope="col" class="text-end p-1"><span>{{ $calculated['taxable'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td scope="col" class="p-1"><span>Tax rate</span></td>
                                                <td scope="col" class="border text-end p-1"><span>{{ $calculated['tax_rate'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td scope="col" class="p-1"><span>Tax due</span></td>
                                                <td scope="col" class="text-end p-1"><span>{{ $calculated['tax_due'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td scope="col" class="p-1"><span>Other</span></td>
                                                <td scope="col" class="border text-end p-1"><span>-</span></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="border">
                                                <th scope="col" class="p-1"><span class="text-uppercase">Total</span></th>
                                                <th scope="col" class="p-1 border color-light-blue-bg text-end"><span>R {{ $calculated['total'] }}</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="text-center">
                                        <p class="p-0">Make all cheques payable to <span class="d-block fw-bold">{{ $customer->company_name }}</span></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="p-0 m-0">If you have any questions about this invoice, please contact 
                            <span class="d-block">{{ $company->name }}, +27{{ $company->phone_number }}, {{ $company->email_address }}</span>
                        </p>
                        <p class="p-0 m-0 text-capitalize fw-bold fst-italic">Thank you for your business!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
