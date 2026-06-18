# QR Attendance System Professional

![Build Status](https://github.com/juandev-mx/devops-capstone-project/actions/workflows/ci-build.yaml/badge.svg)


## Enterprise QR-Based Attendance Management Platform

![PHP](https://img.shields.io/badge/PHP_8-777BB4?style=for-the-badge\&logo=php\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL_8-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge\&logo=composer\&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-6C3483?style=for-the-badge\&logo=php\&logoColor=white)
![Xdebug](https://img.shields.io/badge/Xdebug-86C232?style=for-the-badge)
![GitHub Actions](https://img.shields.io/badge/GitHub_Actions-2088FF?style=for-the-badge\&logo=github-actions\&logoColor=white)

![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge\&logo=docker\&logoColor=white)
![Kubernetes](https://img.shields.io/badge/Kubernetes-326CE5?style=for-the-badge\&logo=kubernetes\&logoColor=white)
![Prometheus](https://img.shields.io/badge/Prometheus-E6522C?style=for-the-badge\&logo=prometheus\&logoColor=white)
![Grafana](https://img.shields.io/badge/Grafana-F46800?style=for-the-badge\&logo=grafana\&logoColor=white)

![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge\&logo=bootstrap\&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge\&logo=chartdotjs\&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge\&logo=javascript\&logoColor=black)
![JWT](https://img.shields.io/badge/JWT-black?style=for-the-badge\&logo=jsonwebtokens)
![PHPMailer](https://img.shields.io/badge/PHPMailer-4CAF50?style=for-the-badge)

![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge\&logo=git\&logoColor=white)
![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge\&logo=github\&logoColor=white)
![Agile](https://img.shields.io/badge/Agile-Scrum-blue?style=for-the-badge)
![Kanban](https://img.shields.io/badge/Kanban-Project_Management-green?style=for-the-badge)
![Gherkin](https://img.shields.io/badge/Gherkin-BDD-orange?style=for-the-badge)
![Firebase JWT](https://img.shields.io/badge/Firebase_JWT-FFCA28?style=for-the-badge&logo=firebase&logoColor=black)
![PhpSpreadsheet](https://img.shields.io/badge/PhpSpreadsheet-217346?style=for-the-badge&logo=microsoft-excel&logoColor=white)

A professional attendance management platform built using PHP, MySQL, Docker, Kubernetes, GitHub Actions, PHPUnit, Prometheus and Grafana.

The system allows organizations to automate employee attendance registration through QR code scanning while providing monitoring, analytics, automated reporting and DevOps practices.


---

## Project Overview

This project was developed following Software Engineering, DevOps and Agile methodologies.

Main goals:

* Employee attendance management
* QR-based attendance registration
* Multi-company support
* Automated lateness detection
* Automated absence reporting
* Real-time notifications
* Dashboard analytics
* Continuous Integration
* Containerized deployment
* Kubernetes orchestration
* Monitoring and Observability

---

# System Architecture

The application follows a layered architecture.

```text
Controllers
      ↓
Services
      ↓
Repositories
      ↓
MySQL Database
```

### Controller Layer

Handles HTTP requests and responses.

Examples:

* AttendanceController
* CompanyController
* EmployeeController
* MetricsController

### Service Layer

Contains business logic.

Examples:

* AttendanceService
* EmployeeService
* CompanyService

### Repository Layer

Handles database access.

Examples:

* AttendanceRepository
* EmployeeRepository
* CompanyRepository
* NotificationRepository

---

# Core Features

## Employee Management

* Employee registration
* Employee update
* Employee lookup
* QR assignment
* Schedule assignment

---

## Attendance Registration

Employees register attendance using QR codes.

Supported operations:

* Entry registration
* Exit registration
* Duplicate prevention
* Attendance validation

---

## Automatic Lateness Detection

The system compares attendance registration time against the assigned entry schedule.

Example:

```text
Assigned Entry Time: 08:00
Attendance Time: 08:15

Result:
Late Arrival
```

---

## Real-Time Notifications

When an employee performs attendance actions:

* Entry notification created
* Exit notification created
* Dashboard updated

---

## Dashboard Analytics

The dashboard provides:

* Total employees
* Attendance records
* Late arrivals
* Notifications
* Companies
* Historical attendance trends

---

## Absence Monitoring

At the end of the day the system:

1. Detects employees without attendance.
2. Generates absence reports.
3. Sends email notifications.

Powered by:

* PHPMailer
* SMTP

---

# Tech Stack

| Category           | Technology  |
| ------------------ | ----------- |
| Backend            | PHP 8       |
| Database           | MySQL 8     |
| Frontend           | HTML5       |
| Styling            | Bootstrap   |
| JavaScript         | Vanilla JS  |
| Charts             | Chart.js    |
| QR Scanner         | Html5Qrcode |
| Authentication     | JWT         |
| Email              | PHPMailer   |
| Dependency Manager | Composer    |

---

# DevOps Stack

| Area             | Tool           |
| ---------------- | -------------- |
| Source Control   | Git            |
| Repository       | GitHub         |
| CI/CD            | GitHub Actions |
| Containerization | Docker         |
| Orchestration    | Kubernetes     |
| Unit Testing     | PHPUnit        |
| Coverage         | Xdebug         |

---

# Monitoring Stack

| Area       | Technology       |
| ---------- | ---------------- |
| Metrics    | Prometheus       |
| Dashboards | Grafana          |
| Endpoint   | /api/metrics.php |

Collected Metrics:

* employees_total
* attendance_total
* late_arrivals_total
* companies_total
* notifications_total
* qr_attendance_system_up

---

# Project Structure

```text
src/
│
├── Controllers/
├── Services/
├── Repositories/
├── Models/
├── Helpers/
│
tests/
│
├── Controllers/
├── Services/
├── Repositories/
├── Helpers/
│
docker/
│
k8s/
│
monitoring/
│
config/
│
api/
```

---

# Database

Main entities:

## Employees

Stores employee information.

## Attendance

Stores attendance records.

## Companies

Stores company information.

## Notifications

Stores generated notifications.

---

# Testing Strategy

The project implements automated testing using PHPUnit.

Covered layers:

* Repository Layer
* Service Layer
* Controller Layer
* Helper Layer

Current implementation includes:

* Unit Tests
* Business Logic Validation
* Repository Testing
* Controller Validation

---

# Code Coverage

Coverage generated through Xdebug.

```bash
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html coverage
```

Coverage reports are generated inside:

```text
coverage/
```

---

# Continuous Integration

GitHub Actions automatically executes:

```text
Composer Validation
↓
Dependency Installation
↓
PHPUnit Execution
↓
Build Validation
```

Triggered on:

* Push
* Pull Request

---

# Docker Deployment

Build containers:

```bash
docker compose up --build
```

Application:

```bash
http://localhost:8080
```

---

# Kubernetes Deployment

Resources:

```text
k8s/

deployment.yaml
service.yaml
mysql-deployment.yaml
mysql-service.yaml
```

Deploy:

```bash
kubectl apply -f k8s/
```

Verify:

```bash
kubectl get pods
kubectl get services
```

---

# Monitoring & Observability

Prometheus scrapes metrics from:

```text
/api/metrics.php
```

Grafana visualizes:

* Employees
* Attendance
* Late arrivals
* Notifications
* Companies

---

# Agile Project Management

The project was managed using:

* GitHub Issues
* GitHub Projects
* Kanban Board
* Gherkin User Stories

Workflow:

```text
To Do
↓
In Progress
↓
Review
↓
Done
```

Documented Features:

* Attendance Management
* Notifications
* Dashboard Analytics
* Absence Detection
* Testing
* CI/CD
* Docker
* Kubernetes
* Monitoring

---

# Composer Packages

The project uses the following Composer packages:

| Package | Purpose |
|----------|----------|
| firebase/php-jwt | Authentication and JWT token management |
| phpmailer/phpmailer | Email notifications and absence reports |
| phpoffice/phpspreadsheet | Excel report generation and exports |
| phpunit/phpunit | Automated testing |

# Installation

Clone repository:

```bash
git clone <repository-url>
```

Install dependencies:

```bash
composer install
```

Import database:

```bash
mysql -u root -p control_asistencias_qr < control_asistencias_qr.sql
```

Start application:

```bash
docker compose up --build
```

Installed packages include:

- firebase/php-jwt
- phpmailer/phpmailer
- phpoffice/phpspreadsheet
- phpunit/phpunit

---

# Author

Juan Carlos Reynoso Zúñiga

---

<img width="959" height="474" alt="image" src="https://github.com/user-attachments/assets/1598a883-386a-45a0-8e71-82b177c830cb" />


<img width="959" height="470" alt="TableroKanban" src="https://github.com/user-attachments/assets/2c85fbba-a73f-4439-ad3b-dcd9602f52ad" />


<img width="959" height="474" alt="TableroKanban2" src="https://github.com/user-attachments/assets/9d1fca69-41a6-43ae-a824-c89b3e93521f" />

<img width="959" height="470" alt="image" src="https://github.com/user-attachments/assets/e92c171d-ae0c-4642-ac17-8df6e75f170e" />



<img width="959" height="476" alt="Prometheus" src="https://github.com/user-attachments/assets/9202eac8-f6f4-4c17-aa16-12b97b910fd4" />



<img width="959" height="470" alt="image" src="https://github.com/user-attachments/assets/4c8c29f7-9d6e-4b5b-8c74-3def424a24a8" />


<img width="959" height="472" alt="image" src="https://github.com/user-attachments/assets/5b83e580-40dc-4427-8749-85edcd718dea" />

<img width="957" height="471" alt="image" src="https://github.com/user-attachments/assets/35455091-4ba9-4d87-8bd9-f6628165477a" />

<img width="959" height="473" alt="image" src="https://github.com/user-attachments/assets/98fd4608-f424-4f21-b33d-cb8bab1f72c7" />


<img width="959" height="472" alt="image" src="https://github.com/user-attachments/assets/ddd5472e-7c9d-46ce-bd45-ec41fdd38253" />

<img width="959" height="470" alt="image" src="https://github.com/user-attachments/assets/fdd67c28-e5b4-48d6-914d-45ec3cba7c05" />


<img width="959" height="474" alt="image" src="https://github.com/user-attachments/assets/431a895a-0cd2-4158-aaa3-03c73134d522" />



<img width="959" height="473" alt="Grafana" src="https://github.com/user-attachments/assets/26fecb1c-59fc-4ac2-8617-bfd69dfd88bf" />

<img width="959" height="471" alt="Login" src="https://github.com/user-attachments/assets/30cb4c03-657a-4c71-b329-7e68946d241d" />

<img width="959" height="465" alt="DashBoardPuntuales" src="https://github.com/user-attachments/assets/3d9b74bf-fd68-429f-b8a1-bfd35cb22e9f" />

<img width="959" height="476" alt="image" src="https://github.com/user-attachments/assets/f128b51a-2792-44e4-8456-d4330c89c7da" />


<img width="860" height="458" alt="image" src="https://github.com/user-attachments/assets/3b65dd5c-41f6-44cd-8612-a4726e8690c0" />



<img width="860" height="455" alt="image" src="https://github.com/user-attachments/assets/3e1882dc-78a7-49e7-95f1-b2821dc6ea74" />



<img width="1915" height="948" alt="image" src="https://github.com/user-attachments/assets/5e481423-1ec9-4fd9-8e85-c3faf0ee4095" />
<img width="1919" height="943" alt="image" src="https://github.com/user-attachments/assets/91c728fb-3d3d-435d-b1a7-4f16ea6b5682" />
<img width="1919" height="938" alt="image" src="https://github.com/user-attachments/assets/365ee409-0af3-4554-8751-15944e7e2720" />
<img width="1919" height="948" alt="image" src="https://github.com/user-attachments/assets/4a7a1ce3-7d96-43af-ac46-0c8d90052891" />
<img width="1919" height="947" alt="image" src="https://github.com/user-attachments/assets/3496328f-518e-4286-b74d-e96a083cac93" />
<img width="1919" height="939" alt="image" src="https://github.com/user-attachments/assets/7735c6e7-fe66-4c28-b05e-045399760976" />
<img width="1915" height="954" alt="image" src="https://github.com/user-attachments/assets/257ca694-6bb0-4b59-b1cf-99653f1ab47e" />
<img width="1919" height="939" alt="image" src="https://github.com/user-attachments/assets/6f68616c-a430-4c12-a5b5-f541f08216f2" />
<img width="1912" height="943" alt="image" src="https://github.com/user-attachments/assets/961f5904-a6d6-4f89-bc95-376b7c9bf831" />
<img width="1919" height="947" alt="image" src="https://github.com/user-attachments/assets/5dcc4734-f41c-42e2-b49b-001da2b810e6" />
<img width="809" height="238" alt="image" src="https://github.com/user-attachments/assets/29cdb0ce-95d5-4a7a-ab43-761242a53851" />


<img width="1848" height="266" alt="image" src="https://github.com/user-attachments/assets/1eca2f06-81a5-49d0-bc8e-8529b22146aa" />

<img width="1917" height="936" alt="image" src="https://github.com/user-attachments/assets/67e267ba-a27c-4593-a31a-ffb33144debb" />
<img width="1908" height="945" alt="image" src="https://github.com/user-attachments/assets/5cfa7e82-5984-46b8-bddf-c91af2913e8d" />

<img width="1913" height="952" alt="image" src="https://github.com/user-attachments/assets/3e341e94-af68-4074-8924-b26f14c282f8" />


