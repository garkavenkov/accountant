@extends('layouts.app')

@section('content')

    <router-view></router-view>

@endsection


@push('scripts')
    <script src="{{ asset('js/modules/suppliers.js') }}" ></script>    
@endpush    