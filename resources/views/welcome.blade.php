@extends('layouts.front')
@section('after_styles')
@endsection
@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <h1>
                <i class="fa fa-link" aria-hidden="true"></i>
            </h1>
            <h2>Url Shortner</h2>
            <p class="lead">
                Copy paste an url to shorten it
            </p>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                @if (is_array(session('success')))
                    <ul>
                        @foreach (session('success') as $index => $message)
                            <li id="{{$index}}">{{ $message }}</li>{!!$index=='short_url'?'<button class="btn btn-secondary" onclick="copyUrl()">Copy url to clipboard</button>':""!!}
                        @endforeach
                    </ul>
                @else
                    {{ session('success') }}
                @endif
            </div>
        @endif
        <form method="post" action="{{ route('shortUrl.create') }}">
            <div class="row">
                <div class="col-md-12">

                    <label for="url">URL</label>
                    @csrf
                    <input type="url" name="url" id="url" value="{{ old('url') ?? '' }}" class="form-control"
                        required />
                    @error('url')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <h5>Expires On</h5>
                <div class="col-md-4">
                    <label for="hours">Hours <small>(Enter time in hours)</small></label>
                    <input type="number" name="hours" id="hours" value="{{ old('hours') ?? '' }}"
                        class="form-control" />
                    @error('hours')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="minutes">Minutes <small>(Enter time in minutes)</small></label>
                    <input type="number" name="minutes" id="minutes" value="{{ old('minutes') ?? '' }}"
                        class="form-control" />
                    @error('minutes')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="seconds">Seconds <small>(Enter time in seconds)</small></label>
                    <input type="number" name="seconds" id="seconds" value="{{ old('seconds') ?? '' }}"
                        class="form-control" />
                    @error('seconds')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <input type="submit" class="btn btn-primary" value="Shorten" />
                </div>
            </div>
        </form>
    </div>
@endsection
@section('after_scripts')
    <script>
        function copyUrl() {
            navigator.clipboard.writeText({!!isset(session('success')['short_url'])?('"'.session('success')['short_url'].'"'):''!!});
            alert("Copied the url: " + {!!isset(session('success')['short_url'])?('"'.session('success')['short_url'].'"'):''!!});
        }
    </script>
@endsection
