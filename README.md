# 🎬 MañoCines
<details>
  <summary><h3>Guía en Español</h3></summary>
    
# 📜 Descripción

**MañoCines** es una aplicación web desarrollada con **Laravel** y **React** que permite gestionar la venta de entradas de cine y productos de bar de forma eficiente y moderna. La aplicación está pensada para ser ejecutada localmente con **XAMPP** o **MAMP**, y utiliza **MySQL** como sistema de base de datos (gestionado mediante PhpMyAdmin).

---

## 🧩 Tecnologías utilizadas

- Backend: [Laravel 11+](https://laravel.com/)
- Frontend: [React + Vite](https://vitejs.dev/)
- Base de datos: MySQL (via PhpMyAdmin)
- Servidor local: XAMPP o MAMP

---

## 🚀 Funcionalidades

- Gestión de películas y funciones.
- Selección de butacas por función.
- Venta de entradas.
- Venta de productos de bar.
- Gestión de usuarios y sesiones.
- Backend seedeado con datos de ejemplo para pruebas.

---

## 🛠️ Instalación paso a paso

### 1. Clonar el repositorio

```bash
git clone https://github.com/tuusuario/manocines.git
cd manocines
```

### 2. Instalar Laravel manualmente

Dado que algunos archivos están excluidos en `.gitignore`, debes crear una nueva instalación de Laravel:

```bash
composer create-project laravel/laravel manocines
```

Luego, reemplaza los archivos del nuevo proyecto con los del repositorio que has clonado (salvo la carpeta `vendor`, `.env`, y `node_modules`).

### 3. Configurar `.env`

Copia el contenido proporcionado del archivo `.env` (como el que aparece más abajo) y colócalo en la raíz del proyecto. Asegúrate de tener configurado:

- `DB_DATABASE=manocines`
- `DB_USERNAME=root`
- `DB_PASSWORD=` (en blanco para XAMPP/MAMP)

⚠️ **Importante:** Crea una base de datos vacía llamada `manocines` desde PhpMyAdmin.

### 4. Instalar dependencias de PHP y JS

```bash
composer install
npm install
npm run dev
```

### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 6. Migrar y seedear la base de datos

```bash
php artisan migrate:fresh --seed
```

Esto eliminará cualquier dato previo y poblará la base de datos con datos de prueba (usando los seeders del proyecto).

---

## 🖥️ Uso con XAMPP o MAMP

### Si usas **XAMPP**:

- Asegúrate de que Apache y MySQL están activos.
- Coloca el proyecto en `htdocs`.
- Accede desde el navegador a: [http://localhost/manocines/public](http://localhost/manocines/public)

### Si usas **MAMP**:

- Asegúrate de colocar el proyecto en `/Applications/MAMP/htdocs/`.
- Accede a PhpMyAdmin en [http://localhost/phpmyadmin](http://localhost/phpmyadmin) para crear la base de datos.
- Inicia Apache y MySQL desde MAMP.
- Accede desde el navegador a: [http://localhost:8888/manocines/public](http://localhost:8888/manocines/public)

💡 Puedes configurar un **VirtualHost** si deseas acceder con un dominio personalizado.

---

## 🧪 Pruebas

Para ejecutar las pruebas, puedes usar:

```bash
php artisan test
```

---

## ⚙️ Variables de entorno de ejemplo

```env
APP_NAME=MañoCines
APP_ENV=local
APP_KEY=base64:nznwHtPKEfooBt3IlaWNLjSnUG5p0mRgKvwLS7eR/N4=
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_ASSET_URL=http://localhost:8000
APP_PORT=8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manocines
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

---

## 🤝 Contribuciones

Si deseas colaborar con el proyecto, ¡eres bienvenido! Abre un issue o envía un pull request.

---

## 📄 Licencia

Este proyecto está licenciado bajo MIT. Consulta el archivo `LICENSE` para más detalles.

</details>
<br>
<details>
  <summary><h3>English manual</h3></summary>
    # 📜 Description

**MañoCines** is a web application built with **Laravel** and **React** to efficiently manage movie ticket sales and bar products. The app is designed to run locally using **XAMPP** or **MAMP**, and uses **MySQL** (managed via PhpMyAdmin) as its database system.

---

## 🧩 Technologies Used

- Backend: [Laravel 11+](https://laravel.com/)
- Frontend: [React + Vite](https://vitejs.dev/)
- Database: MySQL (via PhpMyAdmin)
- Local Server: XAMPP or MAMP

---

## 🚀 Features

- Movie and screening management.
- Seat selection per screening.
- Ticket sales.
- Bar product sales.
- User and session management.
- Seeded backend with sample data for testing.

---

## 🛠️ Installation Guide

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/manocines.git
cd manocines
```

### 2. Manually install Laravel

Some files are excluded in `.gitignore`, so you must create a fresh Laravel installation:

```bash
composer create-project laravel/laravel manocines
```

Then, replace the files in the new project with the ones from the cloned repository (excluding `vendor`, `.env`, and `node_modules`).

### 3. Configure `.env`

Copy the provided `.env` content (see below) into the project root. Make sure to configure:

- `DB_DATABASE=manocines`
- `DB_USERNAME=root`
- `DB_PASSWORD=` (empty for XAMPP/MAMP)

⚠️ **Important:** Create an empty database named `manocines` in PhpMyAdmin.

### 4. Install PHP and JS dependencies

```bash
composer install
npm install
npm run dev
```

### 5. Generate the application key

```bash
php artisan key:generate
```

### 6. Migrate and seed the database

```bash
php artisan migrate:fresh --seed
```

This will drop existing tables and populate the database with test data using the provided seeders.

---

## 🖥️ Using XAMPP or MAMP

### With **XAMPP**:

- Ensure Apache and MySQL are running.
- Place the project in the `htdocs` folder.
- Access the app at: [http://localhost/manocines/public](http://localhost/manocines/public)

### With **MAMP**:

- Place the project inside `/Applications/MAMP/htdocs/`.
- Use [http://localhost/phpmyadmin](http://localhost/phpmyadmin) to create the database.
- Start Apache and MySQL from MAMP.
- Access the app at: [http://localhost:8888/manocines/public](http://localhost:8888/manocines/public)

💡 You can configure a **VirtualHost** to use a custom domain.

---

## 🧪 Testing

Run tests using:

```bash
php artisan test
```

---

## ⚙️ Sample Environment Variables

```env
APP_NAME=MañoCines
APP_ENV=local
APP_KEY=base64:nznwHtPKEfooBt3IlaWNLjSnUG5p0mRgKvwLS7eR/N4=
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_ASSET_URL=http://localhost:8000
APP_PORT=8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manocines
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

---

## 🤝 Contributions

Feel free to contribute! Open an issue or submit a pull request.

---

## 📄 License

This project is licensed under the MIT License. See the `LICENSE` file for details.

</details>
