import retrieveData from './retrieve_data.js';

let form = document.getElementById("signinForm");
form.addEventListener("submit", function (e) {
    e.preventDefault();
    let args = retrieveData(new FormData(form));
});