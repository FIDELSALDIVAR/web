<!-- Define que el documento esta bajo el estandar de HTML 5 -->
<!doctype html>

<!-- Representa la raíz de un documento HTML o XHTML. Todos los demás elementos deben ser descendientes de este elemento. -->
<html lang="es">
<link rel="stylesheet" href="Css/bootstrap.min.css">

    <head>
        
        
    <nav class="navbar">
      
      <a href="LAVANDERIAFL.html" class="button1">Salir de la aplicacion</a>
  
       
       
     
   </nav>
        
        <meta charset="utf-8">
        
        <title> Formulario de Acceso </title>    
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <meta name="author" content="Videojuegos & Desarrollo">
        <meta name="description" content="Muestra de un formulario de acceso en HTML y CSS">
        <meta name="keywords" content="Formulario Acceso, Formulario de LogIn">
        
        <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Overpass&display=swap" rel="stylesheet">
        
        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="login.css">
        
        <style type="text/css">
            
        </style>
        
        <script type="text/javascript">
        
        </script>
        
    </head>
    
      <?php
        include("database.php");
       
        $username = $password = "";
         if(isset($_POST['username'])&& isset($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $db = new database();
            $query = $db->connect()->prepare('SELECT * FROM ejemplo2 WHERE correo = :username AND clave = :password');
            $query->execute(['username' => $username, 'password' => $password]);
            $row = $query->fetch(PDO::FETCH_NUM);
            if($row==true){
                header('location:consultas.php');
            }else{
                echo'<script type="text/javascript">alert("USUARIO O PASSWORD INCORRECTO");
                </script>';
            }
        }
      ?>
        
        <div id="contenedor">
            <div id="central">
                <div id="login">
                    <div class="titulo">
                        Bienvenido
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" 
                    method="post">
                        <input type="text" name="username" placeholder="Usuario" required>
                        
                        <input type="password" placeholder="Contraseña" name="password" required>
                        
                        <button type="submit" title="Ingresar" name="Ingresar">Login</button>
                        
                    </form>
                    <div class="pie-form">
                        <a href="APLICACION.php">¿No tienes Cuenta? Registrate</a>
                    </div>
                </div>
                <div class="inferior">
                    <a href="LAVANDERIAFL.html">Volver al inicio</a>
                </div>
            </div>
        </div>
            
    </body>
</html>