<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="c2.css">
</head>
<body>
   
    <div class="container">
        <div class="nav">
    <ul>
        <a><span class="blue-logo"></span> Your Personal Blog<span class="blue">.</span></a>
        <a class="gray" href="index.php">Home</a>
        
    </ul>
</div>
        <div class="hero">
            <div class="text">
                <p class="gray">START FOR FREE</p>
                <h1>Create new account <span class="blue">.</span></h1>
                <p  class="gray">Already A Member ? <span class="blue" onclick="location.href='login.php'">Log in</span></p>
            </div>
            <div class="form">        
    <form action="signup.php" method="POST">
        <div class="name">
            <div class="input-icons">
                <legend for="first">Username   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-lines-fill" viewBox="0 0 10 16" style="margin-right: 30px;">
                         <path
                              d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                   </svg>
                </legend>
              
                <div class="icon-center">
                    <input class="input" type="text" id="username" name="username" required>
                    
                </div>
            </div>
            
</div>

        <div class="id">
            <div class="input-icons">
                <legend for="email">Email  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-envelope-fill" viewBox="0 0 16 16">
                        <path
                            d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                    </svg></legend>
                <div class="icon-center">
                    <input class="input" type="email" id="email" name="email" required>
                   
                </div>
            </div>
            <div class="input-icons">
                <legend for="password">Password  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-eye-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                        <path
                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                    </svg></legend>
                <div class="icon-center">
                    <input class="input" type="password" id="password" name="password" required>
                   
                </div>
            </div>
        </div>

        <div class="buttons">
            
            <button type="submit" value="Sign Up" class="btn blue-btn">Create account</button>
        </div>
    </div>
</div>
    </form>
    </div>
</div>
</body>
</html>
