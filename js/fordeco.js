const container = document.querySelector(".container");
const eyeShow = document.querySelectorAll(".eye");
const pwFields = document.querySelectorAll(".password");
const registration = document.querySelector(".register-link");
const login = document.querySelector(".login-link");

eyeShow.forEach(eyeIcon =>{
	eyeIcon.addEventListener("click", ()=>{
		pwFields.forEach(pwField =>{
			if(pwField.type ==="password"){
				pwField.type = "text";
				
				eyeShow.forEach(icon =>{
					icon.classList.replace("uil-eye-slash", "uil-eye");
				})
			}else{
				pwField.type = "password";
			
				eyeShow.forEach(icon =>{
					icon.classList.replace("uil-eye", "uil-eye-slash");
				})
			}
		})
	})
})

registration.addEventListener("click", ( )=>{
	container.classList.add("active");
});

login.addEventListener("click", ( )=>{
	container.classList.remove("active");
});
