# Teacher’s Journal – Laravel Project

## Projectbeschrijving
Teacher’s Journal is een Laravel-applicatie voor het beheren van leerkrachten, klassen, studenten, lessen en activiteiten.  
De applicatie ondersteunt authenticatie, beveiligde routes via middleware en CRUD-functionaliteit met resource controllers.  
Er is zowel een webinterface als een API-achtige backend voorzien.

---

## Installatie

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
````

Applicatie beschikbaar op: `http://127.0.0.1:8000`

---

## Routes

### public roures

```
GET    /                          → Home
GET    /login                     → Login pagina
POST   /login                     → Login
GET    /register                  → Registratie pagina
POST   /register                  → Registratie

GET    /forgot-password           → Wachtwoord vergeten
POST   /forgot-password           → Reset-link verzenden
GET    /reset-password/{token}    → Reset formulier
POST   /reset-password            → Wachtwoord resetten

GET    /faq                       → FAQ
GET    /contact                   → Contact pagina
POST   /contact                   → Contactformulier verzenden
```

### Protected Routes 

```
POST   /logout                    → Logout
GET    /dashboard                 → Dashboard
GET    /app                       → Applicatiepagina

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

### API-routes 

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

## Bronnen

* Laravel officiële documentatie:
  [https://laravel.com/docs/12.x](https://laravel.com/docs/12.x)
* PHP documentatie:
  [https://www.php.net/docs.php](https://www.php.net/docs.php)
* REST API principes:
  [https://restfulapi.net/](https://restfulapi.net/)

---

