# Volunteer Platform API Documentation

## ✅ Platform Overview
This platform connects **Volunteers** with **Organizers** through **Opportunities**. The **Admin** oversees and approves opportunities and reviews applications.

Users have 3 roles:
- **Admin**
- **Organizer**
- **Volunteer**

---

## 🔐 Authentication API

| Endpoint         | Method | Description |
|------------------|--------|-------------|
| `/api/register`  | POST   | Register a new user (provide `name`, `email`, `password`, `role`) |
| `/api/login`     | POST   | Login with email and password |
| `/api/logout`    | POST   | Logout the user |
| `/api/me`        | GET    | Get current authenticated user info |

---

## 👥 Roles Breakdown

### 🎯 ORGANIZER

Organizers can:
- Manage their own **opportunities**
- View and respond to **applications** on those opportunities

#### 📌 Opportunities (Organizer)

| Endpoint | Method | Description |
|---------|--------|-------------|
| `/api/organizer/opportunities` | GET | List all opportunities by this organizer |
| `/api/organizer/opportunities` | POST | Create a new opportunity |
| `/api/organizer/opportunities/{id}` | GET | Show details of a specific opportunity |
| `/api/organizer/opportunities/{id}` | PUT | Update opportunity (title, description, location, dates, etc.) |

#### 📥 Applications (Organizer)

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/organizer/applications/opportunity/{opportunity_id}` | GET | View all applications for your opportunity |
| `/api/organizer/applications/{application_id}/status` | PUT | Update application status (pending, accepted, rejected) |

---

### 🙋‍♂️ VOLUNTEER

Volunteers can:
- Explore opportunities
- Apply to them
- View their application history

#### 📌 Opportunities (Volunteer)

| Endpoint | Method | Description |
|---------|--------|-------------|
| `/api/volunteer/opportunities` | GET | List all approved opportunities (supports filters) |
| `/api/volunteer/opportunities/{id}` | GET | View specific opportunity details |

**Filters supported** on `GET /api/volunteer/opportunities`:
- `category_id`
- `location`
- `start_date`
- `end_date`
- `title`

Example:
```
GET /api/volunteer/opportunities?title=cleanup&location=Damascus&category_id=3
```

#### 📥 Applications (Volunteer)

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/volunteer/applications` | POST | Apply to an opportunity (only once per opportunity) |
| `/api/volunteer/applications/mine` | GET | View all your submitted applications |

---

### 🛡️ ADMIN

Admin can:
- Approve or reject opportunities
- View all applications

#### 📌 Opportunities (Admin)

| Endpoint | Method | Description |
|---------|--------|-------------|
| `/api/admin/opportunities` | GET | List all opportunities with organizer and category |
| `/api/admin/opportunities/{id}/status` | PUT | Change status to `approved` or `rejected` |

#### 📥 Applications (Admin)

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/admin/applications` | GET | List all submitted applications |
| `/api/admin/applications/{id}` | GET | Show details of a specific application |

---

## 🔄 Request/Response Notes

All responses are wrapped consistently using `ResponseTrait`:
```json
{
  "status": true,
  "message": "Success message here",
  "data": { ... }
}
```

You used `ApplicationResource`, `OpportunityResource`, etc. to return readable data like:
```json
"opportunity": {
  "title": "Beach Cleanup",
  "category": "Environment",
  "organizer": "CleanEarth Org",
  "location": "Damascus"
}
```

---

## 📦 Postman Setup Notes

- Set global variables in Postman:
  - `{{base_url}}` for your API base
  - `{{token}}` will be auto-saved after login