// =========================
// REGISTER
// =========================

const registerForm = document.getElementById("registerForm");
const registerMsg = document.getElementById("registerMsg");

if(registerForm){

const role = document.getElementById("role");
const name = document.getElementById("name");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirmPassword");
const passwordHint = document.getElementById("passwordHint");

password.addEventListener("input", ()=>{

    if(password.value.length < 8){
        passwordHint.style.display = "block";
    }else{
        passwordHint.style.display = "none";
    }

});

registerForm.addEventListener("submit", e=>{
    e.preventDefault();

    if(password.value !== confirmPassword.value){
        registerMsg.innerText = "Passwords do not match";
        return;
    }

    let formData = new FormData();
    formData.append("role", role.value);
    formData.append("name", name.value);
    formData.append("email", email.value);
    formData.append("phone", phone.value);
    formData.append("password", password.value);

    fetch("api/register.php",{
        method:"POST",
        body:formData
    })
    .then(res=>res.text())
    .then(data=>{

        if(data=="success"){
    window.location.href="login.html";
}else{
    registerMsg.innerText=data;
}


    });
});

}

// =========================
// LOGIN
// =========================

const loginForm = document.getElementById("loginForm");
const loginMsg = document.getElementById("loginMsg");

if(loginForm){

const loginEmail = document.getElementById("loginEmail");
const loginPassword = document.getElementById("loginPassword");

loginForm.addEventListener("submit", e=>{
    e.preventDefault();

    let formData = new FormData();
    formData.append("email",loginEmail.value);
    formData.append("password",loginPassword.value);

    fetch("api/login.php",{
        method:"POST",
        body:formData
    })
    .then(res=>res.text())
    .then(data => {
    if(data === "admin"){
        window.location.href = "admin_dashboard.php";
    }else if(data === "success"){
        window.location.href = "dashboard.php";
    }else{
        loginMsg.innerText = data;
    }
});


});

}

// =========================
// TOGGLE PASSWORD
// =========================

function togglePassword(id,icon){
    let field=document.getElementById(id);
    if(field.type=="password"){
        field.type="text";
        icon.innerText="🙈";
    }else{
        field.type="password";
        icon.innerText="👁";
    }
}


// =========================
// PHONE VERIFICATION
// =========================

const verifyForm = document.getElementById("verifyForm");
const msg = document.getElementById("msg");

if(verifyForm){

verifyForm.addEventListener("submit", function(e){
    e.preventDefault();

    let formData = new FormData();
    formData.append("code", document.getElementById("code").value);

    fetch("api/verify-phone.php",{
        method:"POST",
        body:formData
    })
    .then(res=>res.text())
    .then(data=>{

        if(data=="success"){
            alert("Phone verified!");
            window.location.href="login.html";
        }else{
            msg.innerText=data;
        }

    });

});

}
