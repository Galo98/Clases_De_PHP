# Clases de PHP

Repositorio que contendrá ejemplos básicos de programación a modo de introducción del lenguaje [PHP](https://www.php.net/) e información adicional correspondiente a lo visto en las clases de prácticas profesionalizantes 1 brindadas en el **Instituto de Formación Superior Docente y Técnica N°24, Dr. Bernardo Houssay**.

Para acceder al manual de [PHP](https://www.php.net/) hacer [click acá](https://www.php.net/);

---

---

# Métodos HTTP Principales

Los métodos más comunes y esenciales se corresponden con las operaciones CRUD (Crear, Leer, Actualizar, Eliminar):

> **_GET_**: Se utiliza para recuperar o leer un recurso específico del servidor. Es el método más común y se usa por defecto al navegar por páginas web o al obtener datos de una API. Los datos se pueden enviar como parámetros en la URL.

> **_POST_**: Se usa para crear un nuevo recurso en el servidor o enviar datos a procesar. La información se incluye en el cuerpo de la solicitud, no en la URL.

> **_PUT_**: Se utiliza para actualizar (reemplazar) un recurso existente en el servidor. Si el recurso no existe, puede crearlo. Es un método idempotente, lo que significa que múltiples solicitudes PUT tienen el mismo efecto que una sola.

> **_DELETE_**: Se emplea para eliminar un recurso específico del servidor.

> **_PATCH_**: Similar a PUT, pero se usa para realizar actualizaciones parciales en un recurso existente, en lugar de reemplazarlo por completo.

## Otros Métodos Importantes

> **_HEAD_**: Solicita las cabeceras de un recurso, pero sin el cuerpo del mensaje. Es útil para verificar la existencia o el tamaño de un recurso sin descargarlo completamente.

> **_OPTIONS_**: Solicita información sobre las opciones de comunicación disponibles para un recurso o servidor determinado. Se utiliza frecuentemente en las solicitudes preflight de CORS (Cross-Origin Resource Sharing).

> **_TRACE_**: Realiza un bucle de retorno de la solicitud para fines de prueba y diagnóstico.

> **_CONNECT_**: Se usa para establecer un túnel a un servidor identificado por el recurso de destino.

## Consideraciones

Cada método define claramente la intención de la solicitud, lo que permite una interacción estructurada y estandarizada entre el cliente y el servidor, especialmente en el diseño de APIs RESTful.

---

---

# Operador Ternario

El **ternario** es una estructura sintáctica en muchos lenguajes de programación que permite escribir una declaración `if-else` en una sola línea de código.

## Concepto y función

Su propósito es evaluar una condición booleana y devolver uno de dos valores posibles, dependiendo de si la condición es verdadera o falsa. Es una forma concisa y elegante de asignar un valor a una variable o ejecutar una expresión simple basada en una condición.

## Sintaxis General

La sintaxis básica del operador ternario es la siguiente:

`condicion ? expresion_si_verdadero : expresion_si_falso;`

`condicion`: La expresión booleana que se evalúa (devuelve `true` o `false`).

`?`: Separa la condición de la primera expresión.

`expresion_si_verdadero`: El valor o la expresión que se devuelve/ejecuta si la condición es verdadera.

`:`: Separa las dos expresiones de resultado.

`expresion_si_falso`: El valor o la expresión que se devuelve/ejecuta si la condición es falsa.

## Ejemplo práctico (en JavaScript)

**Usando `if-else` :**

```
let edad = 20;
let estado;

if (edad >= 18) {
    estado = "Mayor de edad";
} else {
    estado = "Menor de edad";
}
// estado ahora es "Mayor de edad"
```

**Usando el ternario**

```
let edad = 20;
let estado = (edad >= 18) ? "Mayor de edad" : "Menor de edad";

// estado ahora es "Mayor de edad"
```

---

---

# Sentencias MySQLi Procedurales

Está sección contiene la explicación de las sentencias procedurales utilizadas en `/models/usuarios.models.php` en la función `createNewUser();`.

**1. Preparar la Sentencia**

```
$con = conDB();

$sql = "INSERT INTO usuarios (nombre, apellido, email, password_hash, rol_id) VALUES (?, ?, ?, ?, ?)";

$resultado = mysqli_prepare($con, $sql);

```

_Función: mysqli_prepare()_

> Propósito: Le indica al servidor de la base de datos que prepare una sentencia SQL para su ejecución. Esta sentencia ($sql) contiene marcadores de posición (?) en lugar de los valores reales.

> Parámetros: Recibe el recurso de conexión a la base de datos ($con) y la cadena de la consulta SQL ($sql).

> Resultado: Devuelve un objeto de sentencia ($resultado) que se utiliza para todas las operaciones posteriores de vinculación y ejecución. Si la preparación falla (ej: la sintaxis SQL es incorrecta), devuelve false.

**2. Manejo de Errores de Preparación**

`mysqli_error($con);`

_Función: mysqli_error()_

> Propósito: Devuelve una cadena de texto que describe el último error ocurrido para la conexión proporcionada ($con).

> Uso aquí: Se usa dentro de error_log() para registrar el motivo exacto por el cual la función mysqli_prepare pudo haber fallado.

**3. Vincular los Parámetros**

```
mysqli_stmt_bind_param($resultado, "ssssi", $nombre, $apellido, $email, $password_hash, $rol_id);
```

_Función: mysqli_stmt_bind_param()_

> Propósito: Vincula las variables de PHP que contienen los valores de los datos a los marcadores de posición (?) definidos en la sentencia preparada ($resultado).

> Parámetros: Recibe el objeto de sentencia ($resultado), una cadena de formato de tipos ("ssssi") que especifica el tipo de cada variable, y luego una lista de todas las variables en el orden en que aparecen los ? en la consulta.

> Seguridad: Este paso es crucial para la seguridad, ya que asegura que los valores se envíen al servidor por separado de la consulta, previniendo la Inyección SQL.

**4. Ejecutar la Sentencia**

`mysqli_stmt_execute($resultado)`

_Función: mysqli_stmt_execute()_

> Propósito: Ejecuta la sentencia preparada ($resultado) en el servidor de la base de datos, enviando los valores previamente vinculados para realizar la inserción.

> Resultado: Devuelve true si la ejecución fue exitosa y false si hubo algún error (ej: intentar insertar un email duplicado).

**5. Obtener el ID Generado**

` $insert_id = mysqli_insert_id($con);`

_Función: mysqli_insert_id()_

> Propósito: Devuelve el ID generado automáticamente por la última consulta INSERT ejecutada en la conexión ($con).

> Uso aquí: Captura el valor de la columna id_usuario que MySQL generó automáticamente al registrar al nuevo usuario.

**6. Cerrar la Sentencia**

`mysqli_stmt_close($resultado);`

_Función: mysqli_stmt_close()_

> Propósito: Libera los recursos del sistema y del servidor asociados a la sentencia preparada ($resultado), cerrándola.

> Buenas Prácticas: Es fundamental llamar a esta función después de que la sentencia ha terminado de usarse para liberar memoria y recursos.

**7. Manejo de Errores de Ejecución**

`mysqli_stmt_error($resultado)`

_Función: mysqli_stmt_error()_

> Propósito: Devuelve una cadena de texto que describe el último error ocurrido para la sentencia ($resultado) que se intentó ejecutar.

> Uso aquí: Se usa dentro del bloque else para registrar cualquier error específico que haya ocurrido durante la ejecución de la inserción (ej: violaciones de unicidad).

---

---

# Tipo MIME (Multipurpose Internet Mail Extensions)

El Tipo MIME es un estándar utilizado para identificar el formato y la naturaleza de un documento, archivo o dato transmitido por Internet. Actúa como una etiqueta de dos partes que los navegadores y servidores utilizan para determinar cómo deben manejar o procesar un archivo.

## Estructura

Todos los Tipos MIME se componen de dos partes separadas por una barra `TipoPrincipal/Subtipo`.

| Parte          | Función                                                                    | Ejemplos Comunes                |
| -------------- | -------------------------------------------------------------------------- | ------------------------------- |
| Tipo Principal | Define la categoría general del archivo (ej: texto, imagen, audio).        | text, image, application, video |
| Subtipo        | Define el formato específico dentro de esa categoría (ej: HTML, PNG, PDF). | html, png, pdf, mp4, json       |

## Importancia en PHP (Seguridad)

En el contexto de la subida de archivos, verificar el Tipo MIME es una medida de seguridad crítica porque:

**Fiabilidad**: A diferencia de la extensión del archivo (que el usuario puede renombrar fácilmente), el Tipo MIME reportado por el servidor (usando funciones como `mime_content_type()`) a menudo refleja el formato real del archivo.

**Prevención**: Evita que usuarios malintencionados suban archivos ejecutables (`application/x-php` o `application/exe`) disfrazados de imágenes (`.jpg`), lo que podría comprometer el sistema.
