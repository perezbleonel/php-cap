# ABC/CRUD

Ejercicio PHP

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente:

1.  **XAMPP**: Asegúrate de tener una versión de XAMPP instalada que incluya PHP, Apache y MySQL. Puedes descargarlo desde [Apache Friends](https://www.apachefriends.org/index.html).
    * Durante la instalación de XAMPP, asegúrate de seleccionar los componentes Apache y MySQL.
2.  **Git**: Necesitarás Git para clonar el repositorio. Puedes descargarlo desde [git-scm.com](https://git-scm.com/).

## Configuración del Entorno XAMPP

Es crucial que Apache y MySQL se ejecuten en los puertos correctos.

1.  **Inicia el Panel de Control de XAMPP.**
2.  **Configura Apache para el puerto 80:**
    * En el Panel de Control de XAMPP, junto a Apache, haz clic en el botón "Config".
    * Selecciona `Apache (httpd.conf)`.
    * Busca la línea `Listen 80`. Asegúrate de que esté configurada en `80`.
    * Busca la línea `ServerName localhost:80`. Asegúrate de que esté configurada así.
    * Guarda los cambios y cierra el archivo.
    * Si el puerto 80 está ocupado por otro servicio (como Skype o IIS), deberás detener ese servicio o configurar Apache para que use un puerto diferente (y luego acceder a tu proyecto usando ese puerto, por ejemplo, `http://localhost:PUERTO_NUEVO/`).
3.  **Configura MySQL para el puerto 3306:**
    * En el Panel de Control de XAMPP, junto a MySQL, haz clic en el botón "Config".
    * Selecciona `my.ini`.
    * Busca la sección `[mysqld]`.
    * Asegúrate de que la línea `port` esté configurada en `3306` (ej. `port = 3306`).
    * Guarda los cambios y cierra el archivo.
    * El puerto 3306 es el predeterminado para MySQL, por lo que usualmente no requiere cambios.
4.  **Inicia los servicios de Apache y MySQL** desde el Panel de Control de XAMPP haciendo clic en el botón "Start" para cada uno. Deberían mostrarse en verde y listar los puertos 80 (para Apache) y 3306 (para MySQL).

## Instalación del Proyecto

Sigue estos pasos para configurar el proyecto en tu entorno local:

1.  **Clonar el Repositorio:**
    Abre tu terminal o Git Bash y navega hasta el directorio `htdocs` de tu instalación de XAMPP (generalmente `C:\xampp\htdocs\` en Windows o `/opt/lampp/htdocs/` en Linux).
    Clona el proyecto usando el siguiente comando:
    ```bash
    git clone https://github.com/perezbleonel/php-cap.git
    ```
    Reemplaza `https://github.com/perezbleonel/php-cap.git` con la URL real de tu repositorio Git y `nombre_de_tu_proyecto` con el nombre que deseas para la carpeta del proyecto. Si omites `nombre_de_tu_proyecto`, se usará el nombre del repositorio.

2.  **Configuración de la Base de Datos:**
    * Abre tu navegador web y ve a `http://localhost/phpmyadmin/`.
    * Crea una nueva base de datos. Puedes nombrarla, por ejemplo, `nombre_de_tu_base_de_datos`. Asegúrate de usar una codificación como `utf8mb4_general_ci` o `utf8_general_ci` para una correcta compatibilidad de caracteres.
    * Selecciona la base de datos que acabas de crear.
    * Ve a la pestaña "Importar".
    * Haz clic en "Seleccionar archivo" y busca el archivo `.sql` de volcado de la base de datos que debería estar en tu proyecto (por ejemplo, `database/schema.sql` o `database/data.sql`). Si no tienes un archivo SQL, puede que necesites ejecutar migraciones o crear las tablas manualmente según la documentación del proyecto.
    * Haz clic en "Continuar" (o "Go") para importar la estructura y/o los datos.

3.  **Configuración del Proyecto PHP:**
    Muchos proyectos PHP requieren un archivo de configuración para detalles como las credenciales de la base de datos.
    * Busca un archivo de configuración de ejemplo en tu proyecto, comúnmente llamado `config.php.example`, `settings.php.dist`, `.env.example`, o similar.
    * Copia este archivo y renómbralo al nombre que utiliza la aplicación (conn.php) este archivo se encuentra en la carpeta `ENVIROMENT`.
    * Abre el archivo de configuración recién creado (ej. `config.php`) y actualiza los siguientes detalles de la base de datos:
        * `$host : `localhost`
        * `$user`: : `root` (usuario por defecto de XAMPP para MySQL).
        * `$password`: `contraseña` (va en blanco por defecto si usas XAMPP).
        * `$port` : `root` (usuario por defecto de XAMPP para MySQL).
        * `$db`: ```nombre_de_tu_base_de_datos` (el nombre que usaste en el paso 2).
    * Ajusta cualquier otra configuración específica del proyecto según sea necesario.


## Ejecutar el Proyecto

Una vez que Apache y MySQL estén funcionando y el proyecto esté configurado:

1.  Abre tu navegador web.
2.  Navega a la URL de tu proyecto. Será algo como:
    `http://localhost/nombre_de_tu_proyecto/`

¡Con esto deberías poder clonar e iniciar tu proyecto PHP usando XAMPP!
