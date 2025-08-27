# WorkLedger

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen)](#)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red?logo=laravel)
![React](https://img.shields.io/badge/React-18-blue?logo=react)
![Docker](https://img.shields.io/badge/Docker-ready-2496ED?logo=docker)
![MySQL](https://img.shields.io/badge/MySQL-8-blue?logo=mysql)
![Monorepo](https://img.shields.io/badge/Monorepo-supported-lightgrey)

---

## Table of Contents

* [Project Overview](#project-overview)
* [Tech Stack](#tech-stack)
* [Repository Structure](#repository-structure)
* [Installation](#installation)
* [Docker Setup](#docker-setup)
* [Environment Variables](#environment-variables)
* [Running the Project](#running-the-project)
* [Packages](#packages)
* [Frontend](#frontend)
* [Development Scripts](#development-scripts)
* [CI/CD](#cicd)
* [License](#license)
* [Tags](#tags)

---

## Project Overview

**WorkLedger** is a modular, scalable **timesheet and project management system** built with **Laravel (API)** and **React (SPA frontend)**.
It is structured as a **monorepo**, making it easier to extend, maintain, and potentially migrate to **microservices** in the future.

**Core Features:**

* Manage projects and assign users with roles
* Track individual and general activities
* Submit, approve, and reject timesheets
* Configure flexible approval flows
* Generate reports and dashboards (planned)
* Role-based access control (RBAC)

---

## Tech Stack

* **Backend:** Laravel 12, PHP 8.2
* **Frontend:** React 18 + TypeScript + Vite
* **Database:** MySQL 8
* **Containerization:** Docker & Docker Compose
* **Dev Tools:** Composer, npm, Laravel Sail, PHPUnit
* **Monorepo Packages:** Domain, Shared, Contracts

---

## Repository Structure

```
workledger/
├── apps/
│   ├── api/       # Laravel API
│   └── web/       # React SPA frontend
├── packages/
│   ├── domain/    # Business logic (DDD-lite)
│   ├── shared/    # Helpers, middlewares, exceptions
│   └── contracts/ # Interfaces, DTOs, OpenAPI contracts
├── infra/
│   ├── docker/    # Dockerfiles and configs
│   ├── deploy/    # CI/CD pipelines
│   └── db/        # Shared migrations/seeds
├── docs/
├── Makefile
├── docker-compose.yml
├── .gitignore
└── README.md
```

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/workledger.git
cd workledger
```

### 2. Install backend dependencies

```bash
cd apps/api
composer install
```

### 3. Install frontend dependencies

```bash
cd ../web
npm install
```

---

## Docker Setup

Make sure Docker Desktop is running.

### Build and start containers

```bash
docker compose up -d --build
```

* Laravel API → [http://localhost:8000](http://localhost:8000)
* MySQL → port 3307 (can be adjusted if needed)

---

## Environment Variables

### API `.env`

```
APP_NAME=WorkLedger
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3307
DB_DATABASE=workledger
DB_USERNAME=workledger
DB_PASSWORD=secret
```

### Frontend `.env`

```
VITE_API_URL=http://localhost:8000/api
```

---

## Running the Project

### Backend (Laravel API)

```bash
cd apps/api
php artisan serve --host=0.0.0.0 --port=8000
php artisan migrate
php artisan db:seed
```

### Frontend (React SPA)

```bash
cd apps/web
npm run dev
```

---

## Packages

The monorepo includes shared packages for modularity and future microservice extraction:

* **contracts** → DTOs, API contracts, and interfaces
* **domain** → Business logic and entities
* **shared** → Utilities, middlewares, exceptions

Packages are linked to the API using Composer path repositories.

---

## Frontend

* Built with React 18 + TypeScript + Vite
* SPA communicates with Laravel API using Axios or Fetch
* Organized by feature modules aligned with backend domain logic
* Ready for SSR or microfrontend separation in the future

---

## Development Scripts

| Command            | Description                          |
| ------------------ | ------------------------------------ |
| `make up`          | Start Docker containers              |
| `make down`        | Stop Docker containers               |
| `make api-migrate` | Run Laravel migrations inside Docker |
| `make test`        | Run PHPUnit tests                    |
| `npm run dev`      | Start frontend dev server            |
| `npm run build`    | Build production frontend            |

---

## CI/CD

* Dockerized project for consistent environments
* Deployment scripts in `infra/deploy` (GitHub Actions or GitLab CI)
* Supports future microservices split

---

## License

This project is licensed under the MIT License.
See the LICENSE file for details.

---

## Tags

Laravel React Monorepo Timesheet Project Management API SPA DDD-lite Docker PHP MySQL
