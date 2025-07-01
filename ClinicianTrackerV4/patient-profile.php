<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/patient-profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>Patient Profile</title>
</head>
<body>
    <main>
        <section id="profile">
            <div id="profile-pic">
                <img src=<?php if($_SESSION["patient_gender"] === "m"){
                        echo "assets/male-profile-pic.jpeg";
                    }else if($_SESSION["patient_gender"] === "f"){
                        echo "assets/female-profile-pic.jpg";
                    }else{
                        echo "assets/male-profile-pic.jpeg";
                    }?> alt="profile picture fill in with blue background" width="300px" height="300px">
            </div>
            <div id="profile-basic-info">
                <div id="profile-identifiers">
                    <h3>Name: <?php echo htmlspecialchars($_SESSION["patient_first_name"]) . " " . htmlspecialchars($_SESSION["patient_last_name"]) ?></h3>
                    <p>Gender: <?php if($_SESSION["patient_gender"] === "m"){
                        echo "Male";
                    }else if($_SESSION["patient_gender"] === "f"){
                        echo "Female";
                    }else{
                        echo "Deferred Gender identification";
                    }?></p>                                       
                </div>
                <hr>
                <div>
                    <p>Diagnosis: <?php echo htmlspecialchars($_SESSION["patient_diagnosis"]) ?></p>                   
                </div>
                <hr>
                <div>
                    <p>Age: <?php echo htmlspecialchars($_SESSION["patient_age"])?></p>
                    <p>DOB: <?php echo htmlspecialchars($_SESSION["patient_dob"])?></p>
                </div>
                <hr>
                <div>
                    <p>Height (in): <?php echo htmlspecialchars($_SESSION["patient_height"]) ?></p>
                    <p>Weight (lb): <?php echo htmlspecialchars($_SESSION["patient_weight"])?></p>
                </div>
            </div>
            <hr>
            <div id = "button-container">
                <button id="patient-select-return">Return to Patient Selection</button>
                <button id="clinician-selection-return">Return to Clinician Selection</button>
            </div>
        </section>

        <section id="notes">
            <div id="notes-nav">
                <H2>Visit Notes</H2>
                <div>
                    <Button id="add-note">Add Note</Button>
                </div>
            </div>
            <div id="notes-holder">
                <ul id="notes-list">
                    <li>
                        <div class="visit-note">
                            <div class="visit-note-info">
                                <p>Visit Number: 1</p>
                                <p>Pain Level:5</p>
                                <p>Function Rating: 7</p>
                                <p>Goals Met: 0</p>
                                <p>Visit Date: </p>                              
                            </div>
                            <p>Summary: Lorem ipsum dolor sit, amet consectetur adipisicing elit. Rerum soluta libero doloremque cum quisquam voluptatum, quia architecto blanditiis, nesciunt praesentium necessitatibus minima perspiciatis iste quae fuga delectus laboriosam officiis ipsam.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <section id="charts">
            <h2>Patient Data Charts</h2>
            <div class = "chart-holder">
                <canvas class="chart" id="pain-chart"></canvas>    
            </div>
            <div class = "chart-holder">
                <canvas class="chart" id="function-chart"></canvas>    
            </div>


        </section>
    </main>

    <dialog id="add-note-window">
        <form action="">
            <h3>Add Patient Visit Note</h3>
            <div>
                <label for="visitNumber">Visit Number</label>
                <input id = "visitNumber" type="number" name="visitNumber" required>
                <label for="visitDate">Visit Date:</label>
                <input id="visitDate" type="date" name="visitDate" required>
            </div>
            <div class="column">
                <div>
                    <label for="painLevel">Pain Level(0-10):</label>
                    <input id="painLevel"type="number" max="10" name ="painLevel" required>                    
                </div>
                <div>
                    <label for="function">Function Rating(0-10):</label>
                    <input id="function"type="number" max="10" name ="function" required>                    
                </div>
                <div>
                    <label for="goals">Goals Met: </label>
                    <input id="goals"type="number" name ="goals" required>                       
                </div>                
            </div>
            <div class="column">
                <label for="summary">Visit Summary: </label>
                <textarea name="summary" id="summary" cols="60" rows="5" required></textarea>
            </div>
            <div class="modal-button-container">
                <button id="submit-note">Submit Note</button>
                <button id="return-add-note">Cancel</button>
            </div>
        </form>
    </dialog>

    <dialog id="edit-note-window">
        <form action="">
            <h3>Edit Patient Visit Note</h3>
            <div>
                <label for="visitNumber-edit">Visit Number</label>
                <input id = "visitNumber-edit" type="number" name="visitNumber" required>
                <label for="visitDate-edit">Visit Date:</label>
                <input id="visitDate-edit" type="date" name="visitDate" required>
            </div>
            <div class="column">
                <div>
                    <label for="painLevel-edit">Pain Level(0-10):</label>
                    <input id="painLevel-edit"type="number" max="10" name ="painLevel" required>                    
                </div>
                <div>
                    <label for="function-edit">Function Rating(0-10):</label>
                    <input id="function-edit"type="number" max="10" name ="function" required>                    
                </div>
                <div>
                    <label for="goals-edit">Goals Met: </label>
                    <input id="goals-edit"type="number" name ="goals" required>                       
                </div>                
            </div>
            <div class="column">
                <label for="summary-edit">Visit Summary: </label>
                <textarea name="summary-edit" id="summary-edit" cols="60" rows="5"></textarea>
            </div>
            <div class="modal-button-container">
                <button id="edit-note">Edit Note</button>
                <button id="delete-note">Delete Note</button>
                <button id="return-edit-note">Cancel</button>
            </div>
        </form>
    </dialog>

    <dialog id="error">
        <h3>Error:</h3>
        <p id="error-message"></p>
        <button id="error-exit">Return</button>
    </dialog>        
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="JS/patient-profile.js"></script>
</body>
</html>