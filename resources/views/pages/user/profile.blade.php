@extends('layouts.simple.master')

@section('title', 'Профиль')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Профиль пользователя</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Профиль</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Мой профиль</h4>
                        <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Имя</label>
                                <input class="form-control" placeholder="Введите имя" value="{{ $user->name }}" name="name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control" placeholder="your-email@gmail.com" value="{{ $user->email }}" name="email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Пароль</label>
                                <input class="form-control" type="password" name="password">
                            </div>
                            <div class="form-footer">
                                <button class="btn btn-primary btn-block" type="submit">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
            </div>
        </div>
    </div>
@endsection