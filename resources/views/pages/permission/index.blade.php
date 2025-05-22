@extends('layouts.simple.master')

@section('title', 'Разрешения')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Разрешения</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Разрешения</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Список разрешений</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordernone">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td class="col-sm-2">
                                        {{ $permission->id }}
                                    </td>
                                    <td class="col-sm-2">
                                        {{ $permission->name }}
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