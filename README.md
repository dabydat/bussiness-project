
# Bussiness Project

Este es el Readme.md para la prueba técnica realizada. A continuación explicaré el funcionamiento del mismo sistema creado al cual he titulado **'Bussiness Project'**




## Puntos a tomar en consideración
    **-----Hay que tomar en cuenta que para hacer uso correcto y sin problemas, se debe tener una version de PHP 8.3.1 
    ya que el proyecto ha sido creado con la versión 11 de Laravel-----**


Clonar el proyecto

```bash
  git clone https://github.com/dabydat/bussiness-project.git
```

Ir al directorio del proyecto

```bash
  cd bussiness-project
```

Instalar bibliotecas y paquetes

```bash
  composer install
```

Ejecutar el siguiente comando luego de haber instalado todo. El comando dará varias opciones en la consola, 
siempre dar `ENTER` para que funcione correctamente

```bash
  php artisan migrate:fresh && php artisan db:seed && php artisan passport:client --personal && php artisan passport:client --password
```

Ejecutar el siguiente comando para iniciar a correr el sistema

```bash
  php artisan serve
```


## Environment Variables

Las variables de entorno que deben ser tomadas en consideracion son las siguientes:

### Base de Datos
La base de datos usada ha sido PostgreSQL. 

`DB_CONNECTION=pgsql`

`DB_HOST=127.0.0.1`

`DB_PORT=5432`

`DB_DATABASE=bussiness_project`

`DB_USERNAME=postgres`

`DB_PASSWORD=`


### Servicio de Correo
El servicio de correo que fue utilizado ha sido 
- [Mailtrap] ('https://mailtrap.io')

`MAIL_MAILER=smtp`

`MAIL_HOST=sandbox.smtp.mailtrap.io`

`MAIL_PORT=2525`

`MAIL_USERNAME=`

`MAIL_PASSWORD=`

`MAIL_FROM_ADDRESS="bussiness@project.com"`

### Servicio de API para la Conversion de Monedas
El servicio de conversion de monedas que se uso fue de 
- [ExchangeRates] ('https://www.exchangerate-api.com/')

`API_ACCESS_LINK=https://v6.exchangerate-api.com/v6/`

`API_KEY=`


## Referencias técnicas para el uso correcto de la API

#### |------------------*Rutas públicas que NO requieren el uso de Bearer Token*------------------|

#### Para registrarse en el sistema

```http
  POST /api/auth/v1/signUp
```

| Parámetro         | Tipo de Dato     | Descripción                |
| :--------         | :-------         | :------------------------- |
| `name`            | `string`         | **Requerido**. |
| `email`           | `string`         | **Requerido**. |
| `password`        | `string`         | **Requerido**. |
| `phone_number`    | `string`         | **Requerido**. |
| `local_number`    | `string`         | **Requerido**. |

#### Para el inicio de sesión en el sistema

```http
  POST /api/auth/v1/signIn
```

| Parámetro     | Tipo de Dato     | Descripción                |
| :--------     | :-------         | :-------------------------------- |
| `email`       | `string`         | **Requerido**. |
| `password`    | `string`         | **Requerido**. |

#### |------------------*Rutas privadas que SI requieren el uso de Bearer Token*------------------|

#### Para cerrar sesión en el sistema

```http
  POST /api/auth/v1/signOut
```

| Parámetro     | Tipo de Dato     | Descripción                |
| :--------     | :-------         | :-------------------------------- |
| `token`       | `string`         | **Requerido**. Este es el Bearer Token generado por el inicio de sesión Ó por el registro.|
|      |          | Se requiere el Bearer token en Authorization para poder hacer LogOut del sistema. |

#### Cambiar de Rol el usuario nuevo

```http
  POST /api/v1/changeRole/{user_id}/{action}
```
Esta ruta recibe dos parámetros, el user_id de forma encriptada y la accion de rechazo o aceptado. Ya esta ruta esta configurada al llegar el correo. 

#### Para la creacion de empresa

```http
  POST /api/v1/createEnterprise
```

| Parámetro         | Tipo de Dato     | Descripción                       |
| :--------         | :-------         | :-------------------------------- |
| `name`            | `string`         | **Requerido**. |
| `document_type`   | `string`         | **Requerido**. |
| `status`          | `string`         | **Requerido**. |
| `email`           | `string`         | **Requerido**. |
| `user_id`         | `string`         | **Requerido**. |
| `country_id`      | `string`         | **Requerido**. |

Los campos `document_type` y `status` deben cumplir con algunas condiciones...

##### 1. Para `document_type` requiere ser llenado con una las siguientes opciones: dni, cif, nie, nif, passport, other
##### 2. Para `status` requiere ser llenado con una de las siguientes opciones: active, inactive

#### Consultar todas las empresas registradas

```http
  GET /api/v1/getAllEnterprises?skip=0&take=10
-------------------------------------------------
  GET /api/v1/getAllEnterprises
```

