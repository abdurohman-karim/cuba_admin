@extends('layouts.simple.master')

@section('title', 'Добавить роль')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Добавить роль</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Роли</li>
    <li class="breadcrumb-item active">Добавить роль</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Добавить роль</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Название</label>
                                        <input class="form-control" type="text" name="name" placeholder="Название">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="horizontal-email-input" class="col-form-label"><i>Разрешения</i></label>
                                <div class="row mx-2">
                                    @foreach($permissions as $permission)
                                        @if($loop->iteration % 2 == 0)
                                </div>
                                @endif
                                @if($loop->iteration % 2 == 0 || $loop->iteration == 1)
                                    <div class="col-lg-4 col-md-4 mb-2">
                                        @endif
                                        <div class="form-check mb-1">
                                            <input name="permissions[]" class="form-check-input" value="{{$permission->name}}" type="checkbox" id="checkBoxId_{{$permission->id}}">
                                            <label class="form-check-label" for="checkBoxId_{{$permission->id}}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                        @endforeach
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