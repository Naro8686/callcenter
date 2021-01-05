<div class="card-body">
    <form action="{{route('domain.seo',$seo->id)}}" method="post">
        @csrf
        <input type="hidden" name="url_id" value="{{$url->id}}">
        <div class="form-group">
            <label for="exampleFormControlInput1">Title</label>
            <input type="text" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   id="exampleFormControlInput1" value="{{$seo->title}}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror"
                      name="description" id="exampleFormControlTextarea1"
                      rows="3">{{$seo->description}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea2">Keywords</label>
            <textarea class="form-control @error('keywords') is-invalid @enderror" name="keywords"
                      id="exampleFormControlTextarea2"
                      rows="3">{{$seo->keywords}}</textarea>
        </div>
        <div class="form-group @if($url->domain === 'yurkonsultatsia.ru') d-none @endif">
            <label for="exampleFormControlTextarea3">Текст для сайта </label>
            <textarea class="form-control @error('text') is-invalid @enderror" name="text"
                      id="exampleFormControlTextarea3"
                      rows="3">{{$seo->text}}</textarea>
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
