Puertos (estándar del proyecto)
Laravel (API Gateway): http://127.0.0.1:8000

Django (microservicio): http://127.0.0.1:8001

Flask (microservicio): http://127.0.0.1:8002

Express (microservicio): http://127.0.0.1:3000

Requisitos
Git

Python 3.x

Node.js + npm

PHP 8.3 + Composer

MySQL (Laragon recomendado en Windows)

1) Clonar
powershell
git clone https://github.com/BrahianStiven/Ing_soft2
cd TU_REPO
2) Flask (puerto 8002, BD flask)
2.1 Crear .env
powershell
cd Flask\api
copy .env.example .env
Asegúrate de que en Flask/api/.env exista:

text
DATABASE_URL=mysql+pymysql://root:@localhost/flask
SECRET_KEY=ClaveDePrueba
2.2 Instalar dependencias y correr
powershell
python -m venv .venv
.\.venv\Scripts\activate
pip install -r requirements.txt
python app.py
2.3 Probar
GET http://127.0.0.1:8002/health

GET http://127.0.0.1:8002/health/db

3) Express (puerto 3000)
En otra terminal:

powershell
cd Express_api
npm install
npm run start
Probar:

GET http://127.0.0.1:3000/health

4) Django (puerto 8001)
En otra terminal (ajustaremos requirements.txt/venv según quede tu carpeta Django):

powershell
cd Django\mi_api
python -m venv .venv
.\.venv\Scripts\activate
pip install -r ..\requirements.txt
python manage.py runserver 127.0.0.1:8001
Probar (cuando esté el endpoint):

GET http://127.0.0.1:8001/api/health

5) Laravel (puerto 8000, BD recetas)
En otra terminal:

powershell
cd Laravel\api_laravel
copy .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
En Laravel/api_laravel/.env configura:

text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recetas
DB_USERNAME=root
Probar:

GET http://127.0.0.1:8000/api/users

Nota importante (para evitar errores)
Cada microservicio se ejecuta en una terminal separada; no cierres una terminal si ese servicio está corriendo.
