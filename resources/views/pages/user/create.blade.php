@extends('layouts.simple.master')

@section('title', 'Добавить пользователя')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Добавить пользователя</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Пользователи</li>
<li class="breadcrumb-item active">Добавить пользователя</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Добавить пользователя</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom01">Имя</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="validationCustom01" placeholder="Имя" value="{{ old('name') }}" required name="name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationCustomUsername">Email</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Email" required name="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="validationCustom02">Пароль</label>
                                <input type="password" class="form-control @error('name') is-invalid @enderror" id="validationCustom02" placeholder="Пароль" required name="password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary mt-3" type="submit">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection