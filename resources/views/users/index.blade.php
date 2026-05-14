@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Sistem Monitoring Length of Stay Pasien')

@section('content')
    <div class="max-w-6xl mx-auto">
        <livewire:user-management />
    </div>
@endsection
