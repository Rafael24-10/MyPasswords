@extends('layouts.app')


@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <button type="button" class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-bs-whatever="@mdo">Add New Password</button>
                <div class="card">

                    <div class="card-body text-center d-flex mx-2 my-4">

                        @if ($passwords === null)
                            {{ __('No passwords saved yet!') }}
                        @endif

                        {{-- Add password modal --}}
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">New Password</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('password.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Password name:</label>
                                                <input type="text"
                                                    class="form-control @error('password_name') is-invalid @enderror"
                                                    name="password_name" id="recipient-name">

                                                @error('password_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Password:</label>
                                                <textarea class="form-control @error('password_value') is-invalid @enderror" name="password_value" id="message-text"></textarea>
                                                @error('password_value')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- end add password modal --}}
                        <div class="row">
                            @foreach ($passwords as $password)
                                @if (count($passwords) < 3)
                                    <div class="col-md-6 mb-3">
                                    @else
                                        <div class ="col-md-4 mb-3">
                                @endif
                                <style>
                                    .dropdown-item:hover {
                                        background-color: #6c757d;
                                        color: #fff;
                                    }

                                    .action-link {
                                        text-decoration: none;
                                        color: #fff;
                                    }
                                </style>
                                <div class="card mx-2" style="width: 12rem;">
                                    <img src="{{ asset('images/key.svg') }}" class="card-img-top" alt="key image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $password['password_name'] }}</h5>
                                        <p class="card-text">{{ $password['password_value'] }}</p>
                                        {{-- <a href="#" class="btn btn-primary">Options</a> --}}
                                        <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle mx-0" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Options
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $password['password_id'] }}"
                                                        href="">Edit</a></li>
                                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#confirmationModal{{ $password['password_id'] }}"
                                                        href="">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                {{-- delete modal --}}
                                @if ($passwords)
                                    <div class="modal" id="confirmationModal{{ $password['password_id'] }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this password?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form id="deleteForm"
                                                        action="{{ route('password.destroy', ['password_id' => $password['password_id']]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-primary">Delete</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end delete modal --}}
                                    {{-- edit modal --}}
                                    <div class="modal" id="editModal{{ $password['password_id'] }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('password.update', ['password_id' => $password['password_id']]) }}"
                                                        method="POST">
                                                        @method('put')
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Password
                                                                name:</label>
                                                            <input type="text" class="form-control"
                                                                name="new_password_name" id="recipient-name"
                                                                placeholder="40 characters max"
                                                                value="{{ $password['password_name'] }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">Password:</label>
                                                            <textarea class="form-control" name="new_password_value" id="message-text">{{ $password['password_value'] }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end edit modal --}}
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
