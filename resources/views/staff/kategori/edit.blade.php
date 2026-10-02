{{-- variabel: $category --}}
@extends('layouts.staff')
@section('title', 'Ubah kategori')
@section('content')
  <h1 class="page-title mb-3">Ubah kategori</h1>
  @include('staff.kategori._form')
@endsection
