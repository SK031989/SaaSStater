# SaaSStater — HRMS & Multi-Tenant SaaS Platform

SaaSStater is a production-ready **Multi-Tenant HRMS & SaaS Boilerplate** built on **Laravel 12**, **Nwidart Modules**, **Spatie RBAC**, and modern responsive UI design systems.

---

## 🚀 Key Features

- **Multi-Tenant Architecture**: Complete tenant isolation, subdomain resolution, and company management.
- **Location & Office Hubs**: Manage global HQs, regional branches, and warehouse facilities.
- **Subscription & Billing**: Multi-tier plans (`Free Starter`, `Growth Pro`, `Enterprise Scale`), entitlement feature flags, and invoice management.
- **Spatie Roles & Permissions**: Fine-grained RBAC for Super Admins, Tenant Admins, HR Managers, and Employees.
- **Dynamic Module Builder**: Prototype and generate new HR modules on the fly.
- **REST API v1**: Sanctum-authenticated API endpoints for mobile apps and integrations.
- **Dual Light/Dark Mode**: High-contrast, polished UI with theme color palette customization.

---

## 📚 Complete Documentation

Full technical documentation, database schemas, API specs, and setup instructions are available in:
👉 [**HRMS & SaaS Technical Documentation**](docs/HRMS_DOCUMENTATION.md)

---

## 🔑 Demo Credentials

| Role | Email | Password | URL Scope |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@saas.local` | `AdminPass123!` | `/admin/dashboard` |
| **Tenant Admin** | `tenant1@saas.local` | `TenantPass123!` | `/dashboard` |
| **Demo User** | `user@saas.local` | `UserPass123!` | `/dashboard` |

---

## 🛠️ Quick Installation

```bash
# Install dependencies
composer install
npm install

# Migrate & Seed
php artisan module:enable Location
php artisan migrate:fresh --seed

# Run dev server
php artisan serve
```
