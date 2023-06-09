@extends('adminlte::page')

@section('title', 'Short Urls')

@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            @if (is_array(session('success')))
                <ul>
                    @foreach (session('success') as $index => $message)
                        <li id="{{ $index }}">{{ $message }}</li>{!! $index == 'short_url'
                            ? '<button class="btn btn-secondary" onclick="copyUrl()">Copy url to clipboard</button>'
                            : '' !!}
                    @endforeach
                </ul>
            @else
                {{ session('success') }}
            @endif
        </div>
    @endif
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="get" action="">
                        <input type="search" class="form-control" placeholder="Search" name="search" value="{{old('search')}}">
                    </form>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline"
                                            aria-describedby="example2_info">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>Short Url</th>
                                                    <th>Long Url</th>
                                                    <th>Expires On</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($urls->data as $url)
                                                    <tr>
                                                        <td width="20px">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <form method="post"
                                                                action="{{ route('shortUrl.destroy', $url->id) }}"
                                                                style="display: initial;">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="delete btn btn-danger btn-sm" type="submit"
                                                                    title="Delete" onclick="">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <td><a href="{{ $url->short_url }}" target="_blank">{{ $url->short_url }}</a></td>
                                                        <td>{{ $url->long_url }}</td>
                                                        <td>{{ $url->expires_on }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>Short Url</th>
                                                    <th>Long Url</th>
                                                    <th>Expires On</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                @foreach ($urls->meta->links as $link)
                                    @if (!$link->active && $link->url != null)
                                        <a href="{{ $link->url }}" class="btn btn-primary">{!! $link->label !!}</a>
                                    @else
                                        <a class="btn btn-secondary">{!! $link->label !!}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(document.body).on('click', '.delete', function(event) {
            event.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit()
                }
            })
        });
    </script>
@stop
