# QR Attendance System Professional Architecture

## Architectural Style

The project follows a layered architecture combined with DevOps, Observability and Cloud-Native practices.

---

## High-Level Architecture

```text
                    User
                     │
                     ▼

             QR Attendance UI
                     │
                     ▼

               Controllers
                     │
                     ▼

                 Services
                     │
                     ▼

              Repositories
                     │
                     ▼

                  MySQL

-------------------------------------------------

          Monitoring & Observability

Prometheus
     │
     ▼

/api/metrics.php
     │
     ▼

Application Metrics

Grafana
     │
     ▼

Business Dashboards

-------------------------------------------------

CI/CD Pipeline

Developer
     │
 git push
     │
     ▼

GitHub Actions
     │
     ├── Composer Validation
     ├── Dependency Installation
     ├── PHPUnit Execution
     └── Build Validation

-------------------------------------------------

Deployment

Docker
     │
     ▼

Docker Compose
     │
     ▼

Kubernetes
```

---

## Application Layers

### Presentation Layer

Responsible for handling user requests and responses.

Components:

* Dashboard
* QR Scanner Interface
* Authentication Views

---

### Controller Layer

Responsible for processing HTTP requests.

Components:

* AttendanceController
* EmployeeController
* CompanyController
* MetricsController

---

### Service Layer

Contains business rules and application logic.

Components:

* AttendanceService
* EmployeeService
* CompanyService

Responsibilities:

* Attendance validation
* Lateness calculation
* Notification generation
* Business workflows

---

### Repository Layer

Responsible for database access.

Components:

* AttendanceRepository
* EmployeeRepository
* CompanyRepository
* NotificationRepository

Pattern:

* Repository Pattern

---

### Persistence Layer

Database engine:

* MySQL 8

Main entities:

* Employees
* Attendance
* Companies
* Notifications
* Users
* Departments

---

## Design Patterns

Implemented patterns:

* Repository Pattern
* Service Layer Pattern
* Dependency Injection
* Separation of Concerns

---

## DevOps Architecture

### Continuous Integration

GitHub Actions pipeline executes:

* Composer validation
* Dependency installation
* PHPUnit test suite
* Build verification

---

### Containerization

Docker components:

* PHP 8
* Apache
* MySQL

Orchestrated using:

* Docker Compose

---

### Kubernetes

Resources:

* Deployment
* Service
* MySQL Deployment
* MySQL Service

---

## Testing Architecture

Testing framework:

* PHPUnit

Tested layers:

* Repositories
* Services
* Controllers

Coverage engine:

* Xdebug

---

## Monitoring Architecture

Metrics endpoint:

```text
/api/metrics.php
```

Collected metrics:

* employees_total
* attendance_total
* late_arrivals_total
* companies_total
* notifications_total
* qr_attendance_system_up

Monitoring stack:

* Prometheus
* Grafana

---

## Security Components

Authentication:

* JWT (firebase/php-jwt)

Authorization:

* Protected routes
* Session validation

---

## Reporting Components

Email:

* PHPMailer

Excel Reports:

* PhpSpreadsheet

PDF Reports:

* PDF Export Module
