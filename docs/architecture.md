# QR Attendance System Professional Architecture

## Architectural Style

The project follows a layered architecture combined with DevOps, Cloud-Native, Monitoring, Observability, and Alerting practices.

---

# High-Level Architecture

```text
                        Users
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

=================================================

              Monitoring & Observability

                  Prometheus
                        ▲
                        │
                Scrapes Metrics
                        │
                        ▼

                 /api/metrics.php
                        │
                        ▼

               Application Metrics

                ├── employees_total
                ├── attendance_total
                ├── late_arrivals_total
                ├── companies_total
                ├── notifications_total
                └── qr_attendance_system_up

                        │
                        ▼

                Prometheus Rules

                        │
                        ▼

                  Alertmanager

                        │
                        ▼

                Email Notifications
                     (SMTP)

                        │
                        ▼

                     Grafana

                        │
                        ▼

              Business Dashboards

=================================================

                  CI/CD Pipeline

                    Developer
                         │
                    git push
                         │
                         ▼

                 GitHub Actions

                         │

         ┌───────────────┼───────────────┐
         │               │               │

         ▼               ▼               ▼

  Composer Install   PHPUnit Tests   Build Validation

=================================================

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

# Application Layers

## Presentation Layer

Responsible for handling user interactions and rendering views.

### Components

* Dashboard
* QR Scanner Interface
* Authentication Views
* Reports Module

---

## Controller Layer

Responsible for processing HTTP requests and orchestrating application flows.

### Components

* AttendanceController
* EmployeeController
* CompanyController
* MetricsController

### Responsibilities

* Request validation
* Response handling
* Route coordination

---

## Service Layer

Contains business rules and application workflows.

### Components

* AttendanceService
* EmployeeService
* CompanyService
* NotificationService

### Responsibilities

* Attendance registration
* Duplicate attendance prevention
* Lateness detection
* Notification generation
* Absence processing

---

## Repository Layer

Responsible for data persistence and retrieval.

### Components

* AttendanceRepository
* EmployeeRepository
* CompanyRepository
* NotificationRepository

### Pattern Used

* Repository Pattern

### Responsibilities

* Database abstraction
* Query management
* Data access encapsulation

---

## Persistence Layer

### Database Engine

* MySQL 8

### Main Entities

* Employees
* Attendance
* Companies
* Notifications
* Users
* Departments

---

# Design Patterns

## Implemented Patterns

* Repository Pattern
* Service Layer Pattern
* Dependency Injection
* Separation of Concerns

## Benefits

* Maintainability
* Testability
* Scalability
* Loose Coupling

---

# DevOps Architecture

## Continuous Integration

GitHub Actions executes automatically:

* Composer validation
* Dependency installation
* PHPUnit execution
* Build validation

### Triggers

* Push
* Pull Requests

---

## Containerization

### Containers

* PHP 8 + Apache
* MySQL
* Prometheus
* Grafana
* Alertmanager

### Managed Through

* Docker Compose

---

## Kubernetes

### Resources

* Deployment
* Service
* MySQL Deployment
* MySQL Service

### Capabilities

* Application orchestration
* Service exposure
* Scalable deployments

---

# Testing Architecture

## Framework

* PHPUnit

## Covered Layers

* Repositories
* Services
* Controllers
* Helpers

## Coverage Tool

* Xdebug

## Coverage Reports

```text
coverage/
```

---

# Monitoring & Observability

## Metrics Endpoint

```text
/api/metrics.php
```

## Business Metrics

Collected by Prometheus:

* employees_total
* attendance_total
* late_arrivals_total
* companies_total
* notifications_total
* qr_attendance_system_up

---

## Monitoring Stack

* Prometheus
* Grafana

### Responsibilities

* Metrics collection
* Time-series storage
* Dashboard visualization

---

# Alerting Architecture

The platform includes proactive monitoring through Prometheus Alert Rules and Alertmanager.

## Prometheus Rules

### QRAttendanceSystemDown

Triggered when:

```promql
qr_attendance_system_up == 0
```

#### Purpose

Detect application outages.

---

### HighLateArrivals

Triggered when:

```promql
late_arrivals_total > 10
```

#### Purpose

Detect abnormal punctuality trends.

---

### NoAttendanceRecords

Triggered when:

```promql
attendance_total == 0
```

for 5 minutes.

#### Purpose

Detect attendance registration failures.

---

## Alertmanager

### Responsibilities

* Alert aggregation
* Alert routing
* Alert delivery

### Integrated With

* Gmail SMTP

### Capabilities

* Email notifications
* Alert grouping
* Alert lifecycle management
* Automatic incident reporting

---

## Alert Flow

```text
Application
      │
      ▼

Prometheus Metrics
      │
      ▼

Prometheus Rules
      │
      ▼

Alertmanager
      │
      ▼

Email Notification
```

---

# Security Components

## Authentication

* JWT (firebase/php-jwt)

## Authorization

* Protected routes
* Session validation

## Security Goals

* Authentication
* Access control
* Secure API communication

---

# Reporting Components

## Email Reports

### Technology

* PHPMailer

### Features

* Absence reports
* Automated notifications

---

## Excel Reports

### Technology

* PhpSpreadsheet

### Features

* Attendance exports
* Business reports

---

## PDF Reports

### Features

* Attendance summaries
* Administrative reporting

---

# Composer Packages

| Package                  | Purpose                                 |
| ------------------------ | --------------------------------------- |
| firebase/php-jwt         | Authentication and JWT token management |
| phpmailer/phpmailer      | Email notifications and reports         |
| phpoffice/phpspreadsheet | Excel report generation                 |
| phpunit/phpunit          | Automated testing                       |

---

# Architectural Highlights

This project demonstrates practical implementation of:

* Layered Architecture
* Repository Pattern
* Dependency Injection
* Automated Testing
* CI/CD Pipelines
* Containerization
* Kubernetes Deployments
* Monitoring & Observability
* Prometheus Alert Rules
* Alertmanager Email Notifications
* SMTP Integration
* Agile Project Management
* Technical Documentation

---

# Observability Stack

The project implements a complete observability workflow:

```text
Monitoring
     │
     ▼

Prometheus

     │
     ▼

Visualization

Grafana

     │
     ▼

Alerting

Prometheus Rules

     │
     ▼

Alertmanager

     │
     ▼

SMTP Email Notifications
```

### Implemented Components

* Monitoring (Prometheus)
* Visualization (Grafana)
* Alerting (Prometheus Rules + Alertmanager)
* Notification Delivery (SMTP Email)

This architecture follows practices commonly used in DevOps, Cloud Engineering, Platform Engineering, and Site Reliability Engineering (SRE) environments.
"""
