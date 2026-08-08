# HRMS & Multi-Tenant SaaS Platform — Comprehensive Documentation

Welcome to the official technical documentation for the **HRMS & Enterprise Multi-Tenant SaaS Platform**. This document provides an exhaustive overview of system architecture, modular design, database schemas, API routes, setup instructions, and demo credentials.

---

## 📑 Table of Contents
1. [System Architecture](#-system-architecture)
2. [Core Modules Overview](#-core-modules-overview)
3. [Multi-Tenancy & Data Isolation](#-multi-tenancy--data-isolation)
4. [Database Schema & Entity Relationship](#-database-schema--entity-relationship)
5. [Roles & Permissions Matrix](#-roles--permissions-matrix)
6. [API Specification](#-api-specification)
7. [Demo Accounts & Credentials](#-demo-accounts--credentials)
8. [Installation & Setup Guide](#-installation--setup-guide)

---

## 🏛️ System Architecture

The platform is engineered as a **modular, multi-tenant SaaS architecture** built on **Laravel 12**, **Nwidart Modules**, **Spatie Permissions**, and **TailwindCSS / Bootstrap 5**.

```mermaid
graph TD
    User([User / Admin]) --> WebRoute[Web Browser / API Client]
    WebRoute --> DomainCheck{Subdomain / Tenant Resolver}
    DomainCheck -->|Platform Admin| SystemTenant[System HQ Tenant #1]
    DomainCheck -->|Client Subdomain| ClientTenant[Client Tenant Isolation]
    
    SystemTenant --> CoreModules[Core SaaS & HR Modules]
    ClientTenant --> CoreModules
    
    subgraph Core Modules
        Auth[Auth & User Mgmt]
        Tenant[Tenant Manager]
        Location[Location & Offices]
        Subscription[Subscriptions & Plans]
        Entitlement[Entitlements & Features]
        Billing[Billing & Invoices]
        Addons[Addons & HR Extensions]
        Coupons[Coupons & Discounts]
        RolePerm[Role & Permission (RBAC)]
        Notification[Notifications & Audit Logs]
        ApiKey[API Key Management]
        Support[Support Ticketing]
        ModuleBuilder[Dynamic Module Builder]
    end
```

---

## 📦 Core Modules Overview

| Module Name | Alias | Description & HRMS Utility |
| :--- | :--- | :--- |
| **`Auth`** | `auth` | User authentication, email verification, session security, login activity logs. |
| **`Tenant`** | `tenant` | Tenant onboarding, custom domains, company isolation, and subscription linking. |
| **`Location`** | `location` | Corporate HQs, regional branch offices, warehouse hubs, and work locations. |
| **`Subscription`** | `subscription` | SaaS plans (`Free Starter`, `Growth Pro`, `Enterprise Scale`) with limits & pricing. |
| **`Entitlement`** | `entitlement` | Feature flag gating and module entitlement allocation per plan. |
| **`Billing`** | `billing` | Payment collection, invoice generation, billing history tracking. |
| **`Addons`** | `addons` | HR modular add-ons (Payroll, Time Tracking, Performance Reviews). |
| **`Coupons`** | `coupons` | Promotional discount codes and subscription vouchers. |
| **`RolePermission`** | `rolepermission` | Spatie RBAC integration for Super Admin, Tenant Admin, and HR Employees. |
| **`Notification`** | `notification` | Multi-channel notifications, activity logs, and email template manager. |
| **`ApiKey`** | `apikey` | Sanctum API keys for external HR integrations & mobile apps. |
| **`Support`** | `support` | Internal HR helpdesk, employee ticketing, support categories. |
| **`ModuleBuilder`** | `modulebuilder` | Dynamic CRUD generator for rapid HR entity prototyping. |

---

## 🔒 Multi-Tenancy & Data Isolation

All tenant data is strictly scoped by `tenant_id`:
- **Super Admin Scope**: Full cross-tenant visibility for system administration.
- **Tenant Scope**: Tenant Admins and Users only see data linked to their specific `tenant_id`.

```php
// Example Tenant Scope in Eloquent Models
public function scopeForTenant($query, $tenantId)
{
    return $query->where('tenant_id', $tenantId);
}
```

---

## 🗄️ Database Schema & Entity Relationship

### Core Database Tables
1. `tenants`: Primary tenant registry (`id`, `name`, `subdomain`, `plan_id`, `status`).
2. `domains`: Custom and default tenant domain mappings (`domain`, `tenant_id`, `is_primary`).
3. `users`: User profiles with `tenant_id`, `is_admin`, `status`, `phone`.
4. `locations`: Branch offices and workplace locations (`name`, `country`, `city`, `address_line_1`, `is_primary`).
5. `subscription_plans`: Pricing tiers (`max_users`, `price_monthly`, `price_yearly`).
6. `billings`: Financial transactions and PDF invoices.
7. `roles` & `permissions`: Spatie permission mapping tables.
8. `activity_logs`: Comprehensive audit trail for system actions.

---

## 🔐 Roles & Permissions Matrix

| Role | Target Audience | Key Capabilities |
| :--- | :--- | :--- |
| **Super Admin** | Platform Owners | Access `/admin/dashboard`, manage all tenants, global plans, billing, and system settings. |
| **Tenant Admin** | Company HR Managers | Access `/dashboard`, manage tenant locations, employees, billing, and tenant settings. |
| **User / Employee** | Staff Members | Access `/dashboard`, view personal profile, support tickets, and assigned locations. |

---

## 🔌 API Specification

All REST APIs are served under `/api/v1/` and protected via **Laravel Sanctum**.

| Module | Method | Endpoint | Description |
| :--- | :--- | :--- | :--- |
| **Location** | `GET` | `/api/v1/locations` | List office locations (paginated & filtered) |
| **Location** | `POST` | `/api/v1/locations` | Create a new office location hub |
| **Location** | `GET` | `/api/v1/locations/{id}` | Get specific location details |
| **Location** | `PUT` | `/api/v1/locations/{id}` | Update office location details |
| **Location** | `DELETE` | `/api/v1/locations/{id}` | Soft delete office location |
| **Payment** | `GET` | `/api/v1/payments/gateways` | List active payment gateways (Stripe, PayPal, Bank) |
| **Payment** | `GET` | `/api/v1/payments/transactions` | List payment transactions audit trail |
| **Payment** | `POST` | `/api/v1/payments/transactions` | Create/Record new payment transaction |
| **Tenant** | `GET` | `/api/v1/tenants` | List onboarded client tenants (Super Admin) |
| **Tenant** | `POST` | `/api/v1/tenants` | Onboard new client tenant organization |
| **Subscription** | `GET` | `/api/v1/subscriptions` | List available subscription pricing plans |
| **Entitlement** | `GET` | `/api/v1/entitlements` | List feature flags & limits for tenant plan |
| **Billing** | `GET` | `/api/v1/billings` | List invoices and billing history |
| **Billing** | `GET` | `/api/v1/billings/{id}/pdf` | Download invoice PDF receipt |
| **Addons** | `GET` | `/api/v1/addons` | List modular HR add-ons (Payroll, Attendance) |
| **Coupons** | `GET` | `/api/v1/coupons` | List active discount coupons |
| **Notification** | `GET` | `/api/v1/notifications` | List user notifications and alerts |
| **ApiKey** | `GET` | `/api/v1/apikeys` | List active Sanctum API tokens |
| **Support** | `GET` | `/api/v1/tickets` | List employee HR support tickets |

---

## 🔑 Demo Accounts & Credentials

| Role | Email | Password | Scope |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@saas.local` | `AdminPass123!` | System HQ (`main.saas.local`) |
| **Alpha Tenant Admin** | `tenant1@saas.local` | `TenantPass123!` | Alpha Corp (`alpha.saas.local`) |
| **Beta Tenant Admin** | `tenant2@saas.local` | `TenantPass123!` | Beta Solutions (`beta.saas.local`) |
| **Demo User** | `user@saas.local` | `UserPass123!` | Alpha Corp Staff |

---

## 🚀 Installation & Setup Guide

### 1. Prerequisites
- **PHP**: `^8.2`
- **Composer**: `^2.5`
- **Node.js**: `^18.0` / NPM
- **Database**: MySQL 8.0 / MariaDB 10.4

### 2. Quickstart Commands
```bash
# Clone the repository
git clone https://github.com/your-org/SaaSStater.git
cd SaaSStater

# Install PHP & Node dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Enable modules & optimize
php artisan module:enable Location
php artisan optimize:clear

# Migrate & seed database
php artisan migrate:fresh --seed

# Start development server
php artisan serve
```
