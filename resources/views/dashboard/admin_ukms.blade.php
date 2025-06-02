@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Manage UKMs</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama UKM</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ukms as $ukm)
            <tr>
                <td>{{ $ukm->id }}</td>
                <td>{{ $ukm->name }}</td>
                <td>
                    <a href="{{ route('admin.ukms.edit', $ukm->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('admin.ukms.destroy', $ukm->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection