@extends('layouts.app')

@section('content')

    <router-view></router-view>

@endsection


@push('scripts')
    <script src="{{ asset('js/modules/transfer_documents.js') }}" ></script>    
@endpush    