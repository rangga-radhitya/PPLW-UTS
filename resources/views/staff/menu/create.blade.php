{{-- GET /staff/menu/create  |  variabel: $categories --}}
@extends('layouts.staff')
@section('title', 'Tambah menu')
@section('content')
  <h1 class="page-title mb-3">Tambah menu</h1>
  @include('staff.menu._form')
@endsection
