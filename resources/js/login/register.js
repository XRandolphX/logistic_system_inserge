

function registrar() {
    var email = document.getElementById("email").value;
    var contra = document.getElementById("contrasena").value;

    
    
    firebase.auth().createUserWithEmailAndPassword(email, contra)
    .then((userCredential) => {
        // Signed in 
        var user = userCredential.user;
        
        // ...
    })
    .catch((error) => {
        var errorCode = error.code;
        var errorMessage = error.message;
        console.log(errorCode + ' '+ errorMessage);
        // ..
    });
} 