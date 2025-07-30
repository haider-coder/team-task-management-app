@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa fa-pencil me-2"></i>Edit Task</span>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-light btn-sm">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong><i class="fa fa-warning me-1"></i> Please fix the issues below.</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.tasks.update', $task->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label fw-semibold">
                                    <i class="fa fa-header me-1"></i> Title
                                </label>
                                <input type="text" id="title" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $task->title) }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label fw-semibold">
                                    <i class="fa fa-file-text-o me-1"></i> Description
                                </label>
                                <textarea id="description" name="description" rows="4"
                                          class="form-control @error('description') is-invalid @enderror"
                                          required>{{ old('description', $task->description) }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">
                                    <i class="fa fa-flag me-1"></i> Status
                                </label>
                                <select id="status" name="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="To Do"       {{ old('status', $task->status) === 'To Do' ? 'selected' : '' }}>To Do</option>
                                    <option value="In Progress" {{ old('status', $task->status) === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed"   {{ old('status', $task->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="user_id" class="form-label fw-semibold">
                                    <i class="fa fa-user me-1"></i> Assign to User
                                </label>
                                <select id="user_id" name="user_id"
                                        class="form-control @error('user_id') is-invalid @enderror" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ (string)old('user_id', $task->user_id) === (string)$user->id ? 'selected' : '' }}>
                                            {{ $user->name }} — {{ $user->email }} — {{ $user->type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="tag_id" class="form-label fw-semibold">
                                    <i class="fa fa-tags me-1"></i> Tag
                                </label>
                                <select id="tag_id" name="tag_id"
                                        class="form-control @error('tag_id') is-invalid @enderror" required>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ (string)old('tag_id', $task->tag_id) === (string)$tag->id ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tag_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="deadline" class="form-label fw-semibold">
                                    <i class="fa fa-calendar me-1"></i> Deadline
                                </label>
                                @php
                                    $deadlineValue = old('deadline', optional($task->deadline)->format('Y-m-d\TH:i'));
                                @endphp
                                <input type="datetime-local" id="deadline" name="deadline"
                                       class="form-control @error('deadline') is-invalid @enderror"
                                       value="{{ $task->deadline }}">
                                <small class="text-muted"><i class="fa fa-info-circle"></i> Optional.</small>
                                @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Task
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
