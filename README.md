# QR Attendance System: QR-Based Attendance Control System

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JWT](https://img.shields.io/badge/JWT-black?style=for-the-badge&logo=jsonwebtokens)

##  Project Description

The system manages employee attendance control through QR code scanning.

The system automatically records employee entry and exit times and generates metrics for the Human Resources department.

It includes features such as:

- QR code scanning for attendance registration
- Admin panel for Human Resources
- Automatic lateness detection
- Real-time notifications
- Analytical dashboard with attendance metrics
- Automatic absence alert system
- Multi-company architecture

---

##  Objective

Build a functional backend system that allows:

- Automated attendance registration
- Centralized employee management
- Metrics and reports generation
- Security through authentication
- Scalability for multiple companies

---

##  Tech Stack


| Area | Technology |
|----------------------|--------------------------|
| Backend | PHP |
| Database | MySQL |
| Frontend | HTML5 / CSS / JavaScript |
| UI Framework | Bootstrap |
| Charts | Chart.js |
| QR Scanning | HTML5 QR Scanner |
| Email Sending | PHPMailer |
| Authentication | JWT |
| Version Control | Git / GitHub |

---

##  Core Functionalities

###  Employee Management

- Employee registration
- Unique QR code generation per employee
- Employee information management
- Entry schedule assignment

---

###  Attendance Registration via QR

- QR code scanning via camera
- Automatic clock-in time recording
- Clock-out time recording
- Duplicate prevention for the same day

---

###  Automatic Lateness Detection

The system compares the arrival time with the employee's assigned schedule.

Example:

```text
Entry Schedule: 08:00
Registration Time: 08:10
Result: Late (Retardo)
```

This allows for the generation of punctuality statistics.

---

###  Real-Time Notifications

When an employee registers their attendance:

- A notification is generated
- It automatically appears on the dashboard
- Allows live monitoring of system activity

---

###  HR Analytical Dashboard

The administrative panel includes metrics such as:

- Total employees
- Attendance records for the day
- Number of late arrivals
- Absences for the day
- Attendance history

It also includes charts generated with **Chart.js** to visualize:

- Attendance per day
- Punctuality trends
- Recent activity

---

###  Automatic Absence Alert System

The system includes a module that automatically detects employees who did not register their attendance for the day.

At the end of the workday:

1. The system queries the database
2. Identifies employees without an attendance record
3. Generates an automatic report
4. Sends an email to the Human Resources department

This process uses PHPMailer to send the report via SMTP.

Example of generated email:

> **Absence Report - 2026-03-29**
>
> The following employees did not register attendance today:
>
> - Juan Pérez
> - María López
> - Carlos Sánchez

This allows Human Resources to detect absences without manually checking the system.

---

##  Main System Modules

###  Authentication

- Administrator login
- Route protection
- Session handling or JWT

---

###  Employee Management

- Create employees
- Generate unique QR code
- Edit employee information
- Consult attendance records

---

###  Attendance Logs

- QR Scanning
- Automatic database recording
- Duplicate validation
- Lateness logging

---

###  Dashboard

- Administrative panel
- Real-time statistics
- Attendance table
- Analytical charts

---

##  Database

Main system tables:

### employees (empleados)


| Field | Type |
|------------------|---------|
| id | INT |
| first_name | VARCHAR |
| last_name | VARCHAR |
| qr_code | VARCHAR |
| entry_time | TIME |

---

### attendance (asistencias)


| Field | Type |
|--------------|---------|
| id | INT |
| employee_id | INT |
| date | DATE |
| clock_in | TIME |
| clock_out | TIME |
| is_late | BOOLEAN |

---

### notifications (notificaciones)


| Field | Type |
|---------|----------|
| id | INT |
| message | TEXT |
| date | DATETIME |
| is_read | BOOLEAN |

---

### companies (empresas)


| Field | Type |
|---------------|-----------|
| id | INT |
| name | VARCHAR |
| email | VARCHAR |
| registration_date | TIMESTAMP |

---

##  Workflow

1. The administrator registers employees in the system
2. A unique QR code is generated for each employee
3. The employee scans their QR code upon arrival
4. The system automatically records the attendance
5. Lateness is verified
6. A notification is generated
7. The dashboard updates metrics and charts

---

##  Installation and Execution

### 1. Clone the repository

```bash
git clone https://github.com
```

---

### 2. Import database

Import the file:

```bash
attendance_queries.sql
```

into MySQL.

---

### 3. Configure database connection

Edit the file:

```bash
config/database.php
```

with your MySQL server credentials.

---

### 4. Run local server

You can use:

- XAMPP
- Laragon
- Apache

Access the system from:

```bash
http://localhost/qr-attendance-system
```

---

##  Testing

The system can be tested through:

- Web browser
- QR scanning with camera
- HTTP testing tools like Postman

---

##  Demonstrated Skills

This project demonstrates skills in:

- Backend development with PHP
- Relational database design
- Client-server architecture
- Implementation of analytical dashboards
- QR scanning integration
- Real-time event handling
- Security and authentication


---

##  Autor

```bash
Juan Carlos Reynoso Zúñiga
```


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

<img width="1912" height="945" alt="image" src="https://github.com/user-attachments/assets/da840105-fefe-492e-b91e-433f5db170a5" />

<img width="1913" height="952" alt="image" src="https://github.com/user-attachments/assets/3e341e94-af68-4074-8924-b26f14c282f8" />


