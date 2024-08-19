<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión / Registro</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #d8b6e6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            width: 800px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .form-container {
            padding: 40px;
            width: 50%;
        }

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background: #0056b3;
        }

        .toggle-link {
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
            cursor: pointer;
        }

        .toggle-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    include('DATABASE.php');
    $username=$password="";
    if(isset($_POST['username'])&& isset($_POST['password'])){

        $username= $_POST['username'];
        $password= $_POST['password'];
        $db= new Database();
        $query = $db->connect()->prepare('select * from aplicacion where correo= :username AND clave=:password');
        $query->execute(['username' => $username, 'password' => $password]);

        $row = $query->fetch();
        
        if($row == true){
            $_SESSION['username']=$_POST['username'];
            $_SESSION['usuario']=$row['nombre'];
            $_SESSION['grado']=$row['grado'];
            //header('location: menuEjemplo.php');
            switch ($_SESSION['grado']){
                case 1:
                    header('location:usuarios/menuEjemplo.php');
                break;
                case 2:
                    header('location: ventas/menu.php');
                break;
                default:        
            }

        }else{
            echo'<script type="text/javascript">
            alert("USUARIO O PASSWORD INCORRECTO");</script>';
        }

    }
    ?>
     
<div class="container">
    <div class="form-container" id="login-form">
        |
        <h2>Inicio de Sesión</h2>
        <form action="" method="post">
        <input type="text" placeholder="Usuario" name="username">
        <input type="password" placeholder="Contraseña" name="password">
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Iniciar sesion"> 
        </div>
        
        <a href="../APLICACION.php">¿No tienes una cuenta? Regístrate</a>
        <br>
        <hr>
        <a href="../LAVANDERIAFL.html">volver al inicio</a>

        </form>
        
    </div>
    
</body>
</html>