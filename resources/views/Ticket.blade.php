@extends('dashboard')
@section('content')
    @livewire('ticket')
    @if (session('notify'))
        {{-- <x-notification-laravel :message="session('notify')" /> --}}
        @include('laravel-notification')
    @endif
@endsection
