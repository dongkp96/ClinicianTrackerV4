<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <title>Clinician Log-in</title>
</head>
<body>

    <main id="clinician-list"class="display-flex">
        <div class="title-container">
            <h2>Clinician Selection</h2>
        </div>
        <div class ="list-container">
            <ul class="list">
            </ul>
        </div>
        <div class="button-container">
            <button id="add">Add Clinician</button>
            <button id="select">Select Clinician</button>
        </div>
    </main>

        <dialog id="clinician-creation" class="display-none">
            <h2>Clinician Registration</h2>
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
                    <label for="username">Username:</label>
                    <input id="username" name="username" type="text" required>
                </div>
                <div>
                    <label for="passkey">Password:</label>
                    <input id="passkey" type="password" name="passkey" required> 
                </div>
                <div class="button-container-secondary">
                    <button id="register">Submit Registration</button>
                    <button id="register-return">Cancel</button>
                </div>
            </form>

        </dialog>

        <dialog id="clinician-select" class="display-none">
            <h2>Clinician Selected</h2>
            <h3 class="clinician-display">Clinician Info</h3>
            <div class="button-container-secondary">
                <button id="login-go">Clinician Login</button>
                <button id="delete">Delete</button>
                <button id="select-return">Cancel</button>
            </div>            
        </dialog>

        <dialog id="clinician-login"class="display-none">
            <h2>Clinician Login</h2>
            <div>
                <h3 class="clinician-display-login"></h3>
            </div>
            <form action="" class="display-flex">
                <div>
                    <label for="login-username">Username:</label>
                    <input id="login-username" name="username" type="text" required>                    
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" required>                    
                </div>
                <div class="button-container-secondary">
                    <button id="login">Login</button>
                    <button id="login-return">Cancel</button>                    
                </div>
            </form>
        </dialog>

        <dialog id="error">
            <h3>Error:</h3>
            <p id="error-message"></p>
            <button id="error-exit">Return</button>
        </dialog>

        <script src="JS/index.js"></script>

</body>
</html>