@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>Users</h1>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
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
                                                @foreach ($urls->getData()->data as $url)
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
                                                        <td>{{ $url->short_url }}</td>
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
            var form =  $(this).closest("form");
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
