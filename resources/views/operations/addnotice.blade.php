@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="text-align:center;  color: #007bff;  font-family: 'Arial', sans-serif;  font-size: 36px; font-weight: bold">Add Notice</h1>
    <div id="notice"></div>
        <div class="card">
            <div class="card-header">
            <form method="post" action="addnotice">
              @csrf
                <div class="mb-3">
                  <label for="title" class="form-label">Title</label>
                  <input type="text" name="notice_title" class="form-control" id="notice_title" >
                </div>
                <div class="mb-3">
                  <label for="content" class="form-label">Content</label>
                  <input type="text" name="notice_content" class="form-control" id="notice_content" style="height: 300px">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
</div>
@endsection
