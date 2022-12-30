let imagesNum = 1;
let imagesUploaded = 0;

function displayImageForms() {
    const div = document.getElementById('images-form');
    for (let i = 0; i < 5; i++) {
        if (i == 0) {
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + i + '\' name=\'image-input' + i + '\' onclick=\'showUploadedImage(' + i + ')\' onchange=\'updateUploadedImagesCounter(' + i + ')\'/>';
        } else {
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + i + '\' name=\'image-input' + i + '\' onclick=\'showUploadedImage(' + i + ')\' onchange=\'updateUploadedImagesCounter(' + i + ')\' hidden=\'true\'/>';
        }
        div.innerHTML += '<img id=\'image-element' + i + '\' name=\'image-element' + i + '\' hidden=\'true\'></img>';
        div.innerHTML += '<button type=\'button\' id=\'left-arrow' + i + '\' onclick=\'moveImageFormToLeft(' + i + ')\' hidden=\'true\'><span class=\'fa-regular fa-arrow-left\'></span></button>';
        div.innerHTML += '<button type=\'button\' id=\'trash-can' + i + '\' onclick=\'deleteImageForm(' + i + ')\' hidden=\'true\'><span class=\'fa-regular fa-trash-can\'></span></button>';
        div.innerHTML += '<button type=\'button\' id=\'right-arrow' + i + '\' onclick=\'moveImageFormToRight(' + i + ')\' hidden=\'true\'><span class=\'fa-regular fa-arrow-right\'></span></button>';
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
    }
    checkAddButton();
    checkRequiredImageForms();
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
            message.innerHTML = "Upload an image to the existing form first";
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
    swapImageForms('#image-input' + index + '', '#image-input' + previous + '', 'image-input' + index + '', 'image-input' + previous + '', index, previous);
    swapImageForms('#image-element' + index + '', '#image-element' + previous + '', 'image-element' + index + '', 'image-element' + previous + '', index, previous);
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
    swapImageForms('#image-input' + next + '', '#image-input' + index + '', 'image-input' + next + '', 'image-input' + index + '', next, index);
    swapImageForms('#image-element' + next + '', '#image-element' + index + '', 'image-element' + next + '', 'image-element' + index + '', next, index);
    imageFormsRefresh();
}

function swapImageForms(element1Id, element2Id, element1Name, element2Name, element1Index, element2Index) {
    let element1 = document.querySelector(element1Id);
    let element2 = document.querySelector(element2Id);
    let placeholder = document.createElement('div');
    element1.parentNode.insertBefore(placeholder, element1);
    element2.parentNode.insertBefore(element1, element2);
    placeholder.parentNode.insertBefore(element2, placeholder);
    placeholder.remove();
    //swapping IDs
    let element1IdNoHashtag = element1Id.replace(/#/g, '');
    let element2IdNoHashtag = element2Id.replace(/#/g, '');
    element1 = document.getElementById(element1IdNoHashtag);
    element2 = document.getElementById(element2IdNoHashtag);
    element1.id = '' + element2IdNoHashtag + '';
    element2.id = '' + element1IdNoHashtag + '';
    //swapping names
    element1.name = '' + element2Name + '';
    element2.name = '' + element1Name + '';
    //updating onclicks and onchanges
    element1.setAttribute('onclick', 'showUploadedImage(' + element2Index + ')');
    element2.setAttribute('onclick', 'showUploadedImage(' + element1Index + ')');
    element1.setAttribute('onchange', 'updateUploadedImagesCounter(' + element2Index + ')');
    element2.setAttribute('onchange', 'updateUploadedImagesCounter(' + element1Index + ')');
}

function updateImageFormsCounter() {
    document.getElementById('images-counter').innerHTML = imagesNum + '/5';
}

function showUploadedImage(index) {
    const imageInput = document.getElementById('image-input' + index + '');
    const imageElement = document.getElementById('image-element' + index + '');
    imageInput.addEventListener('input', () => {
        const file = imageInput.files[0];
        const reader = new FileReader();
        reader.onload = () => {
            imageElement.src = reader.result;
        };
        reader.readAsDataURL(file);
        imageElement.hidden = false;
    });
}

function updateUploadedImagesCounter(index) {
    let imageInput = document.getElementById('image-input' + index + '');
    if (imageInput.files.length == 1 && imageInput.files[0] != undefined) {
        imagesUploaded++;
    }
    if (document.getElementById('message') != null && imagesUploaded == imagesNum) {
        document.getElementById('message').remove();
    }
}