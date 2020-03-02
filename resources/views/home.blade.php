@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('include.url')
            <div class="col-md-8">
{{--                <div class="card">--}}
{{--                    <div class="card-header">Dashboard</div>--}}
{{--                    <div class="card-body table-responsive">--}}
                <div class="table-responsive">
                        <table class="table ">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Номер телефона</th>
                                <th scope="col">Комментарии</th>
                                <th scope="col">URL</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contacts as $contact)
                                <tr>
                                    <th scope="row">{{$contact->id}}</th>
                                    <td>{{$contact->name}}</td>
                                    <td>{{$contact->phone}}</td>
                                    <td>{{$contact->massage}}</td>
                                    <td><a target="_blank" href="{{$contact->url}}">{{$contact->url}}</a></td>
                                </tr>
                                @empty
                                <tr class="text-center">
                                    <th scope="row" colspan="5">пусто</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    {{ $contacts->links() }}
                </div>
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
