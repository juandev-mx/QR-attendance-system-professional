# QR Attendance System Architecture

## Architecture Pattern

Layered Architecture

QR Scanner
    ↓
API
    ↓
Controller
    ↓
Service
    ↓
Repository
    ↓
Database

## Design Patterns

- Repository Pattern
- Service Layer Pattern
- Separation of Concerns
- Dependency Injection


## Domain Model

Company
 └── Employees
      └── Attendance

Entities

- Company
- Employee
- Attendance

Repositories return domain entities
instead of associative arrays
when possible.
