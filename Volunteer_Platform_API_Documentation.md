# Volunteer Platform API Documentation

This document explains how to interact with the Volunteer Platform API, which is built with Laravel. The API lets **organizers** publish volunteer opportunities and manage applications, while **volunteers** can browse and apply. An **admin** approves opportunities and monitors applications.

---

## Table of Contents
1. [Getting Started](#getting-started)
2. [Authentication](#authentication)
3. [Role Capabilities](#role-capabilities)
4. [Request & Response Format](#request--response-format)
5. [Postman Collection](#postman-collection)

---

## Getting Started

Follow the setup steps in the [README](README.md) to install dependencies, configure your `.env` file, and run migrations/seeders. Once the application is running you can authenticate and begin making API requests.

---

## Authentication

The API uses token-based authentication provided by [Laravel Sanctum](https://laravel.com/docs/sanctum). Obtain a token by registering or logging in:

| Endpoint | Method | Description |
| --- | --- | --- |
| `/api/register` | `POST` | Register a new user (`name`, `email`, `password`, `role`). |
| `/api/login` | `POST` | Return an access token for valid credentials. |
| `/api/logout` | `POST` | Revoke the current token. |
| `/api/me` | `GET` | Retrieve the authenticated user's details. |

Include the token in an `Authorization` header for subsequent requests:

```
Authorization: Bearer {token}
```

---

## Role Capabilities

### Organizer
Organizers manage their own opportunities and review volunteer applications.

#### Opportunities
| Endpoint | Method | Description |
| --- | --- | --- |
| `/api/organizer/opportunities` | `GET` | List all of the organizer's opportunities. |
| `/api/organizer/opportunities` | `POST` | Create a new opportunity. |
| `/api/organizer/opportunities/{id}` | `GET` | Show a single opportunity. |
| `/api/organizer/opportunities/{id}` | `PUT` | Update an opportunity. |

#### Applications
| Endpoint | Method | Description |
| --- | --- | --- |
| `/api/organizer/applications/opportunity/{opportunity_id}` | `GET` | List applications for a given opportunity. |
| `/api/organizer/applications/{application_id}/status` | `PUT` | Change an application's status (`pending`, `accepted`, `rejected`). |

### Volunteer
Volunteers search for opportunities and submit applications.

#### Opportunities
| Endpoint | Method | Description |
| --- | --- | --- |
| `/api/volunteer/opportunities` | `GET` | Browse all approved opportunities. Supports filters: `category_id`, `location`, `start_date`, `end_date`, `title`. |
| `/api/volunteer/opportunities/{id}` | `GET` | View details of an opportunity. |

Example with filters:

```
GET /api/volunteer/opportunities?title=cleanup&location=Damascus
```

#### Applications
| Endpoint | Method | Description |
| --- | --- | --- |
| `/api/volunteer/applications` | `POST` | Apply to an opportunity (only once per opportunity). |
| `/api/volunteer/applications/mine` | `GET` | View all applications submitted by the volunteer. |

### Admin
Admins approve opportunities and oversee all activity.

#### Opportunities
| Endpoint | Method | Description |
| --- | --- | --- |
| `/api/admin/opportunities` | `GET` | List every opportunity with organizer and category info. |
| `/api/admin/opportunities/{id}/status` | `PUT` | Change opportunity status to `approved` or `rejected`. |

#### Applications
| Endpoint | Method | Description |
| --- | --- | --- |
| `/api/admin/applications` | `GET` | List every application in the system. |
| `/api/admin/applications/{id}` | `GET` | Show a specific application. |

---

## Request & Response Format

Requests should be encoded as JSON and include the `Accept: application/json` header. Successful responses share a common structure:

```json
{
  "status": true,
  "message": "Success message",
  "data": {
    /* payload */
  }
}
```

Resources such as opportunities and applications are returned using Laravel API resources for consistent field names.

---

## Postman Collection

A ready-to-use Postman collection is available in the repository:

- **File:** `Full Volunteer Platform Collection.postman_collection.json`

Import this collection into Postman and set two global variables:

- `{{base_url}}` – the root URL of your running API (e.g. `http://localhost:8000`)
- `{{token}}` – automatically populated after you log in via the collection

The collection demonstrates example requests for every endpoint discussed above.

---

Happy volunteering!
