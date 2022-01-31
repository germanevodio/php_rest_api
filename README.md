# PHP y MySQL REST API
Esta es una API REST escrita en PHP con autenticación y generacion de JWT, que conecta a una DB de MySQL/MariaDB

## Configuración
- El primer paso es crear la DB y ejecutar el script de SQL.
- Clonar o descargar este proyecto y correrlo en tu servidor local.
- En el archivo ubicado en la ruta config/dbCredentials.php configurar las credenciales de la base de datos local.

## Recursos del API
El API cuenta con los siguentes recursos, para consumirlos debes ingresar a http://your-project/api/{end-point}<br>
Los end point disponibles {end-point} son:
<ul>
  <li>users</li>
  <li>auth</li>
  <li>publications</li>
</ul>

## Consumo de end points
- Alta de usuarios | POST | http://your-project/api/users<br>
  Recibe un JSON con la siguiente estructura:

  ```JSON
  {
    "nombre": "your_name",
    "apellido": "your_last_name",
    "correo": "your@mail.com",
    "password": "your_secret",
    "rol": "your_id_role" // 1 is the superuser role
  }
  ```

- Autenticación |POST|  http://your-project/api/auth<br>
  Recibe un JSON con la siguiente estructura:
 
 ```JSON
  {
    "email": "your_user",
    "password": "your_password"
  }
  ```
  
  Retorna un status y en caso de ser correcto un Token para enviar en las siguientes peticiones.

- Creacion de publicación |POST|  http://your-project/api/publications<br>
   Recibe un JSON con la siguiente estructura:
  
  ```JSON
  {
      "titulo": "the_publication_title",
      "descripcion": "the_publication_description",
      "jwt": "your_token"
  }
  ```

- Consulta de publicaciones |GET| http://your-project/api/publications?jwt=your-token<br>
  Solo requiere consumir el end point y enviar el token para poder autenticar

- Consulta de una publicación |GET| http://your-project/api/publications?id=publication-id&jwt=your-token<br>
  Requiere que se envie el ID de la publicación y el token para la autenticación

- Actualización de publicaciones |PUT| http://your-project/api/publications?id=publication-id&jwt=your-token<br>
  Recibe un json con la siguiente estructura
  
  ```JSON
  {
    "titulo": "the_new_title",
    "descripcion": "the_new_description"
  }
  ```
  
- Elimina una publicación |DELETE| http://your-project/api/publications?id=publication-id&jwt=your-token<br>
  Requiere que se envie el ID de la publicación a eliminar y el token para autenticación
  
