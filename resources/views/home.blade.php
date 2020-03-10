@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('include.url')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Обратная связь</div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th class="p-2" scope="col">#</th>
                                <th class="p-2" scope="col">Имя</th>
                                <th class="p-2" scope="col">Тел.</th>
                                <th class="p-2" scope="col">Комментарии</th>
                                <th class="p-2" scope="col">URL</th>
                                <th class="p-2" scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contacts as $contact)
                                <tr>
                                    <th scope="row" class="p-2">{{$loop->iteration}}</th>
                                    <td class="p-2">{{$contact->name}}</td>
                                    <td class="p-2">
                                        <a href="tel:+{{$contact->phone}}">{{$contact->phone}}</a>
                                    </td>
                                    <td class="p-2 overflow-y">{{$contact->massage}}</td>
                                    <td class="p-2">
                                        <a target="_blank" href="{{$contact->url}}">{{$contact->url}}</a>
                                    </td>
                                    <td class="p-2">
                                        @if($contact->status)
                                            <h6><span class="badge badge-success">новый</span></h6>
                                        @else
                                            <h6><span class="badge badge-secondary">старый</span></h6>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <th scope="row" colspan="6">пусто</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
