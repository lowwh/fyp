<form method="post" enctype="multipart/form-data" action="/uploadphoto/{{$users['id']}}">
    @csrf
    <label for="image" class="form-label">Service Image: </label>
    <input type="file" name="image" id="image" class="form-control"><br>
    <span style="color:red">@error('image'){{$message}}@enderror</span><br>
    <button type="submit">upload</button>
</form>