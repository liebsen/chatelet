<!-- BADGES -->
[![Latest Stable Version](https://poser.pugx.org/alejoasotelo/andreani/v/stable)](https://packagist.org/packages/alejoasotelo/andreani)
[![License](https://poser.pugx.org/alejoasotelo/andreani/license)](https://packagist.org/packages/alejoasotelo/andreani)

![Andreani](https://miro.medium.com/max/236/1*SU6pjCbwtPaLTr27wQJgIQ.png)

# Andreani SDK Rest - PHP

Andreani SDK Rest es una librería para conectar con la Api Rest de Andreani ([ver documentación](https://developers.andreani.com/documentacion)).

Es obligatorio para poder conectar con Andreani tus credenciales: usuario, contraseña y cliente.

### Credenciales Obligatorias:
```bash
Usuario: alejo
Password: sotelo
Cliente: CL0009999
```

## Instalación vía Composer

```bash
composer require alejoasotelo/andreani
```

## Artículo en medium

[Ver artículo](https://medium.com/@alejoasotelo/librer%C3%ADa-php-para-andreani-api-rest-128c109f4e0b)

## (❗) NOTA

Desde la versión 0.8.0 se actualizaron las urls de desarrollo y producción. Es posible que tengas que pedir un nuevo usuario y contraseña para que funcionen con estas nuevas urls. En este caso es necesario que te contactes con el webservice o tu agente de Andreani.

## Cómo se utiliza la libreria?

Se pueden ver ejemplos de uso en la carpeta [examples](examples). Para poder ejecutarlos es necesario renombrar el archivo [config.json.dist](examples/config.json.dist) a config.json y reemplazar las credenciales.

## Funciones

### Inicialización

```php
require_once __DIR__.'/vendor/autoload.php';

use AlejoASotelo\Andreani;

$ws = new Andreani($user, $pass, $cliente, $debug);
```

### getProvincias()

Lista las provinicas reconocidas según [ISO-3166-2:AR](https://es.wikipedia.org/wiki/ISO_3166-2:AR):

```php
$result = $ws->getProvincias();

var_dump($result);
```


### getSucursales()

Obtener todas las sucursales de Andreani:
```php
$result = $ws->getSucursales();

var_dump($result);
```


### getSucursalByCodigoPostal($codigoPostal)

Obtener las sucursales recomendadas para un código postal usando la api v2:
```php
$result = $ws->getSucursalByCodigoPostal(1832);

var_dump($result);
```


### getSucursalByCodigoPostalLegacy($codigoPostal)

Obtener las sucursales recomendadas para un código postal usando la api SOAP:
```php
$result = $ws->getSucursalByCodigoPostalLegacy(1832);

var_dump($result);
```


### cotizarEnvio($cpDestino, $contrato, $bultos)

Obtener la cotización para un envío según código postal, contrato, bultos, cliente, etc:
```php
$bultos = array(
    array(
        'volumen' => 200,
        'kilos' => 1.3,
        'pesoAforado' => 5,
        'valorDeclarado' => 1200, // $1200
    ),
);

$result = $ws->cotizarEnvio(1832, '300006611', $bultos, 'CL0003750');

var_dump($result);
```

Ver ejemplo en el archivo [examples/cotizarEnvio.php](examples/cotizarEnvio.php)


### addOrden($data)

Agrega/crea una orden (envío) pasandole como parámetro $data con la info del envío. Puede ser pasado como un array o como string (json_encode).

Ver ejemplo en el archivo [examples/addOrden.php](examples/addOrden.php)


### getEtiqueta($numeroAndreani, $tipo = Andreani::ETIQUETA_ESTANDAR)

Devuelve una etiqueta en formato PDF, que puede ser de bulto o remito a partir del numero andreani brindado en el alta. 

```php
$response = $ws->getEtiqueta($numeroAndreani);

if (!is_null($response) && isset($response->pdf)) {
    file_put_contents(__DIR__.'/getEtiqueta.pdf', $response->pdf);
}
```

Si el envío es un cambio, además de la etiqueta estandar hay que obtener el documento de cambio de la siguiente manera:

```php
$response = $ws->getEtiqueta($numeroAndreani, Andreani::ETIQUETA_DOCUMENTO_DE_CAMBIO);

if (!is_null($response) && isset($response->pdf)) {
    file_put_contents(__DIR__.'/getEtiqueta-documentoDeCambio.pdf', $response->pdf);
}
```


### getTrazabilidad($numeroAndreani, $apiVersion = Andreani::API_V2)

Devuelve la trazabilidad de un envío. La v1 y v2 son practicamente iguales, solo que en el response de la v2 sacaron algunos campos.

V1:
```json
{
    "eventos": [
        {
            "Fecha":"2019-04-11T11:18:47",
            "Estado":"Pendiente de ingreso",
            "EstadoId":1,
            "Motivo":null,
            "MotivoId":0,
            "Submotivo":null,
            "SubmotivoId":0,
            "Sucursal":"",
            "SucursalId":0,
            "Ciclo":""
        }
    ]
}
```

V2:
```json
{
    "eventos": [
        {
            "Fecha": "2021-03-09T11:08:03",
            "Estado": "Pendiente de ingreso",
            "EstadoId": 1,
            "Traduccion": "ENVIO INGRESADO AL SISTEMA",
            "Sucursal": "Sucursal Genérica",
            "SucursalId": 999,
            "Ciclo": "Distribution"
        }
    ]
}
```

(!) Nota: en la v2 no devuelve el evento "entregado", estan trabajando para agregarlo. Para solventar este problema usar `getOrden()` y chequear el campo `estado` 

```php
$result = $ws->getTrazabilidad($numeroAndreani);

var_dump($result);
```

Ver ejemplo en el archivo [examples/getTrazabilidad.php](examples/getTrazabilidad.php)


### getCodigoQR($informacion)

Devuelve un código QR en formato PNG pasandole como parametro un string. Puede ser el numero de envio o se le puede pasar un JSON.

Ejemplo 1:
```php
$data = [
    'numeroDeEnvio' => $numeroDeEnvio
];

$informacion = json_encode($data);

$response = $ws->getCodigoQR($informacion);

if (!empty($response)) {
    file_put_contents(__DIR__.'/getCodigoQR.png', $response);
}
```

Ejemplo 2:

```php
$data = [
    'numeroDeEnvio' => $numeroDeEnvio
];

$informacion = json_encode($data);

$response = $ws->getCodigoQR($informacion);

if (!empty($response)) {
    echo '<img src="data:image/png;base64,'.base64_encode($response).'" />';
}
```


### (!) Cancelar envíos

En la nueva API no se pueden cancelar envíos. Andreani toma como cancelado un envío si no entra en distribución.


### Proceso completo de Envío

En el archivo [examples/procesoDeEnvio.php](examples/procesoDeEnvio.php) hay un ejemplo del proceso completo de envío. En cada paso se guarda el response en json y la etiqueta PDF en el último.

Proceso de Envío:
```txt
1. Cotizar el Envío
2. Crear una Orden
3. Obtener la Orden
4. Obtener la Trazabilidad
5. Obtener la Etiqueta.
```

## Contacto API Andreani

Si tenés dudas respecto a la API de Andreani este es el email de ellos: apis[arroba]andreani.com

(!) Aclaración: este es un proyecto personal, yo no tengo ningún tipo de vinculo con Andreani, comparto mi conocimiento en este repositorio.


## Querés colaborar con el proyecto?

Podés enviar tu mejoras o pull request o podés
[![Invitarme un café en cafecito.app](https://cdn.cafecito.app/imgs/buttons/button_2.svg)](https://cafecito.app/alejoasotelo)