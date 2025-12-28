# API REST - Sistema de Gestión de Turnos

API REST desarrollada en PHP vanilla (sin frameworks) para la gestión de turnos médicos, con autenticación JWT y arquitectura limpia.

## 🚀 Características

- ✅ Autenticación JWT (JSON Web Tokens)
- ✅ Registro y login de profesionales
- ✅ Encriptación de contraseñas con BCrypt
- ✅ Arquitectura por capas (Controller, Service, Repository)
- ✅ Middleware personalizado (CORS, Auth, JSON)
- ✅ Router personalizado con soporte para middlewares
- ✅ DTOs con propiedades readonly
- ✅ PSR-4 Autoloading con Composer
- ✅ Docker para desarrollo y producción
- ✅ MySQL 8.0

## 📋 Requisitos

- Docker 20.10+
- Docker Compose 2.0+

## 🛠️ Instalación

1. **Clonar el repositorio:**
```bash
git clone <repository-url>
cd api-rest-vanilla
```

2. **Crear archivo `.env`:**
```bash
cp .env.example .env
```

Configurar las variables:
```env
MYSQL_ROOT_PASSWORD=rootpassword
MYSQL_DATABASE=turnos_db
MYSQL_USER=user
MYSQL_PASSWORD=password
JWT_SECRET=tu_secreto_super_seguro_cambialo_en_produccion
```

3. **Levantar contenedores:**
```bash
docker-compose up -d
```

4. **Instalar dependencias:**
```bash
docker exec -it php_app composer install
```

5. **Crear base de datos:**
```bash
docker exec -i mysql_db mysql -uroot -prootpassword turnos_db < database/schema.sql
```

6. **Acceder a la aplicación:**
```
http://localhost:8080
```

## 📁 Estructura del Proyecto

```
api-rest-vanilla/
├── App/
│   ├── Config/
│   │   └── Database.php          # Configuración PDO
│   ├── Controller/
│   │   └── AuthController.php    # Controlador de autenticación
│   ├── Core/
│   │   └── Router.php            # Sistema de ruteo personalizado
│   ├── Dto/
│   │   ├── LoginRequest.php      # DTO para login
│   │   ├── LoginResponse.php     # DTO para respuesta de login
│   │   └── RegisterRequest.php   # DTO para registro
│   ├── Middleware/
│   │   ├── AuthMiddleware.php    # Validación de JWT
│   │   ├── CorsMiddleware.php    # Headers CORS
│   │   └── JsonMiddleware.php    # Content-Type JSON
│   ├── Model/
│   │   ├── Professional.php      # Modelo de profesional
│   │   └── User.php              # Modelo de usuario
│   ├── Repository/
│   │   ├── ProfessionalRepository.php
│   │   └── UserRepository.php
│   ├── Routes/
│   │   ├── api.php               # Definición de rutas
│   │   └── auth.php              # Rutas de autenticación
│   ├── Service/
│   │   └── AuthService.php       # Lógica de negocio
│   └── Utils/
│       ├── JwtUtils.php          # Generación y validación JWT
│       └── PasswordEncoder.php   # Hash de contraseñas
├── database/
│   └── schema.sql                # Schema de la base de datos
├── vendor/                       # Dependencias de Composer
├── .env                          # Variables de entorno
├── .gitignore
├── composer.json
├── docker-compose.yml
├── Dockerfile
├── index.php                     # Entry point
└── README.md
```

## 🔌 API Endpoints

### Autenticación

#### Registro de Profesional
```http
POST /api/auth/register
Content-Type: application/json

{
  "email": "doctor@example.com",
  "password": "password123",
  "name": "Dr. Juan Pérez",
  "specialty": "Cardiología",
  "license": "MP12345"
}
```

**Respuesta exitosa (201):**
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "email": "doctor@example.com",
    "role": "PROFESSIONAL",
    "name": "Dr. Juan Pérez"
  }
}
```

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "doctor@example.com",
  "password": "password123"
}
```

**Respuesta exitosa (200):**
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "email": "doctor@example.com",
    "role": "PROFESSIONAL",
    "name": "Dr. Juan Pérez"
  }
}
```

### Rutas Protegidas

Todas las rutas protegidas requieren el header:
```http
Authorization: Bearer <token>
```

## 🗄️ Base de Datos

### Tablas

- **users**: Usuarios del sistema (autenticación)
- **professionals**: Perfiles de profesionales
- **clients**: Clientes/pacientes
- **appointments**: Turnos médicos

### Diagrama de Relaciones

```
users (1) ──→ (1) professionals
clients (1) ──→ (N) appointments
professionals (1) ──→ (N) appointments
```

## 🔒 Seguridad

- **Contraseñas**: BCrypt con cost factor 12
- **JWT**: HS256, expiración 1 hora
- **PDO**: Prepared statements para prevenir SQL injection
- **Variables sensibles**: Almacenadas en `.env`

## 🧪 Testing con Postman/cURL

### Registro:
```bash
curl -X POST http://localhost:8080/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123",
    "name": "Dr. Test",
    "specialty": "General",
    "license": "MP99999"
  }'
```

### Login:
```bash
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

## 🐳 Comandos Docker Útiles

```bash
# Ver logs del contenedor PHP
docker logs php_app -f

# Ver logs del contenedor MySQL
docker logs mysql_db -f

# Ejecutar comandos dentro del contenedor
docker exec -it php_app bash

# Regenerar autoloader de Composer
docker exec -it php_app composer dump-autoload

# Acceder a MySQL
docker exec -it mysql_db mysql -uuser -ppassword turnos_db

# Reiniciar contenedores
docker-compose restart

# Detener y eliminar contenedores
docker-compose down

# Ver estado de los contenedores
docker-compose ps
```

## 🛠️ Desarrollo

### Agregar Nueva Ruta

1. Crear controller en `App/Controller/`
2. Definir ruta en `App/Routes/api.php`:
```php
$router->get('/api/professionals', fn() => ProfessionalController::list(), [
    fn() => AuthMiddleware::handle()
]);
```

### Agregar Middleware

1. Crear clase en `App/Middleware/`
2. Implementar método estático `handle()`
3. Aplicar en rutas específicas o globalmente

## 📚 Tecnologías

- **PHP 8.2**: Lenguaje principal
- **MySQL 8.0**: Base de datos
- **Composer**: Gestor de dependencias
- **Docker**: Containerización
- **Apache**: Servidor web
- **firebase/php-jwt**: Librería JWT

## 🤝 Convenciones de Código

- **PSR-4**: Autoloading estándar
- **PSR-12**: Estilo de código
- **PascalCase**: Nombres de clases y carpetas
- **camelCase**: Métodos y propiedades
- **SCREAMING_SNAKE_CASE**: Constantes

## 📝 TODO

- [ ] Implementar CRUD de profesionales
- [ ] Implementar CRUD de clientes
- [ ] Implementar gestión de turnos
- [ ] Agregar validación de entrada
- [ ] Agregar manejo de errores personalizado
- [ ] Agregar logging
- [ ] Agregar tests unitarios (PHPUnit)
- [ ] Agregar paginación
- [ ] Agregar filtros y búsqueda
- [ ] Documentación con Swagger/OpenAPI

## 📄 Licencia

MIT

## 👤 Autor

Mateo - [GitHub](https://github.com/mateo)
