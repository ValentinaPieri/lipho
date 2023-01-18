<form class="create-post-form" action='post_requests_handler.php' method='post' enctype='multipart/form-data'>
    <div class="images-form">
        <h2>Pictures</h2>
        <p id='images-counter'></p>
        <button type='button' class="icon-button" id='add-image-button'>
            <span class='fa-regular fa-circle-plus'></span>
        </button>
    </div>
    <div id='images-container' class="images-container">
    </div>

    <div id='caption-form'>
        <h2><label for='caption'>Caption</label></h2>
        <textarea id='caption' name='caption'></textarea>
    </div>

    <button type='submit' class='text-button' name='createPost'>Post</button>
</form>
