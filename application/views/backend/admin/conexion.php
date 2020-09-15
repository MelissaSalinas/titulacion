<?php
 	$cons_usuario="melissa";
    $cons_contra="123456";
    $cons_base_datos="bdrecursoshh";
    $cons_equipo="localhost";

    $conn = mysqli_connect($cons_equipo,$cons_usuario,$cons_contra,$cons_base_datos);
    if(!$conn)
    {
        echo "<h3>No se ha podido conectar PHP - MySQL, verifique sus datos.</h3><hr><br>";
    }
    else
    {
        echo "<h3>Conexion Exitosa PHP</h3><hr><br>";
    }
?>