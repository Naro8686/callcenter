@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('include.url')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a target="_blank" href="http://{{$url->domain}}">{{$url->domain}}</a>
                        @if($url->domain === 'yurkonsultatsia.ru')
                            <span class="badge badge-info text-white">/</span>
                            {{--                            <select id="slug" class="form-control-sm"--}}
                            {{--                                    style="max-width: 250px;background-color: #f7f7f7;border: none">--}}
                            {{--                                @foreach($url->seo as $key => $value)--}}
                            {{--                                    <option value="{{$value->id}}">{{$value->slug === '/'?'':$value->slug}}</option>--}}
                            {{--                                @endforeach--}}
                            {{--                            </select>--}}

                            <select id="slug"
                                    class="form-control-sm"
                                    style="max-width: 250px;
                                           background-color: #f7f7f7;
                                           border: none">
                                @foreach($url->seo as $key => $value)
                                    <option value="{{$value->id}}">{{$value->slug === '/'?'':$value->slug}}</option>
                                @endforeach
                                <option value="customOption">[добавить]</option>
                            </select><input name="slug" style="display:none;" disabled="disabled">
                            <form class="d-inline" id="form-slug" method="post">
                                @method('DELETE')
                                @csrf
                                <button id="btn-delete-slug"
                                        type="button"
                                        class="btn btn-sm btn-secondary">-
                                </button>
                            </form>
                        @endif
                        <a class="float-right btn btn-sm btn-outline-dark" href="{{url('admin')}}">&laquo; назад</a>
                    </div>
                    <div class="response">
                        @include('include.seo')
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
            "use strict";
            CKEDITOR.replace('exampleFormControlTextarea3');
            let btnDeleteSlug = $("button#btn-delete-slug");
            btnDeleteSlug.text('-');
            let new_slug = $('input[name="slug"]');
            let form = $('form#form-slug');

            function deleteSlug(option) {
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
                form.find('input[name=slug_id]').remove();
                let slug_id = option.value;
                if (option.innerText !== '') {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'slug_id';
                    input.value = slug_id;
                    form.append(input);
                    form.attr("action", "{{route('slug.delete')}}");
                    form.find('input[name="_method"]').val('DELETE');
                    btnDeleteSlug.attr({
                        'class': 'btn btn-sm btn-danger',
                        'type': 'submit',
                        'data-toggle': 'tooltip',
                        'data-placement': 'top',
                        'title': 'delete slug',
                        'data-original-title': 'delete slug'
                    });
                } else {
                    btnDeleteSlug.attr({
                        'class': 'btn btn-sm btn-secondary',
                        'type': 'button',
                        'data-toggle': 'tooltip',
                        'data-placement': 'top',
                        'title': 'no delete',
                        'data-original-title': 'no delete'
                    });
                }

            }

            new_slug.on('blur', function () {
                if (this.value === '') {
                    let select = this.previousSibling;
                    btnDeleteSlug.text('-');
                    deleteSlug(select.options[select.selectedIndex]);
                    toggleField(this, select);
                }
            });
            $('select#slug').on('change', function () {
                let _this = $(this);
                let option = this.options[this.selectedIndex];
                let url = "{{route('domain.show',$url->id)}}";
                let seo_id = _this.val();
                _this.find("option").removeAttr('selected');
                _this.find("option[value=" + seo_id + "]").attr('selected', 'true');
                ////start
                if (option.value === 'customOption') {
                    toggleField(this, this.nextSibling);
                    this.selectedIndex = '0';
                    seo_id = this.options[this.selectedIndex].value;
                    btnDeleteSlug.text('+');
                    btnDeleteSlug.click(function (e) {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'slug';
                        form.append(input);
                        input.value = new_slug.value;
                    });
                    form.attr("action", "{{route('slug.insert',$url->id)}}");
                    form.find('input[name="_method"]').val('PUT');
                    btnDeleteSlug.attr({
                        'class': 'btn btn-sm btn-success',
                        'type': 'submit',
                        'data-toggle': 'tooltip',
                        'data-placement': 'top',
                        'title': 'добавить slug',
                        'data-original-title': 'добавить slug'
                    });
                }
                ////end
                $.ajax({
                    url: url,
                    data: {
                        'seo_id': seo_id
                    },
                    success: function (data) {
                        if (!data.error) {
                            if (option.value !== 'customOption')
                                deleteSlug(option);
                            $(".response").html(data.response);
                            CKEDITOR.replace('exampleFormControlTextarea3');
                        } else {
                            alert('упс что то пошло не так , попробуйте перезагрузить страницу ');
                        }
                    }
                });
            });

            function toggleField(hideObj, showObj) {
                hideObj.disabled = true;
                hideObj.style.display = 'none';
                showObj.disabled = false;
                showObj.style.display = 'inline';
                showObj.focus();
                new_slug.on('keyup', function () {
                    new_slug.value = this.value;
                    // console.log(this.value)
                });
            }
        });


    </script>
@endpush
