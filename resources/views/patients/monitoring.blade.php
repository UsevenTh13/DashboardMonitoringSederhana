@extends('layouts.app')

@section('title', 'Monitoring Pasien')
@section('page-title', 'Monitoring Pasien Aktif')
@section('page-subtitle', 'Daftar seluruh pasien yang sedang dirawat beserta status LOS real-time')

@section('content')
<div class="space-y-6 animate-slide-in">

    <!-- Patient Form Component (CRUD + Discharge) - khusus perawat -->
    @if(Auth::user()->isPerawat())
        <livewire:patient-form />
    @endif

    <!-- Patient Monitor Table -->
    <livewire:patient-monitor />

</div>
@endsection
