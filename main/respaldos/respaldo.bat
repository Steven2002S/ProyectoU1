@echo off

REM Obtener la fecha actual
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I

REM Extraer año, mes y día de la fecha actual
set year=%datetime:~0,4%
set month=%datetime:~4,2%
set day=%datetime:~6,2%

REM Crear el formato del nombre del proyecto
set filename=proyecto_%day%%month%%year%

echo El nombre del archivo será: %filename%
REM Definir variables de conexión SSH a la máquina Debian
set debian_user=root
set debian_host=192.168.52.131
set debian_remote_path=/home/grupo-6/Escritorio

REM Definir variables de conexión al contenedor Docker MySQL
set docker_container_id=2cea84ac7d97fc446a2364e3d17bf35fd6841a5a243da32babe5844686c577fb
set mysql_user=root
set mysql_password=0939167675Ale
set mysql_database=bdd_hoteleria
set backup_filename=%filename%.sql

REM Ejecutar el comando mysqldump dentro del contenedor Docker para generar el respaldo
docker exec %docker_container_id% mysqldump -u%mysql_user% -p%mysql_password% %mysql_database% > %backup_filename%

REM Transferir el respaldo a la máquina Debian
echo Transfiriendo respaldo a la máquina Debian...
echo Usando SCP para transferir el archivo a %debian_host%
scp %backup_filename% %debian_user%@%debian_host%:%debian_remote_path%
if %errorlevel% neq 0 (
    echo Error: No se pudo transferir el respaldo a la máquina Debian.
    exit /b 1
)

rem Eliminar el archivo SQL temporal en la máquina local
del %backup_filename%

echo Respaldado con éxito y transferido a la máquina Debian.
exit /b 0