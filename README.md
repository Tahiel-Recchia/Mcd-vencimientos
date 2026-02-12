![Estado del Proyecto](https://img.shields.io/badge/Estado-Finalizado-success)
![Versión](https://img.shields.io/badge/Versión-1.0.0-blue)

> **Solución Full Stack** diseñada para automatizar el control de vida útil secundaria, impresión de etiquetas y trazabilidad de productos en entornos de comida rápida de alta demanda.

---

## 📸 Capturas de Pantalla
<h2>📸 Galería y Flujo de Trabajo</h2>

<table>
  <tr>
    <td width="40%" valign="top">
      <h3>1. Navegación y Selección de Productos</h3>
      <p><strong>Interfaz Táctil Optimizada:</strong> Diseño modular con botones grandes para facilitar el uso en pantallas táctiles de cocina.</p>
      <ul>
        <li><strong>Categorización:</strong> Separación lógica por estaciones de trabajo (McCafé, Servicio, Cocina).</li>
        <li><strong>Catálogo Visual:</strong> Selección rápida de productos con indicadores visuales claros.</li>
      </ul>
    </td>
    <td width="60%">
      <img src="screenshots/Categorias.png" alt="Menú de Categorías" style="max-width:100%;">
      <br><br>
      <img src="screenshots/McCafe.png" alt="Listado de Productos McCafe" style="max-width:100%;">
    </td>
  </tr>

  <tr>
    <td width="40%" valign="top">
      <h3>2. Motor de Reglas de Vencimiento</h3>
      <p><strong>Configuración Pre-Impresión:</strong> Antes de generar la etiqueta, el sistema permite ajustes finos.</p>
      <ul>
        <li><strong>Cálculo Automático:</strong> El sistema sugiere la hora exacta basada en las reglas del producto.</li>
        <li><strong>Ajuste Manual (Offset):</strong> Permite restar tiempo (horas/minutos) para compensar tiempos de descongelación o apertura previos.</li>
        <li><strong>Integración IoT:</strong> Al confirmar, se envía el comando RAW a la impresora térmica.</li>
      </ul>
    </td>
    <td width="60%">
      <img src="screenshots/selector-de-vencimiento.png" alt="Modal de Configuración de Vencimiento" style="max-width:100%;">
    </td>
  </tr>

  <tr>
    <td width="40%" valign="top">
      <h3>3. Dashboard de Monitoreo en Tiempo Real</h3>
      <p><strong>Gestión Visual de Riesgos:</strong> Panel de control específico por sector.</p>
      <ul>
        <li><strong>Semáforo de Estados:</strong>
            <br>🟢 <strong>Seguro:</strong> > 45 mins.
            <br>🟡 <strong>Atención:</strong> < 45 mins.
            <br>🔴 <strong>Crítico:</strong> < 15 mins (Alerta Sonora).
        </li>
        <li><strong>Ordenamiento Prioritario:</strong> Los productos próximos a vencer suben automáticamente a la primera posición.</li>
      </ul>
    </td>
    <td width="60%">
      <img src="screenshots/Dashboard-McCafe.png" alt="Dashboard Sector McCafe" style="max-width:100%;">
      <br><br>
      <img src="screenshots/Alerta-Vencimiento.png" alt="Alerta Roja de Vencimiento Critico" style="max-width:100%;">
    </td>
  </tr>

  <tr>
    <td width="40%" valign="top">
      <h3>4. Centro de Comando Global</h3>
      <p><strong>Visión Unificada (Gerencial):</strong></p>
      <p>Permite a los gerentes supervisar todos los sectores desde una única pantalla, detectando cuellos de botella o pérdidas potenciales en cualquier área del restaurante simultáneamente.</p>
    </td>
    <td width="60%">
      <img src="screenshots/dashboard-Global.png" alt="Dashboard Global de Todas las Categorías" style="max-width:100%;">
    </td>
  </tr>
</table>
---

## 🚀 Funcionalidades Principales

### 🎛️ Control y Gestión
* **Categorización Inteligente:** Organización por estaciones (Cocina, Servicio, McCafé, etc.) con navegación fluida.
* **Reglas de Vencimiento Dinámicas:** Cada producto tiene su lógica de tiempo asignada.
* **Ajuste Temporal (Offset):** Permite restar horas/minutos/días al vencimiento antes de imprimir, ideal para ajustar el tiempo real de descongelación o apertura.

### 🖨️ Integración de Hardware (IoT)
* **Impresión Térmica Directa:** Conexión con impresoras POS (ESC/POS) para generar etiquetas físicas de trazabilidad al instante.
* **Driver Personalizado:** Configuración específica para detectar la impresora de red o local bajo el alias `"ticketera"`.

### 📊 Dashboard en Tiempo Real
* **Monitor de Estados (Semáforo):** Visualización clara del estado de los productos:
    * 🟢 **Verde:** > 45 minutos de vida útil.
    * 🟡 **Amarillo:** < 45 minutos (Advertencia).
    * 🔴 **Rojo:** < 15 minutos (Peligro).
* **Alertas Sonoras:** Notificación auditiva automática cuando un producto entra en estado crítico (Rojo).
* **Ordenamiento Inteligente:** Los productos próximos a vencer aparecen automáticamente primero.
* **Dashboard Global:** Vista unificada que agrupa los vencimientos activos de las 4 categorías en una sola pantalla de control.

### 🔄 Acciones de Trazabilidad
* **Renovación Rápida:** Reimpresión de etiqueta y reinicio del temporizador con un solo clic.
* **Importación entre Sectores:** Capacidad de compartir un mismo timer (producto) entre diferentes categorías sin duplicar la lógica de vencimiento.
* **Eliminación:** Gestión de mermas y retiro de productos.

---

## 🛠️ Stack Tecnológico

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

* **Backend:** PHP 8, Laravel (Blade Templates).
* **Frontend:** JavaScript Vanilla (ES6+, DOM Manipulation, Fetch API), Tailwind CSS.
* **Servidor:** Apache (vía XAMPP).
* **Base de Datos:** MySQL.
* **Hardware:** Integración con impresoras térmicas ESC/POS.

---

## ⚙️ Requisitos de Instalación

Para correr este proyecto localmente necesitas:

1.  **PHP 8.1+** instalado.
2.  **Node.js & NPM**.
3.  **Composer**.
4.  **XAMPP** (o cualquier servidor con Apache y MySQL).
5.  **Drivers de Impresora:** Drivers genéricos o específicos de la marca de tu impresora POS instalados en el sistema operativo.

---

## 🔧 Configuración e Instalación

1.  **Clonar el repositorio:**
    ```bash
    git clone [https://github.com/Tahiel-Recchia/Mcd-vencimientos.git]
    cd Mcd-vencimientos
    ```

2.  **Instalar dependencias de Backend:**
    ```bash
    composer install
    ```

3.  **Instalar dependencias de Frontend:**
    ```bash
    npm install
    npm run build
    ```

4.  **Configurar Entorno:**
    * Duplica el archivo `.env.example` y renómbralo a `.env`.
    * Configura tus credenciales de base de datos en el archivo `.env`.

5.  **Base de Datos:**
    ```bash
    php artisan migrate --seed
    ```

6.  **⚠️ Configuración CRÍTICA de la Impresora:**
    * Para que el sistema de impresión funcione, debes compartir tu impresora en la red (o localmente) y **nombrarla obligatoriamente** como:
    * **Nombre del recurso compartido:** `ticketera`
    * *El sistema buscará este nombre específico para enviar los comandos RAW de impresión.*

7.  **Ejecutar:**
    * Inicia Apache y MySQL en XAMPP.
    * (Opcional) Usa el servidor de desarrollo de Laravel:
    ```bash
    php artisan serve
    ```

---

## 👤 Autor

**Tahiel Recchia**
* **Rol:** Desarrollador Full Stack
* [LinkedIn](https://www.linkedin.com/in/tahiel-recchia)
* [GitHub](https://github.com/Tahiel-Recchia)

---

> *Este proyecto fue desarrollado para optimizar procesos reales en un entorno de comida rápida, reduciendo el error humano y mejorando la seguridad alimentaria.*
