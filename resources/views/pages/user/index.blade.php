@extends('layouts.simple.master')

@section('title', 'Пользователи')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Пользователи</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Пользователи</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Список пользователей</h5>
{{--                    create button section--}}
                    <div class="btn-group-sm float-end">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Создать пользователя</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordernone">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            @if(auth()->user()->id != $user->id)
                                                <a href="{{ route('users.destroy', $user->id) }}" onclick="event.preventDefault();
                                               document.getElementById('delete-form').submit();" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <form id="delete-form" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection