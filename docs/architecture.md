# QR Attendance System Professional Architecture

## Architectural Style

The project follows a layered architecture combined with DevOps, Cloud-Native, Monitoring, Observability, and Alerting practices.

The deployment architecture also incorporates a hybrid cloud strategy using **Render** for application hosting, **Aiven** for the managed MySQL database, **GitHub Container Registry (GHCR)** for container image distribution, and **Minikube inside GitHub Codespaces** for Kubernetes orchestration simulation.

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

                         │
                         ▼

                  Docker Image
                         │
                         ▼
              GitHub Container Registry
                       (GHCR)
                         │
                         ▼
                      Render
                         │
                         ▼
                 Live Application
                         │
                         ▼
                  Aiven MySQL

=================================================

                     Deployment

                      Docker
                         │
                         ▼
                  Docker Compose
                         │
                         ├───────────────────┐
                         │                   │
                         ▼                   ▼
                    Local Runtime      Cloud Runtime
                                             │
                                             ▼
                                           Render
                                             │
                                             ▼
                                         Aiven MySQL

=================================================

              Kubernetes Orchestration

                  GitHub Codespaces
                         │
                         ▼
                      Minikube
                         │
                         ▼
                  Kubernetes Cluster
                         │
              ┌──────────┴──────────┐
              │                     │
              ▼                     ▼
          Deployment             Service
              │                     │
              ▼                     ▼
       QR Attendance Pods     Application Access
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

### Cloud Database

The live cloud deployment uses a managed MySQL database hosted on **Aiven**.

The application connects to the cloud database through environment-based configuration:

```text
DB_HOST
DB_PORT
DB_USER
DB_PASSWORD
```

This keeps cloud database credentials and connection information outside the application source code.

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
* Docker image build
* Docker image publication to GHCR

### Triggers

* Push
* Pull Requests

### CI/CD Flow

```text
GitHub Repository
        │
        ▼
GitHub Actions
        │
        ├── Composer Validation
        │
        ├── Dependency Installation
        │
        ├── PHPUnit Tests
        │
        └── Build Validation
                │
                ▼
          Docker Image Build
                │
                ▼
        GitHub Container Registry
                │
                ▼
              GHCR
                │
                ▼
             Render
```

After successful validation and image publication, **Render** performs the cloud application deployment.

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

### Container Registry

Production-ready application images are published to:

* GitHub Container Registry (GHCR)

The deployment pipeline publishes the production image using:

```text
:latest
```

### Cloud Deployment

The containerized application is deployed to **Render**, while the production MySQL database is hosted independently on **Aiven**.

```text
Docker Image
     │
     ▼
    GHCR
     │
     ▼
   Render
     │
     ▼
Application
     │
     ▼
Aiven MySQL
```

---

## Kubernetes

### Resources

* Deployment
* Service
* MySQL Deployment
* MySQL Service

### Kubernetes Environment

Kubernetes orchestration is validated through:

* Minikube
* GitHub Codespaces
* Docker driver

### Capabilities

* Application orchestration
* Service exposure
* Container deployment
* Deployment validation
* Rolling update validation
* Local Kubernetes simulation

### Image Configuration

Kubernetes application manifests use:

```yaml
imagePullPolicy: Always
```

This configuration ensures that Kubernetes retrieves the configured container image from the remote container registry when the deployment is updated.

### Deployment

```bash
kubectl apply -f k8s/
```

### Verification

```bash
kubectl get pods
kubectl get services
```

### Port Forwarding

The application can be accessed through Kubernetes port forwarding:

```bash
kubectl port-forward service/qr-attendance-service 8080:80
```

The Minikube environment represents a **Kubernetes orchestration simulation**, while the Render + Aiven environment provides the live cloud deployment.

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

### Cloud Monitoring Validation

The metrics endpoint can be validated against the deployed application environment.

Kubernetes deployments can also expose the application and metrics endpoint through service port forwarding:

```bash
kubectl port-forward service/qr-attendance-service 8080:80
```

This allows monitoring components and application metrics to be tested within the Kubernetes simulation environment.

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

## Cloud Configuration Security

Cloud deployment configuration is managed through environment variables rather than hardcoded credentials.

Sensitive database configuration is provided through Render environment configuration:

```text
DB_HOST
DB_PORT
DB_USER
DB_PASSWORD
```

This prevents database credentials from being committed directly to source control.

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
* GitHub Container Registry
* Cloud Deployment
* Render Application Hosting
* Aiven Managed MySQL
* Kubernetes Deployments
* Minikube Kubernetes Simulation
* GitHub Codespaces
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

---

# Cloud & Kubernetes Deployment Summary

The completed deployment architecture combines live cloud infrastructure with a Kubernetes simulation environment.

```text
                         GitHub
                            │
                            ▼
                    GitHub Actions
                            │
                     ┌──────┴──────┐
                     │             │
                     ▼             ▼
                 PHPUnit       Docker Build
                                   │
                                   ▼
                                  GHCR
                                   │
                     ┌─────────────┴─────────────┐
                     │                           │
                     ▼                           ▼
                  Render                    Minikube
               Cloud Runtime              Codespaces
                     │                           │
                     ▼                           ▼
                Aiven MySQL                Kubernetes
                                              Cluster
```

### Deployment Model

| Environment             | Technology        | Purpose                             |
| ----------------------- | ----------------- | ----------------------------------- |
| CI                      | GitHub Actions    | Automated validation and build      |
| Registry                | GHCR              | Docker image distribution           |
| Cloud Application       | Render            | Live application hosting            |
| Cloud Database          | Aiven             | Managed MySQL database              |
| Kubernetes Simulation   | Minikube          | Kubernetes orchestration validation |
| Development Environment | GitHub Codespaces | Cloud-based Kubernetes sandbox      |
| Local Container Runtime | Docker Compose    | Local application deployment        |
