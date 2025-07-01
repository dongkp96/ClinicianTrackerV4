
/*Clinician selection windows */
const clinicianHome = document.getElementById("clinician-list");
const clinicianCreate = document.getElementById("clinician-creation");
const clinicianSelect =document.getElementById("clinician-select");
const login = document.getElementById("clinician-login");
const errorDialog = document.getElementById("error");


/*buttons to be selected */

//main page buttons
const addBtn = document.getElementById("add");
const selectBtn = document.getElementById("select");

//register dialog buttons
const registerBtn = document.getElementById("register");
const registerReturnBtn = document.getElementById("register-return");

//selected page buttons
const loginGoBtn = document.getElementById("login-go");
const selectReturnBtn = document.getElementById("select-return");
const deleteBtn = document.getElementById("delete");

//login page buttons
const loginBtn = document.getElementById("login");
const loginReturnBtn = document.getElementById("login-return");

//Error messaging dialog items
const errorMsg = document.getElementById("error-message");
const errorMsgBtn = document.getElementById("error-exit");

/*list containing clinician names to be selected*/
const clinicianList = document.querySelector(".list");

/*Functions */

async function getClinicians(){//Retrieves clinician data and renders clinician list
    try{
        const results = await fetch("PHP/Clinicians/getClinicians.php");

        const clinicians = await results.json(); 

        const clinicianList = document.querySelector(".list");
        clinicianList.innerHTML ="";

        clinicians.forEach(clinician => {
            const listItem = document.createElement("li");
            listItem.textContent = `${clinician.first_name} ${clinician.last_name}`;
            listItem.classList.add(`clinician-${clinician.clinician_id}`);
            clinicianList.appendChild(listItem);
        });
    }catch(error){
        alert(error);
    }
};


async function addClinicians(newClinician){// used to add clinician info to the database
    try{
        const response = await fetch("PHP/Clinicians/addClinicians.php",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body:JSON.stringify(newClinician)
        });

        const result = await response.json();
        return result;

    }catch(error){
        return {success: false};
    }

};

async function deleteClinician(clinician){//deletes clinician from database
    try{
        const response = await fetch("PHP/Clinicians/deleteClinicians.php",{
            method: "POST",
            headers:{
                "Content-Type": "application/json"
            },
            body: JSON.stringify(clinician)
        });

        const result = await response.json();
        return result;
    }catch(error){
        return {success: false};
    }
}

async function loginClinician(loginInfo){// function for logging in
    try{
        const response = await fetch("PHP/Clinicians/login.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(loginInfo)
        });

        const result = await response.json();
        return result;

    }catch(error){
        alert(error);
    }
}


/*event listeners*/

//main page buttons
addBtn.addEventListener("click", (e)=>{//switches display to clinician registration
    e.preventDefault();

    clinicianCreate.classList.toggle("display-none");
    clinicianCreate.classList.toggle("display");
    clinicianHome.classList.toggle("display-flex");
    clinicianHome.classList.toggle("display-none");

});

selectBtn.addEventListener("click", (e)=>{//switches display to login Go or delete clinician
    e.preventDefault();

    if(document.getElementById("selected")){
        clinicianHome.classList.toggle("display-flex");
        clinicianHome.classList.toggle("display-none");
        clinicianSelect.classList.toggle("display-none");
        clinicianSelect.classList.toggle("display");

        const clinicianInfo= document.getElementById("selected").textContent;
        document.querySelector(".clinician-display").textContent= clinicianInfo;
        document.querySelector(".clinician-display-login").textContent = clinicianInfo;        
    }else{
        errorMsg.textContent = "No Clinician Selected";
        errorDialog.showModal();
    }
});

//registration dialog buttpns

registerReturnBtn.addEventListener("click", async (e)=>{//brings back from registration page
    e.preventDefault();

    await getClinicians();
    clinicianCreate.classList.toggle("display-none");
    clinicianCreate.classList.toggle("display");
    clinicianHome.classList.toggle("display-flex");
    clinicianHome.classList.toggle("display-none");

});

