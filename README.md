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