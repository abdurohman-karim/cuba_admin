@extends('layouts.simple.master')

@section('title', 'Роли')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Роли</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Роли</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Список ролей</h5>
{{--                    create button section--}}
                    <div class="btn-group-sm float-end">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Создать роль</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordernone">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Разрешении</th>
                                    <th scope="col">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td class="col-sm-2">
                                            {{ $role->id }}
                                        </td>
                                        <td class="col-sm-2">
                                            {{ $role->name }}
                                        </td>
                                        <td class="col-sm-2">
                                            {{$role->permissions->pluck('name')->implode(', ')}}
                                        </td>
                                        <td>
                                            <div class="btn-group-sm">
                                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-success btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('roles.destroy', $role->id) }}" onclick="event.preventDefault();
                                               document.getElementById('delete-form').submit();" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                            <form id="delete-form" action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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