registerBtn.addEventListener("click", async (e)=>{//used to register and add clinician info to DB
    e.preventDefault();

    const first = document.getElementById("firstName").value;
    const last = document.getElementById("lastName").value;
    const username = document.getElementById("username").value;
    const passkey = document.getElementById("passkey").value;

    if(!first||!last||!username||!passkey){
        errorMsg.textContent = "Input field(s) left unfilled. Please fill out all sections";
        errorDialog.showModal();        
    }else{
        const newClinician = {
            first_name:first,
            last_name:last,
            username:username,
            passkey: passkey
        };

        const result = await addClinicians(newClinician);
        
        if(result.success){  
            document.getElementById("firstName").value = "";
            document.getElementById("lastName").value ="";
            document.getElementById("username").value = "";
            document.getElementById("passkey").value ="";

            await getClinicians();
            clinicianCreate.classList.toggle("display-none");
            clinicianCreate.classList.toggle("display");
            clinicianHome.classList.toggle("display-flex");
            clinicianHome.classList.toggle("display-none");
        }else{
            errorMsg.textContent = "Username has already been used. Please try another username";
            errorDialog.showModal();
        }                
    };
});

//Clinician selected diaolog page buttons
selectReturnBtn.addEventListener("click", async (e)=>{//returns from select display
    e.preventDefault();

    await getClinicians();
    clinicianSelect.classList.toggle("display-none");
    clinicianSelect.classList.toggle("display");
    clinicianHome.classList.toggle("display-flex");
    clinicianHome.classList.toggle("display-none");   
});

loginGoBtn.addEventListener("click", (e)=>{//switches display to login form
    e.preventDefault();

    login.classList.toggle("display-none");
    login.classList.toggle("display");
    clinicianSelect.classList.toggle("display-none");
    clinicianSelect.classList.toggle("display");    
    
});

deleteBtn.addEventListener("click", async (e)=>{//triggers deleting clinician
    e.preventDefault();

    const clinician = document.getElementById("selected");
    const clinicianClass = clinician.getAttribute("class");
    const id = clinicianClass.split("-").pop();

    const deletedClinician = {
        id: id
    }
    
    const result = await deleteClinician(deletedClinician);
    if(result.success){
        await getClinicians();
        clinicianSelect.classList.toggle("display-none");
        clinicianSelect.classList.toggle("display");
        clinicianHome.classList.toggle("display-flex");
        clinicianHome.classList.toggle("display-none");  
    }
    


});

//login dialog buttons
loginReturnBtn.addEventListener("click", (e)=>{
    e.preventDefault();

    login.classList.toggle("display-none");
    login.classList.toggle("display");
    clinicianSelect.classList.toggle("display-none");
    clinicianSelect.classList.toggle("display");       
});

loginBtn.addEventListener("click", async(e)=>{//triggers login
    e.preventDefault();

    const username = document.getElementById("login-username").value;
    const password = document.getElementById("password").value;

    if(!username||!password){
        if(!username && !password){
            errorMsg.textContent = "No login information provided";
            errorDialog.showModal();
        }else if(!username){
            errorMsg.textContent = "No Username entered";
            errorDialog.showModal();
            document.getElementById("login-username").value = "";
            document.getElementById("password").value = "";    
        }else{
            errorMsg.textContent = "No password entered";
            document.getElementById("login-username").value = "";
            document.getElementById("password").value = "";
            errorDialog.showModal(); 
        }
    }else{
        const loginInfo = {
            username: username,
            password: password
        }

        const result = await loginClinician(loginInfo);

        if(result.success){
            document.getElementById("login-username").value = "";
            document.getElementById("password").value = "";
            window.location.href = "patient-selection.php";
        }else{
            document.getElementById("login-username").value = "";
            document.getElementById("password").value = "";
            errorMsg.textContent = "Invalid Password";
            errorDialog.showModal(); 
        }        
    }
});

errorMsgBtn.addEventListener("click", (e)=>{//closes error modal
    e.preventDefault();

    errorDialog.close();
})




//clinician list

clinicianList.addEventListener("click", (e)=>{//allows clinician list items to get selected ID
    
    if(document.getElementById("selected")){
        const lastSelected = document.getElementById("selected");
        lastSelected.removeAttribute("id");
        const newSelected = e.target;
        newSelected.setAttribute("id", "selected");
    }else{
        const newSelected = e.target;
        newSelected.setAttribute("id", "selected");
    }
});


document.addEventListener("DOMContentLoaded", async ()=>{//loads clinician list when page loads

    await getClinicians();

});


