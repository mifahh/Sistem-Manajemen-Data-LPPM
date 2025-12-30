@extends('layouts.blank')

@section('content')
<x-eror 
    eror="429"
    erorTitle="Too Many Requests"
    erorDescription="Ooooups! Looks like your did too many requests"
/>
@endsection