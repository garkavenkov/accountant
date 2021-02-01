@extends('layouts.app')

@section('content')

    <router-view></router-view>

@endsection


@push('scripts')
    <script src="{{ asset('js/modules/cash_profit_documents.js') }}" ></script>    
@endpush    