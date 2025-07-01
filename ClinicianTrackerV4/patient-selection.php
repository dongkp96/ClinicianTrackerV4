<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/patient-select.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>Patient Selection</title>
</head>
<body>

    <main id="patient-list"class="display-flex">
        <div class="title-container">
            <h3><?php echo $_SESSION['clinician_first_name'] . " " . $_SESSION['clinician_last_name'] . "'s " ?>Patient Selection</h3>
        </div>
        <div class ="list-container">
            <ul class="list">
            </ul>
        </div>
        <div class="button-container">
            <div>
                <button id="add">Add Patient</button>
                <button id="select">Select Patient</button>                
            </div>
            <div>
                <button id="clinician-selection-return">Logout</button>
            </div>                     
        </div>      
    </main>

        <dialog id="patient-creation" class="display-none">
            <h2>Patient Registration</h2>
            <form class="display-flex" action="">
                <div>
                   <label for="firstName">First Name:</label>
                   <input id="firstName" name="firstName" placeholder ="John" type="text" required> 
                </div>
                <div>
                    <label for="lastName">Last Name:</label>
                    <input id="lastName" name="lastName" placeholder="Doe" type="text" required>
                </div>
                <div>
                    <label for="diagnosis">Diagnosis:</label>
                    <input id="diagnosis" name="diagnosis" type="text" required>
                </div>
                <div>
                    <label for="weight">Weight (lb):</label>
                    <input id="weight" type="number" max="1500" name="weight" required> 
                </div>
                <div>
                    <label for="height">Height (in):</label>
                    <input id="height" type="number" max="100" name="height" required> 
                </div>
                <div>
                    <label for="age">Age:</label>
                    <input id="age" type="number" max="120" name="age" required> 
                </div>
                <div>
                    <label for="dob">DOB:</label>
                    <input id="dob" type="date" name ="dob" required>
                </div>
                <div>
                    <span>Gender:</span>
                    <label for="male">Male</label>
                    <input id="male" type="radio" name="gender" value ="m">
                    <label for="female">Female</label>
                    <input id="female" type="radio" name="gender" value ="f">
                    <label for="other">Prefer Not to Specify</label>
                    <input id="other" type="radio" name="gender" value="o">                    
                </div>                
                <div class="button-container-secondary">
                    <button id="register">Add Patient</button>
                    <button id="register-return">Cancel</button>
                </div>
            </form>
        </dialog>

        <dialog id="patient-select" class="display-none">
            <h2>Patient Selected</h2>
            <h3 class="patient-display">Patient Info</h3>
            <div class="button-container-secondary">
                <button id="profile-go">Patient Profile</button>
                <button id="delete">Delete</button>
                <button id="select-return">Cancel</button>
            </div>            
        </dialog>
        
        <dialog id="error">
            <h3>Error:</h3>
            <p id="error-message"></p>
            <button id="error-exit">Return</button>
        </dialog>        

        <script src="JS/patient-select.js"></script>

</body>
</html>