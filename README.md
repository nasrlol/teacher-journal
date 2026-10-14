# Teacher’s Journal – Laravel Project

## Project description
Teacher’s Journal is a Laravel application for managing teachers, classes, students, lessons and activities.  
The application supports authentication, protected routes via middleware, and CRUD functionality with resource controllers.  
It provides both a web interface and an API-style backend.

---

## Installation

```bash
git clone <repository-url>
cd teachers-journal
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

The application is available at: `http://127.0.0.1:8000`

---

## Routes

### Public routes

```
GET    /                          → Home
GET    /login                     → Login page
POST   /login                     → Login
GET    /register                  → Registration page
POST   /register                  → Registration

GET    /forgot-password           → Forgot password
POST   /forgot-password           → Send reset link
GET    /reset-password/{token}    → Reset form
POST   /reset-password            → Reset password

GET    /faq                       → FAQ
GET    /contact                   → Contact page
POST   /contact                   → Submit contact form
```

### Protected routes

```
POST   /logout                    → Logout
GET    /dashboard                 → Dashboard
GET    /app                       → Application page

Resource routes:
GET|POST|PUT|DELETE
/teachers
/groups
/sub-groups
/students
/lessons
/activities

GET    /groups/{group}/students
GET    /groups/{group}/lessons
GET    /sub-groups/{subGroup}/students

POST   /students/{student}/add-points

POST   /lessons/{lesson}/attach-students
POST   /lessons/{lesson}/record-attendance
GET    /lessons/{lesson}/students

POST   /activities/{activity}/attach-students
POST   /activities/{activity}/record-score
GET    /activities/{activity}/students
```

### API routes

```
POST   /login
POST   /register
POST   /logout
GET    /me

Teachers:
GET    /teachers
POST   /teachers
GET    /teachers/{teacher}
PUT    /teachers/{teacher}
DELETE /teachers/{teacher}

Groups:
GET    /groups
POST   /groups
GET    /groups/{group}
PUT    /groups/{group}
DELETE /groups/{group}
GET    /groups/{group}/students
GET    /groups/{group}/lessons

Sub-groups:
GET    /sub-groups
POST   /sub-groups
GET    /sub-groups/{subGroup}
PUT    /sub-groups/{subGroup}
DELETE /sub-groups/{subGroup}
GET    /sub-groups/{subGroup}/students

Students:
GET    /students
POST   /students
GET    /students/{student}
PUT    /students/{student}
DELETE /students/{student}
POST   /students/{student}/add-points

Lessons:
GET    /lessons
POST   /lessons
GET    /lessons/{lesson}
PUT    /lessons/{lesson}
DELETE /lessons/{lesson}
POST   /lessons/{lesson}/attach-students
POST   /lessons/{lesson}/record-attendance
GET    /lessons/{lesson}/students

Activities:
GET    /activities
POST   /activities
GET    /activities/{activity}
PUT    /activities/{activity}
DELETE /activities/{activity}
POST   /activities/{activity}/attach-students
POST   /activities/{activity}/record-score
GET    /activities/{activity}/students
```

---

## Sources

* Official Laravel documentation:
  [https://laravel.com/docs/12.x](https://laravel.com/docs/12.x)
* PHP documentation:
  [https://www.php.net/docs.php](https://www.php.net/docs.php)
* REST API principles:
  [https://restfulapi.net/](https://restfulapi.net/)

---

