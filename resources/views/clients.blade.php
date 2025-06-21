@extends('layouts.app')

@section('title', 'Ügyfelek')

@section('content')
<div class="container">
    <h1>Ügyfelek</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ügyfél azonosító</th>
                <th scope="col">név</th>
                <th scope="col">okmányazonosító</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->card_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->onEachSide(5)->links() }}
</div>
@endsection
