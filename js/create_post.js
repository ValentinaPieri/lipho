let imagesNum = 1;
let imagesUploaded = 0;

updateImageFormsCounter();
displayImageForms();
checkAddButton();

function displayImageForms() {
    const div = document.getElementById('images-form');
    for (let i = 0; i < 5; i++) {
        let imageFormDiv = document.createElement('div');
        imageFormDiv.className = 'image-form-div';
        let inputButtonsDiv = document.createElement('div');
        inputButtonsDiv.className = 'input-buttons-div';
        if (i == 0) {
            let imageInput = document.createElement('input');
            imageInput.title = 'Image input form ' + i;
            imageInput.ariaLabel = 'Image input form ' + i;
            imageInput.type = 'file';
            imageInput.className = 'form-control';
            imageInput.id = 'image-input' + i;
            imageInput.name = 'image-input' + i;
            imageInput.onclick = function () {
                showUploadedImage(i);
            };
            imageInput.onchange = function () {
                updateUploadedImagesCounter(i);
            };
            imageFormDiv.appendChild(imageInput);
            inputButtonsDiv.appendChild(imageInput);
        } else {
            let imageInput = document.createElement('input');
            imageInput.title = 'Image input form ' + i;
            imageInput.ariaLabel = 'Image input form ' + i;
            imageInput.type = 'file';
            imageInput.className = 'form-control';
            imageInput.id = 'image-input' + i;
            imageInput.name = 'image-input' + i;
            imageInput.onclick = function () {
                showUploadedImage(i);
            };
            imageInput.onchange = function () {
                updateUploadedImagesCounter(i);
            };
            imageInput.hidden = true;
            imageFormDiv.appendChild(imageInput);
            inputButtonsDiv.appendChild(imageInput);
        }
        let imageDiv = document.createElement('div');
        imageDiv.className = 'image-div';
        let imageElement = document.createElement('img');
        imageElement.src = 'resources/images/blankspace.jpg';
        imageElement.id = 'image-element' + i;
        imageElement.alt = 'Image ' + i;
        imageElement.hidden = true;
        imageElement.style.display = 'none';
        imageFormDiv.appendChild(imageElement);
        imageDiv.appendChild(imageElement);
        imageDiv.style.display = 'none';

        let leftArrow = document.createElement('button');
        leftArrow.type = 'button';
        leftArrow.id = 'left-arrow' + i;
        leftArrow.onclick = function () {
            moveImageFormToLeft(i);
        };
        leftArrow.hidden = true;
        let leftArrowIcon = document.createElement('span');
        leftArrowIcon.className = 'fa-regular fa-arrow-left';
        leftArrow.appendChild(leftArrowIcon);
        imageFormDiv.appendChild(leftArrow);
        inputButtonsDiv.appendChild(leftArrow);
        let trashCan = document.createElement('button');
        trashCan.type = 'button';
        trashCan.id = 'trash-can' + i;
        trashCan.onclick = function () {
            deleteImageForm(i);
        };
        trashCan.hidden = true;
        let trashCanIcon = document.createElement('span');
        trashCanIcon.className = 'fa-regular fa-trash-can';
        trashCan.appendChild(trashCanIcon);
        imageFormDiv.appendChild(trashCan);
        inputButtonsDiv.appendChild(trashCan);
        let rightArrow = document.createElement('button');
        rightArrow.type = 'button';
        rightArrow.id = 'right-arrow' + i;
        rightArrow.onclick = function () {
            moveImageFormToRight(i);
        };
        rightArrow.hidden = true;
        let rightArrowIcon = document.createElement('span');
        rightArrowIcon.className = 'fa-regular fa-arrow-right';
        rightArrow.appendChild(rightArrowIcon);
        imageFormDiv.appendChild(rightArrow);
        inputButtonsDiv.appendChild(rightArrow);
        imageFormDiv.appendChild(imageDiv);
        imageFormDiv.appendChild(inputButtonsDiv);
        div.appendChild(imageFormDiv);
    }
    checkRequiredImageForms();
}

function imageFormsRefresh() {
    for (let i = 0; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').hidden != true) {
            document.getElementById('left-arrow' + i + '').hidden = false;
            document.getElementById('trash-can' + i + '').hidden = false;
            document.getElementById('right-arrow' + i + '').hidden = false;
        }
    }
    for (let i = 0; i < 5; i++) {
        let index = i;
        if (document.getElementById('image-input' + --index + '') == null) {
            index++;
            document.getElementById('left-arrow' + i + '').hidden = true;
        } else {
            let noneShown = true;
            for (let j = index; j >= 0; j--) {
                if (document.getElementById('image-input' + j + '').hidden != true) {
                    noneShown = false;
                    break;
                }
            }
            if (noneShown) {
                document.getElementById('left-arrow' + i + '').hidden = true;
            }
            index++;
        }
        if (document.getElementById('image-input' + ++index + '') == null) {
            index--;
            document.getElementById('right-arrow' + i + '').hidden = true;
        } else {
            let noneShown = true;
            for (let j = index; j < 5; j++) {
                if (document.getElementById('image-input' + j + '').hidden != true) {
                    noneShown = false;
                    break;
                }
            }
            if (noneShown) {
                document.getElementById('right-arrow' + i + '').hidden = true;
            }
            index--;
        }
        checkAddButton();
        checkRequiredImageForms();
    }
}

function checkAddButton() {
    if (imagesNum < 5) {
        document.getElementById('add-button').hidden = false;
    } else {
        document.getElementById('add-button').hidden = true;
    }
}

