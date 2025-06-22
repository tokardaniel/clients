@extends('layouts.app')

@section('title', 'Ügyfelek')

@section('content')
<div class="container">
    <div class="title-container" style="display: flex; align-items: center; justify-content: left;">
        <h1 style="display: inline-block">Ügyfelek</h1>
        <div style="display: none" id="spinner_div"><img src="{{ asset('assets/images/spinner.gif') }}" alt="spinner"></div>
    </div>
    <hr>

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
                    <td><a href="javascript:void(0)" class="td_client_name" id="{{ $client->id }}">{{ $client->name }}</a></td>
                    <td>{{ $client->card_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->onEachSide(5)->links() }}

    <div id="cars_table_container"></div>

    <div id="services_table_container" style="display: none">
        <table id="services_data_tables" class="display">
            <thead>
                <tr>
                    <th>alkalom sorszáma</th>
                    <th>esemény neve</th>
                    <th>esemény időpontja</th>
                    <th>munkalap azonosító</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
