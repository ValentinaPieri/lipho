let imagesNum = 1;

function displayImagesForms() {
    const div = document.getElementById('images-form');
    for (let i = 0; i < 5; i++) {
        if (i == 0) {
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + i + '\' name=\'image\'/>';
        } else {
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + i + '\' name=\'image\'/>';
            document.getElementById('image-input' + i + '').style.display = 'none';
        }
        div.innerHTML += '<button type=\'button\' id=\'left-arrow' + i + '\' onclick=\'moveImageToLeft(' + i + ')\'><i class=\'fa-regular fa-arrow-left\'></i></button>';
        document.getElementById('left-arrow' + i + '').style.display = 'none';
        div.innerHTML += '<button type=\'button\' id=\'trash-can' + i + '\' onclick=\'deleteImage(' + i + ')\'><i class=\'fa-regular fa-trash-can\'></i></button>';
        document.getElementById('trash-can' + i + '').style.display = 'none';
        div.innerHTML += '<button type=\'button\' id=\'right-arrow' + i + '\' onclick=\'moveImageToRight(' + i + ')\'><i class=\'fa-regular fa-arrow-right\'></i></button>';
        document.getElementById('right-arrow' + i + '').style.display = 'none';
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
    checkImagesAdded();
    checkRequiredImages();
}

function checkImagesAdded() {
    if (imagesNum < 5) {
        document.getElementById('add-button').style.display = 'inline-block';
    } else {
        document.getElementById('add-button').style.display = 'none';
    }
}

function addImage() {
    for (let i = 4; i >= 0; i--) {
        if (document.getElementById('image-input' + i + '').style.display == 'none') {
            document.getElementById('image-input' + i + '').style.display = 'inline-block';
            document.getElementById('left-arrow' + i + '').style.display = 'inline-block';
            document.getElementById('trash-can' + i + '').style.display = 'inline-block';
            document.getElementById('right-arrow' + i + '').style.display = 'inline-block';
            imagesNum++;
            checkImagesAdded();
            break;
        }
    }
    imagesRefresh();
}

function deleteImage(index) {
    if (--imagesNum > 0) {
        document.getElementById('image-input' + index + '').style.display = 'none';
        (document.getElementById('image-input' + index + '')).value != '' ? document.getElementById('image-input' + index + '').value = '' : null;
        document.getElementById('left-arrow' + index + '').style.display = 'none';
        document.getElementById('trash-can' + index + '').style.display = 'none';
        document.getElementById('right-arrow' + index + '').style.display = 'none';
        if (imagesNum == 1) {
            for (let i = 0; i < 5; i++) {
                document.getElementById('trash-can' + i + '').style.display == 'none';
            }
        }
    } else {
        imagesNum++;
    }
    imagesRefresh();
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
    --index;
    let previous;
    for (let i = index; i >= 0; i--) {
        if (document.getElementById('image-input' + i + '').style.display != 'none') {
            previous = i;
            break;
        }
    }
    index++;
    const element1 = document.querySelector('#image-input' + index + '');
    const element2 = document.querySelector('#image-input' + previous + '');
    const placeholder = document.createElement('div');
    element1.parentNode.insertBefore(placeholder, element1);
    element2.parentNode.insertBefore(element1, element2);
    placeholder.parentNode.insertBefore(element2, placeholder);
    placeholder.remove();
    imagesRefresh();
}

function moveImageToRight(index) {
    ++index;
    let next;
    for (let i = index; i < 5; i++) {
        if (document.getElementById('image-input' + i + '').style.display != 'none') {
            next = i;
            break;
        }
    }
    index--;
    const element1 = document.querySelector('#image-input' + index + '');
    const element2 = document.querySelector('#image-input' + next + '');
    const placeholder = document.createElement('div');
    element1.parentNode.insertBefore(placeholder, element1);
    element2.parentNode.insertBefore(element1, element2);
    placeholder.parentNode.insertBefore(element2, placeholder);
    placeholder.remove();
    imagesRefresh();
}