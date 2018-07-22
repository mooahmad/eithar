@extends('vendor.mail.layouts.layoutv1.blade')

@section('title', 'Eithar')

@section('content')
    <p>hi, {{ $customerName }}</p>
    <p>your code is {{ $customerCode }}</p>
@endsection
