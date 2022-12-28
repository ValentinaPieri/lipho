let imagesNum = 1;
let imagesUploaded = 0;

function displayImagesForms() {
    const div = document.getElementById('images-form');
    for (let i = 0; i < 5; i++) {
        if (i == 0) {
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + i + '\' name=\'image\' onclick=\'showUploadedImages(' + i + ')\' onchange=\'uploadsCounter(' + i + ')\' style="display: inline-block"/>';
        } else {
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + i + '\' name=\'image\' onclick=\'showUploadedImages(' + i + ')\' onchange=\'uploadsCounter(' + i + ')\' style="display: none"/>';
        }
        div.innerHTML += '<img id=\'image-element' + i + '\'></img>';
        div.innerHTML += '<button type=\'button\' id=\'left-arrow' + i + '\' onclick=\'moveImageToLeft(' + i + ')\' style="display: none"><i class=\'fa-regular fa-arrow-left\'></i></button>';
        div.innerHTML += '<button type=\'button\' id=\'trash-can' + i + '\' onclick=\'deleteImage(' + i + ')\' style="display: none"><i class=\'fa-regular fa-trash-can\'></i></button>';
        div.innerHTML += '<button type=\'button\' id=\'right-arrow' + i + '\' onclick=\'moveImageToRight(' + i + ')\' style="display: none"><i class=\'fa-regular fa-arrow-right\'></i></button>';
    }
    checkRequiredImages();
}

function imagesRefresh() {
    for (let i = 0; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').style.display != 'none') {
            document.getElementById('left-arrow' + i + '').style.display = 'inline-block';
            document.getElementById('trash-can' + i + '').style.display = 'inline-block';
            document.getElementById('right-arrow' + i + '').style.display = 'inline-block';
        }
    }
    for (let i = 0; i < 5; i++) {
        let index = i;
        if (document.getElementById('image-input' + --index + '') == null) {
            index++;
            document.getElementById('left-arrow' + i + '').style.display = 'none';
        } else { //checking if no image forms are shown before the current one so to remove the current one left arrow
            let noneshown = true;
            for (let j = index; j >= 0; j--) {
                if (document.getElementById('image-input' + j + '').style.display != 'none') {
                    noneshown = false;
                    break;
                }
            }
            if (noneshown) {
                document.getElementById('left-arrow' + i + '').style.display = 'none';
            }
            index++;
        }
        if (document.getElementById('image-input' + ++index + '') == null) {
            index--;
            document.getElementById('right-arrow' + i + '').style.display = 'none';
        } else { //checking if no image forms are shown after the current one so to remove the current one right arrow
            let noneshown = true;
            for (let j = index; j < 5; j++) {
                if (document.getElementById('image-input' + j + '').style.display != 'none') {
                    noneshown = false;
                    break;
                }
            }
            if (noneshown) {
                document.getElementById('right-arrow' + i + '').style.display = 'none';
            }
            index--;
        }
    }
    checkAddButton();
    checkRequiredImages();
}

function checkAddButton() {
    if (imagesNum < 5) {
        document.getElementById('add-button').style.display = 'inline-block';
    } else {
        document.getElementById('add-button').style.display = 'none';
    }
}

function addImage() {
    if (imagesUploaded == imagesNum) {
        for (let i = 1; i < 5; i++) {
            if (document.getElementById('image-input' + i + '').style.display == 'none') {
                document.getElementById('image-input' + i + '').style.display = 'inline-block';
                document.getElementById('left-arrow' + i + '').style.display = 'inline-block';
                document.getElementById('trash-can' + i + '').style.display = 'inline-block';
                document.getElementById('right-arrow' + i + '').style.display = 'inline-block';
                imagesNum++;
                checkAddButton();
                break;
            }
        }
        imagesRefresh();
        imagesCounter();
    } else {
        window.alert('Upload an image to the existing form first');
    }
}

function deleteImage(index) {
    if (--imagesNum > 0) {
        document.getElementById('image-input' + index + '').style.display = 'none';
        if ((document.getElementById('image-input' + index + '')).value != '') {
            document.getElementById('image-input' + index + '').value = '';
            document.getElementById('image-element' + index + '').style.display = 'none';
            imagesUploaded--;
        }
        document.getElementById('left-arrow' + index + '').style.display = 'none';
        document.getElementById('trash-can' + index + '').style.display = 'none';
        document.getElementById('right-arrow' + index + '').style.display = 'none';
        if (imagesNum == 1) {
            for (let i = 0; i < 5; i++) {
                document.getElementById('trash-can' + i + '').style.display = 'none';
            }
        }
    } else {
        imagesNum++;
    }
    imagesRefresh();
    imagesCounter();
}

function checkRequiredImages() {
    for (let i = 0; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').required == true) {
            document.getElementById('image-input' + i + '').required = false;
        }
    }
    for (let i = 0; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').style.display != 'none') {
            document.getElementById('image-input' + i + '').required = true;
            break;
        }
    }
}

function moveImageToLeft(index) {
    let previous;
    index--;
    for (i = index; i >= 0; i--) {
        if (document.getElementById('image-input' + i + '').style.display != 'none') {
            previous = i;
            break;
        }
    }
    index++;
    swap('#image-input' + index + '', '#image-input' + previous + '', index, previous);
    swap('#image-element' + index + '', '#image-element' + previous + '', index, previous);
    imagesRefresh();
}

function moveImageToRight(index) {
    let next;
    index++;
    for (i = index; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').style.display != 'none') {
            next = i;
            break;
        }
    } +
        index--;
    swap('#image-input' + next + '', '#image-input' + index + '', next, index);
    swap('#image-element' + next + '', '#image-element' + index + '', next, index);
    imagesRefresh();
}

function swap(element1Id, element2Id, index, previous) {
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
    let element1IdNoNumbers = element1IdNoHashtag.replace(/[0-9]/g, '');
    let element2IdNoNumbers = element2IdNoHashtag.replace(/[0-9]/g, '');
    element1.id = '' + element1IdNoNumbers + previous + '';
    element2.id = '' + element2IdNoNumbers + index + '';
}

function imagesCounter() {
    document.getElementById('images-counter').innerHTML = imagesNum + '/5';
}

function showUploadedImages(index) {
    const imageInput = document.getElementById('image-input' + index + '');
    const imageElement = document.getElementById('image-element' + index + '');
    imageInput.addEventListener('input', () => {
        const file = imageInput.files[0];
        const reader = new FileReader();
        reader.onload = () => {
            imageElement.src = reader.result;
        };
        reader.readAsDataURL(file);
        if (imageElement.style.display == 'none') {
            imageElement.style.display = 'inline-block';
        }
    });
}

function uploadsCounter(index) {
    let imageInput = document.getElementById('image-input' + index + '');
    if (imageInput.files.length == 1 && imageInput.files[0] != undefined) {
        imagesUploaded++;
    }
}