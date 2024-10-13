<!-- resources/views/joints/create.blade.php -->

@extends('layouts.base')

@section('content')
    <h1>Create or Edit Joint</h1>

    <form action="{{ isset($joint) ? route('joints.update', $joint->id) : route('joints.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($joint))
            @method('PUT')
        @endif

        <!-- Other form fields -->

        <div class="form-group">
            <label for="file">File</label>
            <input type="file" name="file" id="file" class="form-control" accept=".jpeg,.jpg,.png,.gif,.svg,.pdf,.doc,.docx">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    @if (isset($joint) && $joint->file)
        <h1>Joint Details</h1>
        @if (in_array(pathinfo($joint->file, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'svg']))
            <img src="{{ asset($joint->file) }}" alt="File" style="max-width: 150px; max-height: 150px;">
        @else
            <a href="{{ asset($joint->file) }}" target="_blank">Download File</a>
        @endif
    @endif
@endsection
