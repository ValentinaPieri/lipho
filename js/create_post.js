const addImageButton = document.getElementById("add-image-button");
const imagesContainer = document.getElementById("images-container");

let images = [];
const MAX_IMAGES = 5;

addImageButton.onclick = addImage;

function addImage() {
    let fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.id = "file-input";
    fileInput.accept = "image/*";
    fileInput.onchange = function () {
        let file = fileInput.files[0];
        let reader = new FileReader();
        reader.onload = function () {
            images.push(reader.result);
            showImage(images.length - 1);
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
}

function showImage(index) {
    let imageContainer = document.createElement('div');
    imageContainer.id = 'post-image-container' + index;
    imageContainer.className = 'post-image-container';

    let imageElement = document.createElement('img');
    imageElement.id = 'image-element' + index;
    imageElement.alt = 'Image ' + index;
    imageElement.src = images[index];

    let postButtonsContainer = document.createElement('div');
    postButtonsContainer.className = 'post-buttons-div';

    let removeButton = document.createElement("button");
    removeButton.className = "icon-button post-button";
    removeButton.id = "remove-button" + index;
    removeButton.type = "button";

    let removeButtonIcon = document.createElement("span");
    removeButtonIcon.className = "fa-regular fa-trash-alt";
    removeButton.onclick = function () {
        removeImage(index);
    };

    if (index == MAX_IMAGES - 1) {
        let moveUpButton = document.createElement("button");
        moveUpButton.className = "icon-button post-button";
        moveUpButton.id = "move-up-button" + index;
        moveUpButton.type = "button";
        //TODO: add arrowbutons
    }

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
        imageElement.src = images[i];
        imageElement.alt = 'Image ' + i;
        let removeButton = imageContainers[i].querySelector("[id^='remove-button']");
        removeButton.id = 'remove-button' + i;
        removeButton.onclick = function () {
            removeImage(i);
        };
    }
}
