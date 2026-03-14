# IT15_Backend

Student Information System with Attendance Tracking

## 5. Submission Guidelines

### 5.1 Required Deliverables

#### GitHub Repository
- ✅ Complete source code for both frontend and backend
- ✅ Detailed README.md with setup instructions
- ✅ .env.example file with required environment variables

#### Documentation
- Screenshots of the working application (minimum 5)
- API documentation (endpoints and expected responses)
- List of technologies used with versions
- 3–5 minute video demonstration

---

### 5.2 Setup Instructions

#### Backend Setup
```bash
cd IT15_Backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

#### Frontend Setup
```bash
cd IT15_Frontend
npm install
npm start
```

---

## Backend Features

### Database Seeders
- **StudentSeeder**: 550 students with demographic information
- **CourseSeeder**: 20 courses across multiple departments
- **SchoolDaySeeder**: 6-month academic calendar with holidays and events
- **AttendanceSeeder**: Automated attendance records

### API Endpoints
- Authentication (Login/Logout)
- Student management
- Course management
- Dashboard statistics
- Attendance tracking

### Technologies Used
- **Framework**: Laravel 11
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum
- **PHP Version**: 8.2+

---

## Project Structure

```
IT15_Backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Resources/
│   ├── Models/
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── routes/
│   ├── api.php
│   ├── web.php
│   └── console.php
├── config/
├── storage/
├── tests/
└── .env.example
```

---

## Getting Started

1. **Clone the repository**
```bash
git clone https://github.com/charissebatistis/IT15_Backend.git
```

2. **Install dependencies**
```bash
composer install
```

3. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Run migrations with seeders**
```bash
php artisan migrate --seed
```

5. **Start the server**
```bash
php artisan serve
```

Server will run at `http://localhost:8000`

---

## API Documentation

### Authentication
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `GET /api/user` - Get current user

### Students
- `GET /api/students` - List all students
- `GET /api/students/{id}` - Get student details
- `GET /api/students/course/{courseId}` - Get students by course

### Courses
- `GET /api/courses` - List all courses
- `GET /api/courses/{id}` - Get course details
- `GET /api/courses/department/{department}` - Get courses by department

### Dashboard
- `GET /api/dashboard/stats` - Overall statistics
- `GET /api/dashboard/enrollment-trend` - Enrollment trends
- `GET /api/dashboard/attendance-trend` - Attendance statistics

---

## Environment Variables (.env.example)

```env
APP_NAME=IT15_Backend
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=it15_backend
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=localhost:3000
```

---

## License

This project is part of IT15 coursework.