<form method="post" enctype="multipart/form-data" action="/uploadphoto/{{$users['id']}}" style="text-align: center;">
    @csrf
    <label for="image" class="form-label">Service Image: </label>
    <input type="file" name="image" id="image" class="form-control"><br>
    <span style="color:red">@error('image'){{$message}}@enderror</span><br>

    <!-- Wrap the button in a div for flexbox centering -->
    <div class="button-container">
        <button type="submit">Upload</button>
    </div>
</form>

<!-- Add the CSS for flexbox centering -->
<style>
    .button-container {
        display: flex;
        justify-content: center;
        /* Center the button horizontally */
        margin-top: 10px;
        /* Optional: Add some space above the button */
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center align items in the form */
    }
</style>