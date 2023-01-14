<form action='post_requests_handler.php' method='post' enctype='multipart/form-data'>

    <div id='images-form'>
        <h2>Pictures</h2>
        <p id='images-counter'></p>
        <button type='button' class='form-control' id='add-button' onclick='addImageForm()'><span class='fa-regular fa-circle-plus'></span></button>
    </div>

    <div id='caption-form'>
        <h2><label for='caption'>Caption</label></h2>
        <textarea class='form-control' id='caption' name='caption'></textarea>
    </div>

    <button type='submit' class='btn' name='post-button'>Post</button>
</form>