function addImageForm() {
    if (imagesUploaded == imagesNum) {
        for (let i = 1; i < 5; i++) {
            if (document.getElementById('image-input' + i + '').hidden == true) {
                document.getElementById('image-input' + i + '').hidden = false;
                document.getElementById('left-arrow' + i + '').hidden = false;
                document.getElementById('trash-can' + i + '').hidden = false;
                document.getElementById('right-arrow' + i + '').hidden = false;
                imagesNum++;
                checkAddButton();
                break;
            }
        }
        imageFormsRefresh();
        updateImageFormsCounter();
    } else {
        if (document.getElementById("message") == null) {
            let container = document.getElementById("caption-form");
            let message = document.createElement("p");
            message.id = "message";
            message.textContent = "Upload an image to the existing form first";
            let firstChild = container.firstChild;
            container.insertBefore(message, firstChild);
        }
    }
}

function deleteImageForm(index) {
    if (--imagesNum > 0) {
        document.getElementById('image-input' + index + '').hidden = true;
        if ((document.getElementById('image-input' + index + '')).value != '') {
            document.getElementById('image-input' + index + '').value = '';
            document.getElementById('image-element' + index + '').hidden = true;
            document.getElementById('image-element' + index + '').style.display = 'none';
            document.getElementsByClassName('image-div')[index].style.display = 'none';
            document.getElementsByClassName('input-buttons-div')[index].style.display = 'none';
            imagesUploaded--;
        }
        document.getElementById('left-arrow' + index + '').hidden = true;
        document.getElementById('trash-can' + index + '').hidden = true;
        document.getElementById('right-arrow' + index + '').hidden = true;
        if (imagesNum == 1) {
            for (let i = 0; i < 5; i++) {
                document.getElementById('trash-can' + i + '').hidden = true;
            }
        }
    } else {
        imagesNum++;
    }
    imageFormsRefresh();
    updateImageFormsCounter();
}

function checkRequiredImageForms() {
    for (let i = 0; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').required == true) {
            document.getElementById('image-input' + i + '').required = false;
        }
    }
    for (let i = 0; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').hidden != true) {
            document.getElementById('image-input' + i + '').required = true;
            break;
        }
    }
}

function moveImageFormToLeft(index) {
    let previous;
    index--;
    for (i = index; i >= 0; i--) {
        if (document.getElementById('image-input' + i + '').hidden != true) {
            previous = i;
            break;
        }
    }
    index++;
    swapImageForms('image-input' + index + '', 'image-input' + previous + '', index, previous);
    swapImageForms('image-element' + index + '', 'image-element' + previous + '', index, previous);
    imageFormsRefresh();
}

function moveImageFormToRight(index) {
    let next;
    index++;
    for (i = index; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').hidden != true) {
            next = i;
            break;
        }
    } +
        index--;
    swapImageForms('image-input' + next + '', 'image-input' + index + '', next, index);
    swapImageForms('image-element' + next + '', 'image-element' + index + '', next, index);
    imageFormsRefresh();
}

function swapImageForms(element1Id, element2Id, index1, index2) {
    let element1 = document.getElementById(element1Id);
    let element2 = document.getElementById(element2Id);
    let placeholder = document.createElement('div');
    element1.parentNode.insertBefore(placeholder, element1);
    element2.parentNode.insertBefore(element1, element2);
    placeholder.parentNode.insertBefore(element2, placeholder);
    placeholder.remove();
    element1.id = '' + element2Id + '';
    element2.id = '' + element1Id + '';
    if (element1Id.includes('image-input') && element2Id.includes('image-input')) {
        element1.name = '' + element2Id + '';
        element2.name = '' + element1Id + '';
        element1.onclick = function () {
            showUploadedImage(index2);
        };
        element2.onclick = function () {
            showUploadedImage(index1);
        };
        element1.onchange = function () {
            updateUploadedImagesCounter(index2);
        };
        element2.onchange = function () {
            updateUploadedImagesCounter(index1);
        };
        element1.title = 'Image input form ' + index2 + '';
        element2.title = 'Image input form ' + index1 + '';
        element1.ariaLabel = 'Image input form ' + index2 + '';
        element2.ariaLabel = 'Image input form ' + index1 + '';
    } else if (element1Id.includes('image-element') && element2Id.includes('image-element')) {
        element1.alt = 'Image ' + index2 + '';
        element2.alt = 'Image ' + index1 + '';
    }
}

function updateImageFormsCounter() {
    document.getElementById('images-counter').innerHTML = imagesNum + '/5';
}

function showUploadedImage(index) {
    const imageInput = document.getElementById('image-input' + index + '');
    const imageElement = document.getElementById('image-element' + index + '');
    imageInput.oninput = function () {
        const file = imageInput.files[0];
        const reader = new FileReader();
        reader.onload = () => {
            imageElement.src = reader.result;
        };
        reader.readAsDataURL(file);
        imageElement.hidden = false;
        imageElement.style.display = 'block';
        document.getElementsByClassName('image-div')[index].style.display = 'flex';
    };
}

function updateUploadedImagesCounter(index) {
    imagesUploaded = 0;
    for (let i = 0; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').files.length == 1 && document.getElementById('image-input' + i + '') != undefined) {
            imagesUploaded++;
        }
    }
    if (document.getElementById('message') != null && imagesUploaded == imagesNum) {
        document.getElementById('message').remove();
    }
}
