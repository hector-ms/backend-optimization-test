# Implementación

## Organiación de clases y ficheros

Se han organizado los ficheros y las clases en directorios según su tipo o función. 

* La clase `Item` pertenecería claramente a una entidad de la aplicación, por eso se ha colocado dentro de un nuevo directorio llamado `Entity`. 

* La clase `GildedRose` se ha renombrado a `GildedRoseUpdateQualityService`, ya que es un nombre más correcto teniendo en cuenta su funcionalidad interna (ya que el nombre actual podía hacer pensar que se trataba de una clase perteneciente a una entidad de la aplicación, pero que, realmente, al entrar en la clase ves que lo que realmente tiene son operaciones y procesamiento de datos, mucho más parecido al comportamiento de un servicio que no al comportamiento y estructura de una entidad). Se ha añadido la clase en un nuevo directorio llamada `Service`.

* La clase de tests `GildedRoseTest` se ha renombrado a `GildedRoseUpdateQualityServiceTest`, debido al cambio de nombre de la clase que testea.

## Optimización

Se ha optimizado la clase `GildedRoseUpdateQualityService` mediante la unificación de condicionales, la triple igualación y la división de la función principal `update_quality` en funciones más simples y concretas, y ejecutando los tests en cada cambio para comprobar que todo seguía funcionando correctamente. También se ha analizado y corregido el código con los niveles más altos de PHPStan y Psalm

## Docker

Se ha "dockerizado" el proyecto para no depender del sistema operativo y versión del ordenador en el que se quiera probar el código, el único requisito es tener instalado docker (si no se tiene docker lo puede descargar desde: https://www.docker.com).

Con docker instalado y en marcha, solo se tiene que abrir un terminal, ir a la ruta principal de este proyecto (donde se encuentra el fichero docker-compose.yml) y ejecutar la siguiente instrucción:
```bash
docker-compose build
```

Esta instrucción puede tardar unos pocos segundos en completarse. Una vez finalice, se debe ejecutar la siguiente instrucción:
```bash
docker-compose up
```

En esa instrucción se inicializarán los servicios necesarios para poder acceder a la aplicación. Una vez se hayan iniciado todos, ya podemos acceder al proyecto dentro docker, solo tenéis que introducir la instrucción:
```bash
docker exec -it runroom-php bash
```

Para finalizar la ejecución con docker, se debe introducir la instrucción:
```bash
docker-compose down
```