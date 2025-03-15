@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <h3 class="card-title mb-4 text-center">Create Task</h3>
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" name="title" class="form-control" id="title" placeholder="Task Title" required>
                            <label for="title">Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="description" class="form-control" id="description" placeholder="Task Description" style="height: 100px;"></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
