@extends('layouts.app')
@section('content')
    <section class="container">
        <div class="mb-3 text-end">
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mt-2 ">Create New Project</a>
        </div>
        <h1>Post List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Image</th>
                    <th>Body</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td><a href="{{ route('admin.projects.show', $project->id) }}">{{ $project->title }}</a></td>
                        <td>{{ $project->link }}</td>
                        <td><img src="{{ $project->image }}" alt="Project Image"></td>
                        <td>{{ $project->body }}</td>
                        <td>
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
