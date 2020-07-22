# bellpi Connect Hub Usuarios

Este paquete integra los usuarios creados en la plataforma de administracion "hub de usuarios" para acceder a otras aplicaciones de bellpi.

## Instalación

Utilize el siguiente comando de composer para instalar este paquete:

```bash
composer require connect-hub-users
```
Elija las siguientes opciones de publicacion del hub de usuarios:

Para manejar las rutas de acceso a los servicios con el que viene el paquete debera ejecutar el siguiente comanndo('estos quedaran en la raiz public/config de su directorio').
``` bash
  php artisan vendor:publish
  [xx] Tag: hub-users-paths
```
Quedara un array en el archivo config/hub-paths de la siguiente manera:

```php
<?php
return [
	'base'=>'',
	'group'=>'',
	'path_login'=>'',
	'path_user'=>'',
	'path_token'=>'',
	'path_profiles'=>'',
	'path_user_create'=>'',
  'path_logout'=>'',
	'route_local_login'=>''
]  
```
Dichas rutas se las proveerá el administrador del paquete para que las modifique en el archivo mencionado. En el array 'route_local_login' debera asignar el nombre que le tenga a la ruta de su login.

Para configurar la llave que es asignada a su proyecto debera utilizar el siguiente commando:
``` bash
  php artisan vendor:publish
  [xx] Tag: hub-users-keys
```
El administrador le proveerá la key asignada a su proyecto, la cual modificara en su archivo config/hub-services-key. Puede acceder a ella utilizando el siguiente helper config('hub-service-key.key')

## Uso
Utilize en sus controladores el siguiente namespace para acceder al facade del paquete:
```php
use Bellpi\ConnectHubUsers\Facades\HubUsers;
```

Para acceder al login del hub de usuarios debera usar el siguiente helper:
```php
$datos=[
	'email'=>'johndoe@gmail.com',
	'password'=>'password',
];
$response=HubUsers::login(config('hub-service-key.key'),'env('key-profile')',$datos);
$response=json_decode($response);
```
Previamente el administrador del paquete debera hacer el registro de usuario y suministrarle las credenciales. 
Adicionalmente tambien le debera brindar tambien las key de los respectivos perfiles creados para su proyecto.

Cuando se realize el login con éxito se creara una variable de sesion que contiene un token que debera utilizar en otros helpers que fueron desarrollados en el paquete.
El token quedara con la siguiente llave dentro de sus variables de sesión:
```php
$token = session('hub_ssk');
```
Podra obtener la información del usuario utilizando utilizando el siguiente helper
```php
$data=[
  'accessToken'=>$token
];
		
$user=HubUsers::getUserProfile(config('hub-service-key.key'),env('key-profile'),$data);
$user = json_decode($response);
```
* Notesé que el access token debera enviarlo en la data para poder obtener la informacion del usuario y debera hacerlo como se muestra la key del array, de otra manera no podrá obtener respuesta.

Puede crear un usuario utilizando estos helpers:
```php
$data=[
  'accessToken'=>$token
];
//Obtiene el listado de perfiles disponible para el proyecto
$response_profiles=HubUsers::getProfilesService(config('hub-service-key.key'),$data);

//Creación de usuario 	
$data_create_user=[];

 $data_create_user=[
  'name'=>"Susana Avila",
  'email'=>"suasana-avila@gmail.com",
  'profiles'=>[1,2],
  'password'=>'bellpi2020',
  'accessToken'=>session('hub_ssk')
 ];

$response_new_user=HubUsers::userUpdate(config('hub-service-key.key'),$data_create_user);
$response_new_user=json_decode($response_new_user);
```
Para hacer cierre de sesión, invalidación de token y borrado de llaves de sesión,  use lo siguiente:
```php
$data=[
	'accessToken'=>$token
];

$response=HubUsers::logout(config('hub-service-key.key'),$data);
```
## Middlewares
Para proteger las rutas y refrescar el token del usuario en sesión, utilize el helper middleware y en el array especifique lo siguiente:
```php
Route::get('/test','TestingController2@test')->middleware('hub-users-auth');

```
Para proteger sus controladores debera hacer uso de la funcion contstuctor e incluir lo siguiente:
```php
public function __construct(){
		$this->middleware(['hub-users-profiles:'.env('key-profile-1').','.env('key-profile-1')]....);
		$this->middleware(['hub-users-modules:'.env('key-module-1').','.env('key-module-2')])....;
	}
```
Las llaves de los modulos creados para su proyecto tambien seran suministradas por el administrador del paquete.

## License
[MIT](https://choosealicense.com/licenses/mit/)
