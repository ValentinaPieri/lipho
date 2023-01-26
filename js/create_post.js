import { showSnackbar } from "./utils.js";

const addImageButton = document.getElementById("add-image-button");
const imagesContainer = document.getElementById("images-container");
const captionTextArea = document.getElementById("caption");
const maxLength = captionTextArea.maxLength;
const remainingCharactersSpan = document.getElementById("remaining-characters");
const createPostButton = document.getElementById("create-post-button");

let images = [];
const MAX_IMAGES = 5;

addImageButton.onclick = addImage;

captionTextArea.oninput = function () {
    remainingCharactersSpan.innerText = captionTextArea.value.length + "/" + maxLength;
}

createPostButton.onclick = createPost;

function addImage() {
    let fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.id = "file-input";
    fileInput.accept = ".jpg, .jpeg, .png";
    fileInput.onchange = function () {
        let file = fileInput.files[0];
        let reader = new FileReader();
        reader.onload = function () {
            images.push(reader.result.substring(reader.result.indexOf(',') + 1));
            showImage(images.length - 1);
            refreshArrowButtons();
            if (images.length >= MAX_IMAGES) {
                addImageButton.hidden = true;
            }
        }
        reader.readAsDataURL(file);
    }
    fileInput.click();
}

function removeImage(imageIndex) {
    let imageContainer = document.getElementById('post-image-container' + imageIndex);
    imageContainer.remove();
    images.splice(imageIndex, 1);

    if (images.length < MAX_IMAGES) {
        addImageButton.hidden = false;
    }

    refreshIndexes();
    refreshArrowButtons();
}

function showImage(index) {
    let imageContainer = document.createElement('div');
    imageContainer.id = 'post-image-container' + index;
    imageContainer.className = 'post-image-container';

    let imageElement = document.createElement('img');
    imageElement.id = 'image-element' + index;
    imageElement.alt = 'Image ' + index;
    imageElement.src = "data:images/jpeg;base64," + images[index];

    let postButtonsContainer = document.createElement('div');
    postButtonsContainer.className = 'post-buttons-div';

    let removeButton = document.createElement("button");
    removeButton.className = "icon-button remove-button";
    removeButton.id = "remove-button" + index;
    removeButton.type = "button";

    let removeButtonIcon = document.createElement("span");
    removeButtonIcon.className = "fa-regular fa-trash-alt";
    removeButton.onclick = function () {
        removeImage(index);
    };

    removeButton.appendChild(removeButtonIcon);
    postButtonsContainer.appendChild(removeButton);
    imageContainer.appendChild(postButtonsContainer);
    imageContainer.appendChild(imageElement);
    imagesContainer.appendChild(imageContainer);
}

function refreshIndexes() {
    let imageContainers = document.getElementsByClassName('post-image-container');
    for (let i = 0; i < imageContainers.length; i++) {
        imageContainers[i].id = 'post-image-container' + i;
        let imageElement = imageContainers[i].querySelector('img');
        imageElement.id = 'image-element' + i;
        imageElement.src = "data:images/jpeg;base64," + images[i];
        imageElement.alt = 'Image ' + i;
        let removeButton = imageContainers[i].querySelector("[id^='remove-button']");
        removeButton.id = 'remove-button' + i;
        removeButton.onclick = function () {
            removeImage(i);
        };
    }
}

function refreshArrowButtons() {
    let moveButtons = document.querySelectorAll("[id^='move-']");
    moveButtons.forEach(function (button) {
        button.remove();
    });

    let postButtonsContainers = document.getElementsByClassName('post-buttons-div');
    if (postButtonsContainers.length > 1) {
        for (let i = 0; i < postButtonsContainers.length; i++) {
            if (i == 0) {
                postButtonsContainers[i].appendChild(getMoveDownButton(i));
            } else if (i == postButtonsContainers.length - 1) {
                postButtonsContainers[i].appendChild(getMoveUpButton(i));
            } else {
                postButtonsContainers[i].appendChild(getMoveUpButton(i));
                postButtonsContainers[i].appendChild(getMoveDownButton(i));
            }
        }
    }
}

function getMoveUpButton(imageIndex) {
    let moveUpButton = document.createElement("button");
    moveUpButton.className = "icon-button";
    moveUpButton.id = "move-up-button" + imageIndex;
    moveUpButton.type = "button";

    let moveUpButtonIcon = document.createElement("span");
    moveUpButtonIcon.className = "fa-solid fa-arrow-up";
    moveUpButton.onclick = function () {
        moveImageUp(imageIndex);
    }

    moveUpButton.appendChild(moveUpButtonIcon);
    return moveUpButton;
}


function moveImageUp(imageIndex) {
    let imageContainer = document.getElementById('post-image-container' + imageIndex);
    let previousImageContainer = imageContainer.previousElementSibling;
    imagesContainer.insertBefore(imageContainer, previousImageContainer);
    let temp = images[imageIndex];
    images[imageIndex] = images[imageIndex - 1];
    images[imageIndex - 1] = temp;
    refreshIndexes();
    refreshArrowButtons();
}

function getMoveDownButton(imageIndex) {
    let moveDownButton = document.createElement("button");
    moveDownButton.className = "icon-button";
    moveDownButton.id = "move-down-button" + imageIndex;
    moveDownButton.type = "button";

    let moveDownButtonIcon = document.createElement("span");
    moveDownButtonIcon.className = "fa-solid fa-arrow-down";
    moveDownButton.onclick = function () {
        moveImageDown(imageIndex);
    }

    moveDownButton.appendChild(moveDownButtonIcon);
    return moveDownButton;
}

function moveImageDown(imageIndex) {
    let imageContainer = document.getElementById('post-image-container' + imageIndex);
    let nextImageContainer = imageContainer.nextElementSibling;
    imagesContainer.insertBefore(nextImageContainer, imageContainer);
    let temp = images[imageIndex];
    images[imageIndex] = images[imageIndex + 1];
    images[imageIndex + 1] = temp;
    refreshIndexes();
    refreshArrowButtons();
}

function createPost() {
    let args = {
        createPost: true,
        images: images,
        caption: document.getElementById('caption').value,
    }

    if (images.length == 0) {
        showSnackbar('Please add at least one image');
    } else {
        $.post('./post_requests_handler.php', args, function () {
            location.reload();
        });
    }
}
