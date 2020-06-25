@extends('layouts._app')

@section('content')

    <router-view></router-view>

@endsection


@push('scripts')
    <script src="{{ asset('js/modules/departments.js') }}" ></script>    
@endpush    