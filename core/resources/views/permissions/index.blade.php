@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Gestion des permissions</h1>
</div>

@if ( count($roles) )
    {!! Form::model($permissions, ['route' => 'permission.update']) !!}
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table_permissions no_css">
                <thead>
                    <tr>
                        <th>Nom de la permission</th>
                        @foreach ($roles as $role)
                            <th align="center">{{ ucfirst($role) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $permission)
                        <tr>
                            <td>
                                {{ $permission['label'] }}
                                <br>
                                <small style="color:#777">
                                    <em>{{ $permission['description'] }}</em>
                                </small>
                            </td>

                            <?php $r = array_column($permission['roles'], 'name'); ?>

                            @foreach ($roles as $id => $role)
                                <td align="center">
                                    @if ( $role == 'admin' )
                                        <input name="permissions[]" value="{{ $permission['id'] . '-' . $id }}" type="checkbox" checked }}>
                                    @else
                                        <input name="permissions[]" value="{{ $permission['id'] . '-' . $id }}" type="checkbox"{{ in_array($role, $r) ? ' checked' : '' }}>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Aucune permission !</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Enregistrer
        </button>
    {!! Form::close() !!}
@else
    <p>No data !</p>
@endif
@endsection
