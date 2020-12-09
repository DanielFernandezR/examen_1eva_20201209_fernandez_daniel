Ejercicio 5

La imagen se inserta mediante una query INSERT de MYSQL en la base de datos. Ej:

$query = "INSERT INTO products SET name=:name, description=:description, price=:price, image=:image, created=:created";

La columna en la cual se debe añadir la imágen debe ser de tipo BLOB, ya que ese tipo de columna se encarga de almacenar imágenes en este caso.

Antes de enviar la imagen a la BBDD, se debe comprobar:
- Que es una imagen real, y no otro tipo de archivo.
- Si queremos, permitir solamente una cantidad de extension de archivos de imágenes.
- Comprobar que el archivo no existe ya con el mismo nombre en la BBDD.
- Comprobar que el archivo no pesa más de X Bytes (X lo especificamos nosotros en las comprobaciones).
- Comprobar que existe la carpeta "uploads" (por ejemplo), donde se almacenan las imágenes en el servidor, o crear la carpeta si no existe.

Una vez comprobadas todas las reglas, se manda la query y se inserta la imagen en la BBDD.

En este ejemplo lo que guardamos en la base de datos es el nombre temporal que se le da 
al archivo + el nombre del archivo que tiene en nuestro ordenador + su extensión.

La imagen está guardada en la carpeta uploads que se ha creado en las comprobaciones previas al insert (no se crea si ya está creada) que está ubicada en el servidor (en este caso en la carpeta raiz del proyecto).

Para recuperar dicha imagen y mostrarla en la tabla, se debe hacer con la etiqueta <img> un src hacia la carpeta uploads. Ej:

<img src='uploads/{$image}' style='width:300px;'/>"