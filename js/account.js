 image=document.querySelector("img" ),
    input=document.querySelector("input");

   input.addEventListener("change", () =>{
    image.src= URL.createObjectURL(input.files[0]);
 });
var username = document.querySelector('#username')
var email = document.querySelector('#email')
var password = document.querySelector('#password')
var form=document.querySelector('form')

 function showError(input,message){
   let parent=input.parentElement;
   let small=parent.querySelector('small')
   parent.classList.add('error')
   small.innerText=message
 }
 function showSucces(input,message){
   let parent=input.parentElement;
   let small=parent.querySelector('small')
   parent.classList.remove('error')
   small.innerText=''
 }
 
 function checkEmptyError(listInput){
   let isEmptyError=false
   listInput.forEach(input=>{
      input.value=input.value.trim()
      if(!input.value){
         isEmptyError=true;
       showError(input,'dont empty')
      }
      else{
         showSucces(input)
      }
   });
   return isEmptyError
 }
 // check mail//
 function checkEmailError(input){
   const regexEmail =
  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  input.value=input.value.trim()
  let isEmailError=!regexEmail.test(input.value)
  if(regexEmail.test(input.value)){
   showSucces(input)
  }
  else{
   showError(input,'Email Invalid')
  }
  return isEmailError
}
//check độ dài username//
function checkLengthError(input, min ){
   input.value=input.value.trim()
    if(input.value.length<min){
      showError(input,' least 4 characters ')
      return true
    }
    
    return false
}
//check độ dài pass//
function checkLengthPassError(input, min ){
   input.value=input.value.trim()
    if(input.value.length<min){
      showError(input,' least 8 characters ')
      return true
    }
    
    return false
}
 console.log(form)
 if(form){
 form.addEventListener('submit',function(e){
       e.preventDefault()

      
      let isEmptyError=checkEmptyError([username, email, password])
      let isEmailError=checkEmailError(email) 
      let isUsernameLengthError=checkLengthError(username,4) 
      let isPasswordLengthError=checkLengthPassError(password,8)
      if(isEmailError||isEmailError||isUsernameLengthError||isPasswordLengthError){
            //do nothing
         
      }else{
         
      }
      

   })
   }


 /* check mail,check pass*//*
 const form=document.getElementById('form');
 const username=document.getElementById('username');
 const email=document.getElementById('email');
 const password=document.getElementById('password');
 form.addEventListener('button',e=>{
   e.preventDefault();
   ValidateInputs();
 });
  const setError=(elemet,message)=>{
    const containerControl=elemet.parenElement;
    const errorDisplay=containerControl.querySelector('.error');
    errorDisplay.innerText=message;
    containerControl.classList.remove('success');
     containerControl.classList.add('error');
  };
  const isValidemail=email =>{
   const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
   return re.test(String(email).toLowerCase());
  }
 const ValidateInputs=() =>{
   const username=username.value.trim();
   const emailValue=email.value.trim();
   const passwordValue=password.value.trim();
   if(usernnameValue===''){
      setError(username,'Username is reuired');
   }
   else{
    setSucces(username);
   }
   if(emailValue===''){
      setError(email,'Email is required');
   }
   else if(!isValidemail(emailValue)){
      setError(email,'Provide a valid email address');
   }
   else{
      setSucces(email);
   }
   if(passwordValue===''){
       setError(password,'Password is required');
   }
   else if(passwordValue.lenght<8){
      setError(password,'Password must be at least 8 character.')
   }

 }*/
 /*
 function verifyPassword() {  
   var pw = document.getElementById("pass").value;  
   //check empty password field  
   if(pw == "") {  
      document.getElementById("message").innerHTML = "**Fill the password please!";  
      return false;  
   }  
    
  //minimum password length validation  
   if(pw.length < 8) {  
      document.getElementById("message").innerHTML = "**Password length must be atleast 8 characters";  
      return false;  
   }  
   
 //maximum length of password validation  
   if(pw.length > 15) {  
      document.getElementById("message").innerHTML = "**Password length must not exceed 15 characters";  
      return false;  
   } else {  
      alert("Password is correct");  
   }  
 } */ 