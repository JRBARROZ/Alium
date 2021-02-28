let clicks = 0;
function showForm(e) {
    e.style.display = "none";
    document.querySelector('#text').style.display = "none";
    document.querySelector('#form').style.display = "block";
    document.querySelector('#edit').style.display = "block";
}

function showAboutForm() {
    document.querySelector('#about-form').style.display = "block";
    document.querySelector('#hide-about-form').style.display = "block";
    document.querySelector('#edit-button').style.display = "none";
    document.querySelector('#about-content').style.display = "none";
}

function hideAboutForm() {
    document.querySelector('#about-form').style.display = "none";
    document.querySelector('#hide-about-form').style.display = "none";
    document.querySelector('#edit-button').style.display = "block";
    document.querySelector('#about-content').style.display = "block";
}

function showContactsForm() {
    document.querySelector('#contacts-form').style.display = "flex";
    document.querySelector('#hide-contacts-form').style.display = "flex";
    document.querySelector('#edit-contacts-button').style.display = "none";
    document.querySelector('#contacts-content').style.display = "none";
}
function hideContactsForm() {
    document.querySelector('#contacts-form').style.display = "none";
    document.querySelector('#hide-contacts-form').style.display = "none";
    document.querySelector('#edit-contacts-button').style.display = "block";
    document.querySelector('#contacts-content').style.display = "block";
}
function showEvaluateForm() {
    document.querySelector('.evaluate').style.display = "block";
    document.querySelector('.btn').style.display = "none";
}
function hideEvaluateForm() {
    document.querySelector('.evaluate').style.display = "none";
    document.querySelector('.btn').style.display = "block";   
}
//Imgs
function displayImg(e) {
    // e.parentElement.style.backgroundImage = "";
    let file = e;
    let teste = URL.createObjectURL(file.files[0]);
    console.log(teste);
    e.parentElement.style.backgroundImage = "url(" + teste + ")";
    insertImg(e);
}
function insertImg(e) {
    const endPoint = 'uploadImgs.php';
    const formData = new FormData();
    formData.append('images[]', e.files[0]);
    formData.append('id', e.id);
    fetch(endPoint, {
        method: 'post',
        body: formData
    }).catch(console.error);
}
function previewShow(e) {
    const profileForm = document.querySelector('.profile-form');
    const profilePreview = document.querySelector('#profile-preview');
    if (clicks == 0) {
        e.innerHTML = 'Cancelar Preview';
        profileForm.style.display = "none";
        profilePreview.style.display = "block";
        clicks++;
    } else {
        e.innerHTML = 'Preview';
        clicks = 0;
        profileForm.style.display = "flex";
        profilePreview.style.display = "none";
    }
}