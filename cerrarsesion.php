<?php
session_start();//se reanuda una sesion existente
session_unset();//se elimina todas las variables de sesion almacenadas en el array $_SESSION
session_destroy();//toda la informacion asociada con la sesion actual en el servidor

header("Location: index.html");//se redirige la al usuario a la pagina inicial
exit;
?>