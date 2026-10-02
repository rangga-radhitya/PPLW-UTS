{{-- GET /staff/menu/{id}/edit  |  variabel: $menu, $categories --}}
@extends('layouts.staff')
@section('title', 'Ubah menu')
@section('content')
  <h1 class="page-title mb-3">Ubah menu</h1>
  @include('staff.menu._form')
@endsection
