<div class="col-md-4">
    <div class="card">
        <div class="card-header">Домены</div>
        <div class="card-body">
            @foreach($urls as $url)
                <a style="overflow: hidden" title="{{$url->domain}}" href="{{route('domain.show',$url->id)}}"
                   class="{{ request()->is("admin/domain/{$url->id}") ? 'active' : '' }} domain-links btn btn-outline-primary btn-block position-relative">{{$url->domain}}</a>
            @endforeach
            <button id="add" class="btn btn-outline-dark btn-block">+</button>
        </div>
    </div>
</div>
@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').on('click', '#add', function () {
                let _add = $(this);
                let url = "{{route('domain.add')}}";
                let token = "{{ csrf_token() }}";
                $(this).replaceWith(
                    '<form class="pt-md-2 input-group" method="post" id="domain" action="' + url + '">\n' +
                    '<input type="hidden" name="_token" id="csrf-token" value="' + token + '" />' +
                    '  <input type="text" class="form-control" placeholder="domain.com" name="domain" required>\n' +
                    '  <div class="input-group-append">\n' +
                    '    <button class="btn btn-success btn-sm" type="submit">' +
                    '       <span aria-hidden="true">&#10003;</span>' +
                    '    </button>\n' +
                    '    <button id="close" class="btn btn-danger btn-sm" type="button">' +
                    '       <span aria-hidden="true">&times;</span>' +
                    '   </button>\n' +
                    '  </div>\n' +
                    '</form>'
                );
                $('#close').on('click', function () {
                    $('form#domain').replaceWith(_add);
                });
            });
            $('.domain-links').on('click', function () {
                $("a.domain-links").removeClass("active");
                $(this).addClass('active');
            })
        });

    </script>
@endpush
