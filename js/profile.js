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
function requestData(){
    fetch('getProfileImgs.php')
    .then(res=> res.json())
    .then((res) => {
        showImgsData(res);
    })
    .catch((error) => console.log(error))
}
function showImgsData(value){
    const profilePreview = document.querySelector('.profile-preview');
    profilePreview.innerHTML = "";
    console.log(value);
    if(value == ""){
        const p = document.createElement("p")
        p.innerHTML = "Você ainda não adicionou nenhuma imagem.";
        profilePreview.appendChild(p);
    }else{
        profilePreview.innerHTML = "";
        for(let i = 0; i < value.length; i++){
            const div = document.createElement('div');
            div.style.backgroundImage = "";
            div.className = "profile-preview-item";
            div.style.backgroundImage = `url('./images/portfolio/user_port_${value[i]['user_id']}/${value[i]['name']}?${value[i]['updated_at']}')`;
            profilePreview.appendChild(div);
        }
    }
}
function displayImg(e) {
    
    e.parentElement.style.backgroundImage = "";
    let file = e;
    let teste = URL.createObjectURL(file.files[0]);
    let feedback = document.querySelector('#perfil-feed');
    console.log(teste);
    e.parentElement.style.backgroundImage = "url(" + teste + ")";
    feedback.style.display = "block";
    setTimeout(function(){ 
        feedback.style.display = "none";
    }, 3000);
    insertImg(e);
    setTimeout(function(){ 
         requestData();
     }, 1000);
    
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
        requestData()
    } else {
        e.innerHTML = 'Preview';
        clicks = 0;
        profileForm.style.display = "flex";
        profilePreview.style.display = "none";
    }
    
}