| Parámetro         | Tipo de Dato     | Descripción                |
| :--------         | :-------         | :------------------------- |
| `name`            | `string`         | **Opcional**. |
| `email`           | `string`         | **Opcional**. |
| `document_type`   | `string`         | **Opcional**. |
| `status`          | `string`         | **Opcional**. |
| `country_id`      | `string`         | **Opcional**. |
| `location`        | `string`         | **Opcional**. |
| `phone_number`    | `string`         | **Opcional**. |
| `user_id`         | `string`         | **Opcional**. |
|  -----------------| `PAGINACIÓN`     |---------------|
| `skip`            | `string`         | **Opcional**. Por defecto esta configurado en 0 |
| `take`            | `string`         | **Opcional**. Por defecto esta configurado en 10|

#### Para la creacion de una actividad de empresa

```http
  POST /api/v1/createActivity
```

| Parámetro         | Tipo de Dato     | Descripción                       |
| :--------         | :-------         | :-------------------------------- |
| `activity`        | `string`         | **Requerido**. |


#### Consultar todas las actividades registradas

```http
  GET /api/v1/getAllActivities?skip=0&take=10
-------------------------------------------------
  GET /api/v1/getAllActivities
```

| Parámetro         | Tipo de Dato     | Descripción                |
| :--------         | :-------         | :------------------------- |
| `activity`        | `string`         | **Opcional**. |
|  -----------------| `PAGINACIÓN`     |---------------|
| `skip`            | `string`         | **Opcional**. Por defecto esta configurado en 0 |
| `take`            | `string`         | **Opcional**. Por defecto esta configurado en 10|

#### Para la creacion de una actividad asociada a una empresa

```http
  POST /api/v1/createEnterpriseActivity
```

| Parámetro         | Tipo de Dato     | Descripción                       |
| :--------         | :-------         | :-------------------------------- |
| `enterprise_id`   | `string`         | **Requerido**. |
| `activity_id`     | `string`         | **Requerido**. |

#### Consultar todas las actividades registradas asociadas a una empresa

```http
  GET /api/v1/getAllEnterpriseActivities?skip=0&take=10
-------------------------------------------------
  GET /api/v1/getAllEnterpriseActivities
```

| Parámetro         | Tipo de Dato     | Descripción                |
| :--------         | :-------         | :------------------------- |
| `enterprise_id`   | `string`         | **Opcional**. |
| `activity_id`     | `string`         | **Opcional**. |
| `enterprise_name` | `string`         | **Opcional**. |
| `activity`        | `string`         | **Opcional**. |
|  -----------------| `PAGINACIÓN`     |---------------|
| `skip`            | `string`         | **Opcional**. Por defecto esta configurado en 0 |
| `take`            | `string`         | **Opcional**. Por defecto esta configurado en 10|

#### Consultar todos los usuarios que tienen empresa

```http
  GET /api/v1/getEnterpriseUsers?skip=0&take=10
-------------------------------------------------
  GET /api/v1/getEnterpriseUsers
```

| Parámetro         | Tipo de Dato     | Descripción                |
| :--------         | :-------         | :------------------------- |
| `rol`             | `string`         | **Opcional**. |
| `enterprise`      | `string`         | **Opcional**. |
| `user_email`      | `string`         | **Opcional**. |
| `user_name`       | `string`         | **Opcional**. |
|  -----------------| `PAGINACIÓN`     |---------------|
| `skip`            | `string`         | **Opcional**. Por defecto esta configurado en 0 |
| `take`            | `string`         | **Opcional**. Por defecto esta configurado en 10|

#### Consultar todas las empresas que no tienen actividades

```http
  GET /api/v1/getEnterpriseWithoutActivities?skip=0&take=10
-------------------------------------------------
  GET /api/v1/getEnterpriseWithoutActivities
```

| Parámetro         | Tipo de Dato     | Descripción                |
| :--------         | :-------         | :------------------------- |
|  -----------------| `PAGINACIÓN`     |---------------|
| `skip`            | `string`         | **Opcional**. Por defecto esta configurado en 0 |
| `take`            | `string`         | **Opcional**. Por defecto esta configurado en 10|

#### Consultar API que realiza la conversion de una moneda base a las demás

```http
  POST /api/v1/getConversionRates
```

| Parámetro         | Tipo de Dato     | Descripción                |
| :--------         | :-------         | :------------------------- |
| `baseCurrency`    | `string`         | **Opcional**. Por defecto esta configurado para que consulte USD |
|  -----------------| `PAGINACIÓN`     |---------------|
| `skip`            | `string`         | **Opcional**. Por defecto esta configurado en 0 |
| `take`            | `string`         | **Opcional**. Por defecto esta configurado en 10|

## Authors

- [@dabydat](https://www.github.com/dabydat)


## Documentation

[Documentation](https://laravel.com/docs/11.x)

