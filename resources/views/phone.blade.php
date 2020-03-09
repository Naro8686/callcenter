@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label class="float-left">
                            Phone
                        </label>
                        <form class="btn-group-sm float-right" action="{{route('phone.upload')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input id="upload" type="file" name="upload" class="btn" required>
                            <button class="btn btn-primary">отправить</button>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th class="p-2" scope="col">#</th>
                                <th class="p-2" scope="col">Имя</th>
                                <th class="p-2" scope="col">Тел.</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
