<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base De Datos Criminal de México</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="lib/materialize/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="lib/materialize/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <script src="lib/jquery-3.2.1.js" type="text/javascript"></script>
    <script src="lib/materialize/js/materialize.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin: 0;
            color: #333;
        }

        .login-container form {
        
            display: center;
            flex-direction: column;
        }

        .login-container label {
            margin-top: 10px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        #button_login  {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 3px;
            margin-top: 10px;
            cursor: pointer;
        }
        .Titulo_Principal{
            color: #333;
            font: curl_close;
        }
        #Nombres{
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h1 class = "Titulo_Principal">Base De Datos Criminal de México</h1>
    <br>
    <div class="login-container">
        <h2>Login</h2>
        <?php
            $e = $_GET["e"];
            if($e == "1"){
                echo"<script>M.toast({html:'Usuario o Constraseña Incorrecta'})</script>";
            }
            
        ?>
        <form action= "ChecarUsuarios.php" method="get"> 
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" autocomplete="User">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" autocomplete="Password">

            <button id="button_login" type="submit">Log In</button>
        </form>
    </div>
    <lable id= "Nombres">Creado Por: Humberto Plata, Oscar Cueto Farley y Diddier Puño</lable>
</body>
</html>

