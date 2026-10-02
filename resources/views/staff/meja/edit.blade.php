@extends('layouts.staff')
@section('title', 'Edit Meja')
@section('content')
<div class="staff-page-heading"><h1>Edit Meja</h1></div><form method="POST" action="{{ url('/staff/meja/' . data_get($table,'id')) }}" class="card p-4 form-card">@csrf @method('PUT')<label class="form-label">Outlet</label><select name="outlet_id" class="form-select mb-3" required>@foreach($outlets ?? [] as $outlet)<option value="{{ data_get($outlet,'id') }}" @selected((string)data_get($table,'outlet_id') === (string)data_get($outlet,'id'))>{{ data_get($outlet,'name') }}</option>@endforeach</select><label class="form-label">Nomor Meja</label><input name="table_number" type="number" value="{{ data_get($table,'table_number') }}" class="form-control mb-3" required><button class="btn btn-bowlmate">Update</button></form>
@endsection
