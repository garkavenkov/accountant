@extends('layouts.app')

@section('content')

    <router-view></router-view>

@endsection


@push('scripts')
    <script src="{{ asset('js/modules/cash_expense_documents.js') }}" ></script>    
@endpush    