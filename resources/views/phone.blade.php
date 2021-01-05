@extends('layouts.app')

@section('content')
    @push('style')
        <style>
            .custom-file-label:after {
                content: "Выбрать" !important;
            }
        </style>
    @endpush
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{--                        <label class="float-left">--}}
                        {{--                            Phone--}}
                        {{--                        </label>--}}
                        <form id="upload-form" action="{{route('phone.upload')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="upload" lang="ru" name="upload"
                                       required>
                                <label class="custom-file-label" for="customFileLang">Выберите файл</label>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Тел.</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($calls as $call)
                                <tr>
                                    <td>{{$call->id}}</td>
                                    <td>{{$call->name}}</td>
                                    <td>{{$call->phone}}</td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="3">пусто</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{$calls->onEachSide(1)->links()}}
            </div>

        </div>

    </div>
    @push('script')
        <script type="text/javascript">
            $(document).ready(function () {
                $(".custom-file-input").on("change", function () {
                    let fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    if (this.files.length) this.form.submit();
                });
            });
        </script>
    @endpush
@endsection
