@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('include.url')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a target="_blank" href="http://{{$url->domain}}">{{$url->domain}}</a>
                        <a class="float-right btn btn-sm btn-outline-dark" href="{{url('admin')}}">&laquo; назад</a>
                    </div>
                    <div class="card-body">
                        <form action="{{route('domain.seo',$url->seo->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="url_id" value="{{$url->id}}">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Title</label>
                                <input type="text" name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="exampleFormControlInput1" value="{{$url->seo->title}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" id="exampleFormControlTextarea1"
                                          rows="3">{{$url->seo->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea2">Keywords</label>
                                <textarea class="form-control @error('keywords') is-invalid @enderror" name="keywords"
                                          id="exampleFormControlTextarea2"
                                          rows="3">{{$url->seo->keywords}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea3">Текст для сайта </label>
                                <textarea class="form-control @error('text') is-invalid @enderror" name="text"
                                          id="exampleFormControlTextarea3"
                                          rows="3">{{$url->seo->text}}</textarea>
                            </div>
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
                                <button type="submit" class="btn btn-success">сохранить</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal">изменить url
                                </button>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#modalDelete">удалить url
                                </button>
                            </div>
                        </form>
                        <form action="{{route('sitemap',$url->domain)}}" method="post">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary" type="submit" id="sitemap">сгенерировать
                                sitemap.xml
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('domain.edit',$url->id)}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Изменить</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Input1">URL</label>
                            <input type="text" name="domain" class="form-control" id="Input1" value="{{$url->domain}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('domain.delete',$url->id)}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Вы уверены ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{$url->domain}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            CKEDITOR.replace('exampleFormControlTextarea3');
        });
    </script>
@endpush
