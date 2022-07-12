@extends('layout')

@section('content')

    @isset($message)
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="flex items-center">
                <div class="ml-4 text-lg leading-7 font-semibold">
                    <h3 class="text-danger">User error{{ ': ' . $status }}</h3>
                    <hr />
                </div>
            </div>
            <div class="ml-12">
                <div class="col-xs-12">
                    <span>Sorry, the system has detected a user error! Please see below message.</span>
                    <li class="text-warning fw-bold">{{ $message }}</li>
                </div>
            </div>
        </div>
    @else
        <h3 class="text-primary">Oops...you're not supposed to be here!</h3>
    @endisset

    <div class="flex justify-center sm:items-center sm:justify-between">
        <div class="text-center text-sm text-gray-500 sm:text-right sm:ml-0">
            <hr />
            <a href="{{ URL::to('/') }}" class="link-warning">Home</a> | <a href="{{ Route('list') }}" class="link-warning">Invoices</a>
        </div>
    </div>
@endsection
