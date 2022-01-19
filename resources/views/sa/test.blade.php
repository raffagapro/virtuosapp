@extends('layouts.app')

@section('content')
<div class="container">
    <form id="retroFrom" action="{{ route('sa.testFile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="homeworkId" value=28>
        <div class="form-group">
            <label for="exampleFormControlFile1">Example file input</label>
            <input type="file" class="form-control-file" name="testfile">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    @isset($url)
        <h1>{{ $url }}</h1>
        <img src="{{ asset($url) }}" alt="">
    @endisset

    @if(session('url'))
        <h1>{{ session('url') }}</h1>
        <img src="{{ asset( session('url') ) }}" alt="">
	@endif

    <a href="{{ route('sa.testFileDel') }}">delete Image</a>
</div>
@endsection