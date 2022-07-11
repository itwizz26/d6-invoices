@extends('layout')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="flex items-center">
            <div class="ml-4 text-lg leading-7 font-semibold">
                <h3>Invoice Generator</h3>
                <span>Fill in all the required details in the form below and hit the <strong>Preview</strong> button.</span>
                <hr />
            </div>
        </div>
        <div class="ml-12">
            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                <form id="pdf-previewer" action="{{ route('preview') }}" method="POST">
                    @csrf
                    <div class="row">
                        <h1 class="text-primary">Billing Information</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group pb-2">
                                <input type="text" name="billing_name" id="billing_name" class="form-control" placeholder="Billing Name" minlength="5" maxlength="50" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group pb-2">
                                <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name" minlength="5" maxlength="50" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group pb-2">
                                <input type="text" name="street_address" id="street_address" class="form-control" placeholder="Street Address" minlength="10" maxlength="255" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group pb-2">
                                <input type="text" name="city" id="city" class="form-control" placeholder="City" maxlength="50" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group pb-2">
                                <input type="number" name="area_code" id="area_code" class="form-control" placeholder="Area Code" minlength="4" maxlength="5" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group pb-2">
                                <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Telephone Number" minlength="10" maxlength="11" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h1 class="mt-3 text-primary">Description</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group pb-2">
                                <input type="text" name="description" id="description" class="form-control" placeholder="Item description" minlength="5" maxlength="255" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-4">
                            <div class="form-group pb-2">
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="Amount" minlength="2" maxlength="6" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-1">
                            <div class="form-check form-switch pt-2">
                                <input type="checkbox" name="is_taxed" id="is_taxed" class="form-check-input" checked />
                                <label class="form-check-label" for="is_taxed">Taxed</label>
                            </div>                              
                        </div>
                    </div>
                    <div class="row" id="more_items"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <button id="add_items" class="btn btn-primary" title="Add Item"> + </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h1 class="mt-3 text-primary">Comments</h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <textarea name="comments" id="comments" class="form-control" placeholder="Comments" maxlength="255"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-left mt-3">
                            <button id="preview" type="submit" class="btn btn-primary" title="Preview Invoice">Preview</button>
                            <div id="previewing" class="invisible">
                                <img src="{{ asset('img/loader.gif') }}" height="30" />
                                <span class="text-primary">Generating invoice preview. Please wait...</span>
                            </div>
                        </div>
                    </div>
                </form>
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
