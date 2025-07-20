# Database Seeding Guide

This document explains the comprehensive seeders and factories that have been created for your Laravel project management application.

## Overview

Your database has been populated with realistic test data including:
- **23 Users** (test user, admin user, manager user + 20 random users)
- **10 Projects** with various creators
- **109 Tasks** distributed across projects
- **38 Categories** organized by project
- **50 Columns** (Kanban board columns)
- **32 Groups** (teams) with user assignments

## Factories Created

### 1. UserFactory (already existed)
- Creates users with realistic first names, last names, usernames, and emails
- Default password: "password"
- Email verified by default

### 2. ProjectFactory
- Generates project names using fake sentences
- Creates detailed descriptions
- Assigns random users as project creators

### 3. CategoryFactory
- Creates categories with predefined realistic names:
  - Bug Fix, Feature, Documentation, Testing, Refactoring
  - UI/UX, Backend, Frontend, Database, Security

### 4. ColumnFactory
- Creates Kanban board columns with names:
  - To Do, In Progress, Review, Testing, Done
  - Backlog, Ready, Development, QA, Completed
- Randomly sets 20% of columns as "final" columns

### 5. GroupFactory
- Creates team groups with realistic names:
  - Frontend Team, Backend Team, Design Team, QA Team
  - DevOps Team, Mobile Team, Marketing Team, Sales Team

### 6. TaskFactory
- Generates tasks with:
  - Realistic titles and descriptions
  - Priority levels: low, medium, high
  - Status: todo, in_progress, done
  - Random start and end dates
  - Optional completion dates (30% chance)

### 7. ProjectUserFactory
- Manages project-user relationships with roles:
  - owner, admin, member

## Seeders Created

### 1. UserSeeder (NEW!)
- Creates the main test user (test@example.com)
- Creates 20 additional random users for testing
- Creates specific role-based users:
  - Admin user (admin@example.com)
  - Manager user (manager@example.com)
- Centralizes all user creation logic

### 2. ProjectSeeder
- Uses existing users to create 10 projects
- Assigns different users as project creators
- No longer creates users (moved to UserSeeder)

### 3. CategorySeeder
- Creates 3-5 categories per project
- Assigns random users as category creators
- Ensures each project has diverse category types

### 3. ColumnSeeder
- Creates standard Kanban columns for each project:
  - To Do, In Progress, Review, Testing, Done
- Only "Done" column is marked as final
- Maintains consistency across projects

### 4. GroupSeeder
- Creates 2-4 groups per project
- Assigns 2-6 random users to each group
- Creates realistic team structures

### 5. TaskSeeder
- Creates 8-15 tasks per project (109 total)
- Properly assigns tasks to:
  - Project columns
  - Categories
  - User creators
  - 1-3 assigned users
  - 0-2 groups (optional)

### 6. ProjectUserSeeder
- Attaches project creators as owners
- Adds 3-8 additional users per project
- Assigns roles with more members than admins
- Creates realistic project team structures

## Running the Seeders

To populate your database with test data:

```bash
# Using Laravel Sail (Docker)
./vendor/bin/sail artisan migrate:fresh --seed

# Or without Sail (if running locally)
php artisan migrate:fresh --seed
```

To run specific seeders:

```bash
./vendor/bin/sail artisan db:seed --class=ProjectSeeder
./vendor/bin/sail artisan db:seed --class=TaskSeeder
# etc.
```

## Database Relationships

The seeders properly maintain all relationships:

- **Users ↔ Projects**: Many-to-many with roles (owner, admin, member)
- **Projects → Tasks**: One-to-many
- **Projects → Categories**: One-to-many
- **Projects → Columns**: One-to-many
- **Projects → Groups**: One-to-many
- **Tasks ↔ Users**: Many-to-many (assignments)
- **Tasks ↔ Groups**: Many-to-many
- **Groups ↔ Users**: Many-to-many

## Test Users

The following test users are created:

### Main Test User
- Email: test@example.com
- Password: password
- Username: testuser
- Name: Test User

### Admin User
- Email: admin@example.com
- Password: password
- Username: admin
- Name: Admin User

### Manager User
- Email: manager@example.com
- Password: password
- Username: manager
- Name: Manager User

Plus 20 additional random users with realistic names and data.

## Data Quality

The seeders ensure:
- Realistic data that makes sense in context
- Proper foreign key relationships
- Diverse but logical distributions
- Compliance with database constraints
- Good test coverage for all models

## Customization

You can modify the seeders to:
- Change the number of records created
- Adjust the data distributions
- Add new data types or categories
- Modify user roles and permissions
- Customize project structures

The factories are flexible and can be easily extended or modified to fit your specific testing needs.
