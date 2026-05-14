@extends('layouts.app')

@section('title', 'Riwayat Pasien')
@section('page-title', 'Riwayat Pasien')
@section('page-subtitle', 'Rekam data pasien yang telah selesai dirawat untuk kebutuhan evaluasi ruangan')

@section('content')
<div class="animate-slide-in">
    <livewire:patient-history />
</div>
@endsection
