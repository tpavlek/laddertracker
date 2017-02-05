@extends('admin.layout')

@section('title')
All LadderHeroes Users
@stop

@section('admin_content')
    <div class="info-panel">
        <table>
            <thead>
                <tr>
                    <th>Display Name</th>
                    <th>Battle.net URL</th>
                    <th>Region</th>
                    <th>Paypal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->getDisplayName() }}</td>
                        <td>{{ $user->getBnetUrl() }}</td>
                        <td>{{ $user->getRegion() }}</td>
                        <td>{{ $user->getPaypal() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3"><em>No users registered</em></td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@stop
