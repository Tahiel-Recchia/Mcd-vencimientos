@extends('layouts.app')

@section('content')
    <h2>El vencimiento de {{ $product->name }} es de {{ $expirationTime }}</h2>
@endsection
