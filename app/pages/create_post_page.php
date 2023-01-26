<div class="create-post-container">
    <div class="images-form">
        <h2>Pictures</h2>
        <p id='images-counter'></p>
        <button type='button' class="icon-button add-image-button" id='add-image-button'>
            <span class='fa-regular fa-circle-plus'></span>
        </button>
    </div>
    <div id='images-container' class="images-container">
    </div>
    <div id='caption-form' class="caption-form">
        <h2>Caption</h2>
        <div class="textarea">
            <textarea id='caption' name='caption' maxlength="200" title="caption" aria-label="caption"></textarea>
            <span id="remaining-characters" class="remaining-characters">0/200</span>
        </div>
    </div>
    <button type='button' class='text-button' id='create-post-button'>Post</button>
</div>
