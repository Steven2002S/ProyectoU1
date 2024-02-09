@echo off

REM Obtener la fecha actual
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I

REM Extraer año, mes y día de la fecha actual
set year=%datetime:~0,4%
set month=%datetime:~4,2%
set day=%datetime:~6,2%

REM Crear el formato del nombre del proyecto
set filename=proyecto_%day%%month%%year%

rem Configuración de MySQL
set MYSQL_USER=root
set MYSQL_PASSWORD=0939167675Ale
set DATABASE=bdd_hoteleria

rem Configuración de la máquina remota (Debian)
set REMOTE_USER=root
set REMOTE_HOST=192.168.52.131
set REMOTE_SQL_FILE=/home/grupo-6/Escritorio/%filename%.sql

rem Configuración del contenedor Docker MySQL
set DOCKER_CONTAINER_NAME=main-mysql-1

rem Ruta del archivo SQL descargado
set BACKUP_FILE=C:\Users\Usuario\Desktop\respaldo.sql
set REMOTE_CONTAINER_FILE=/home/backup.sql

rem Descargar el archivo SQL desde la máquina remota
echo Descargando archivo SQL desde la máquina remota...
scp %REMOTE_USER%@%REMOTE_HOST%:%REMOTE_SQL_FILE% %BACKUP_FILE%
if %ERRORLEVEL% NEQ 0 (
    echo Error: No se pudo descargar el archivo SQL desde la máquina remota.
    exit /b 1
)

echo ##############################################################
echo ############### Restaurando la base ##########################
echo ##############################################################


docker cp %BACKUP_FILE% %DOCKER_CONTAINER_NAME%:%REMOTE_CONTAINER_FILE%



rem Eliminar la base de datos existente si existe
docker exec %DOCKER_CONTAINER_NAME% mysqladmin -u %MYSQL_USER% -p%MYSQL_PASSWORD% drop %DATABASE% 2>nul

echo Creando y restaurando la base de datos %DATABASE%...
docker exec %DOCKER_CONTAINER_NAME% mysql -u %MYSQL_USER% -p%MYSQL_PASSWORD% -e "CREATE DATABASE IF NOT EXISTS %DATABASE%; USE %DATABASE%; SOURCE /home/backup.sql;" 2>nul
if %ERRORLEVEL% EQU 0 (
    echo La base de datos se ha restaurado correctamente.
) else (
    echo Error: No se pudo restaurar la base de datos.
)

rem Eliminar el archivo SQL temporal dentro del contenedor
docker exec %DOCKER_CONTAINER_NAME% rm /home/backup.sql

rem Eliminar el archivo SQL temporal en la máquina local
del %TEMP_SQL_FILE%


exit /b
