# Vokter.

Sistema de e-comerse digital con vista exclusiva y pensada de cara al usuario. Para la consulta y compra de productos. Incluye registro y autenticacion de credenciales, gestion de perfil, historial de compras y la opcion de la descarga de las mismas en formato PDF y cuenta con multiples metodos de ordenamiento de cara a los productos en función de que se necesite.

Project Volter es un proyecto derivado de Vokter.app con una reconstrucción nueva desde cero con ideas y control creativo propio, de cara a las decisiones arquitectónicas, y se desarrollo como prueba técnica laboral.

## Caracteristicas

- Registro y autenticación (propia del sistema, no con autenticación con Google) de credenciales de usuarios y validacion de correo electrónico.
- Incio y cierre de Sesión.
- Edición de informacion personal desde el perfil de usuario.
- Historial de compras, condescarga de factura en formato pdf.
- Ordenamiento de productos por categoria('Tecnología','Ropa y Calzado para hombre y mujer','Sabanas para el hogar.').
- Buscador de productos con reporte de terminos equivalentes (sinonimos).
- Carrito de compras con flujo de compra directa.


## Tecnologías 

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP, con PDO y consultas preparadas para prevenir inyección SQL
- **Base de datos**: MySQL
- **Generación de PDF**: FPDF
- **Entorno de desarrollo**: XAMPP y visual Studio Code.

El proyecto se organizo con el patrón de arquitectura **Modelo-Vista-Controlador (MVC)**, reflejado directamente en la organización de carpetas del repositorio.

## Instalación

1. Clona este repositorio dentro de la carpeta `htdocs` de tu instalación de XAMPP.

2. Abre el panel de control de XAMPP e inicia los servicios **Apache** y **MySQL**. Verifica que ambos queden en color verde antes de continuar.

3. Desde el panel principal de XAMPP, haz clic en el botón **Admin** junto a MySQL (o entra directamente a `http://localhost/phpmyadmin` en tu navegador).

4. En phpMyAdmin, crea una base de datos nueva y llámala exactamente `wokterdb`.

5. Ve a la pestaña **SQL** de esa base de datos, y pega el contenido completo del archivo `database/wokterdb.sql` de este repositorio. Haz clic en **Continuar** para ejecutarlo.

6. Verifica el mensaje de confirmación en verde, indicando que la importación se realizó con éxito.

7. Abre `Config/database.php` y ajusta las credenciales de conexión según tu entorno local (usuario, contraseña y puerto).

8. **Nota:** si tu instalación de MySQL ya usa el puerto 3306 (predeterminado) para otro servicio y presenta conflictos, puedes configurar XAMPP para usar el puerto 3307 en su lugar. Si haces este cambio, ajusta también el puerto correspondiente en `Config/database.php`.

9. Abre tu navegador en:
```
   http://localhost/projectVokter/Views/Principal.php
```

## Estructura del proyecto

| Carpeta |

| `Config` | Archivo de configuración de conexión a la base de datos. |
| `Controllers` | Lógica de negocio: trabaja en conjunto con los Models para abstraer y ejecutar consultas específicas hacia la base de datos. |
| `Models` | Lógica de acceso a datos. Todos los archivos terminan en `Server.php`. |
| `Views` | Archivos `.php` responsables de la interfaz gráfica de cara al usuario. Incluye la subcarpeta `partials`, con `header.php` y `footer.php` — separados para poder importarse fácilmente en cualquier vista del sitio sin duplicar código. |
| `Libs` | Librerías externas descargadas. Incluye FPDF, que permite generar y descargar archivos en formato PDF desde PHP. |
| `Images` | Todas las imágenes utilizadas en el proyecto, sin depender de un servicio externo de almacenamiento. Se usa el formato JPG por su compatibilidad, calidad y disponibilidad sin licenciamiento. |
| `database` | Script `.sql` con la estructura completa de la base de datos: tablas de usuarios, productos, categorías, variantes, carritos, facturas y estados de pedido, junto con datos de ejemplo para el catálogo de productos. No incluye usuarios de prueba, ya que cada cliente se registra mediante su propio formulario. |
| `Documentacion` | Documento con la redacción de objetivos del proyecto, levantamiento de requerimientos, historias de usuario, diagramas de arquitectura y conclusiones finales. |

## Documentación adicional

Para el detalle completo de arquitectura, diagramas UML y requerimientos, consulta el documento disponible en la carpeta `Documentacion` de este repositorio.

## Autor

John Alejandro Celis — Ingeniero de Software (en formación académica), Universidad Manuela Beltrán.

## Licencia

Proyecto desarrollado con fines académicos y de evaluación técnica.
