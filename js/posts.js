let imagesNum = 1;

function displayImagesForms() {
    const div = document.getElementById('images-form');
    for (let i = 0; i < 5; i++) {
        if (i == 0) {
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + i + '\' name=\'image\' style="display: inline-block"/>';
        } else {
            div.innerHTML += '<input type=\'file\' class=\'form-control\' id=\'image-input' + i + '\' name=\'image\' style="display: none"/>';
        }
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
    for (let i = 4; i >= 0; i--) {
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
    element1 = document.getElementById('image-input' + index + '');
    element2 = document.getElementById('image-input' + previous + '');
    element1.id = 'image-input' + previous + '';
    element2.id = 'image-input' + index + '';
}

function imagesCounter() {
    document.getElementById('images-counter').innerHTML = imagesNum + '/5';
}