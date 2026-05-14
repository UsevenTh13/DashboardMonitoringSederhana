@extends('layouts.app')

@section('title', 'Filter Overstay')
@section('page-title', 'Filter Pasien Overstay')
@section('page-subtitle', 'Pasien aktif yang melebihi standar LOS (≥ 6 hari perawatan)')

@section('content')
<div class="animate-slide-in">
    <livewire:overstay-filter />
</div>
@endsection
