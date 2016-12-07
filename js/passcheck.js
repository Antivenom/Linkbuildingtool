function checkPass(){
	var pass1 = document.getElementById('password');
	var pass2 = document.getElementById('password2');
	var message = document.getElementById('ConfirmMessage');

	var Color_Good = "#26ff00";
	var Color_Rekt = "#ff1405";

	if(pass1.value == pass2.value){
		pass1.style.borderColor = Color_Good;
		pass2.style.borderColor = Color_Good;
        message.style.borderColor = Color_Good;
        message.innerHTML = " &#x2714;";
	}else{
		pass1.style.borderColor = Color_Rekt;
        pass2.style.borderColor = Color_Rekt;
        message.style.borderColor = Color_Rekt;
        message.innerHTML = " &#x2718;";
    }
}