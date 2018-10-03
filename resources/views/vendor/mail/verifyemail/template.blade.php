@extends('vendor.mail.layouts.master')
@section('content')
    <p>Hi, {{ $customerName }}</p>
    <p>your code is {{ $customerCode }}</p>
@endsection

