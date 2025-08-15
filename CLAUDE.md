# Job Portal Project Policy & Rule Book

## Project Overview
Job Portal is a Laravel/Vue.js-based Multi-Role Job Portal Platform with separate Admin, Company, and Candidate dashboards. This project follows strict development guidelines with a comprehensive feature set for job and project management.

## 📚 REQUIREMENTS DOCUMENTATION
**IMPORTANT**: All detailed requirements, specifications, and features are documented in the `/Docs` folder:
- `/Docs/Requirements/functional_requirements.md` - Complete functional specifications with 180+ requirements
- `/Docs/Requirements/technical_requirements.md` - Technical architecture, stack, and standards
- `/Docs/Requirements/database_schema.md` - Full database design with 20+ tables and relationships
- `/Docs/Requirements/user_stories.md` - 170+ detailed user stories for all roles
- `/Docs/Requirements/additional_features.md` - Advanced features and future enhancements
- `/Requirments/documentation.md` - Original project scope document

**ALWAYS REFER TO THESE DOCUMENTS** for detailed implementation requirements before starting any task.

## 🚨 CRITICAL DEVELOPMENT RULES
1. **ALWAYS follow Laravel best practices** - NO EXCEPTIONS
2. **Use Vue.js 3 with Composition API** for all frontend components
3. **FOLLOW RESTful API conventions** for all endpoints
4. **Use Laravel Sanctum** for authentication
5. **IMPLEMENT proper validation** on both frontend and backend
6. **MAINTAIN role-based access control** (RBAC) for all features
7. **Use database migrations** for all schema changes
8. **Keep API responses consistent** - Use resource classes
9. **IMPLEMENT proper error handling** with meaningful messages
10. **Pagination REQUIREMENTS**:
    - Default: 50 rows per page
    - Options: 10, 25, 50, 100, 250
    - Show range: "Showing X-Y of Z"
11. **Security First** - Validate inputs, sanitize outputs, prevent SQL injection
12. **Mobile Responsive** - All interfaces must work on mobile devices
13. **Performance** - Optimize queries with indexing and eager loading
14. **Testing** - Write tests for all critical functionality
15. **REFER TO DOCS** - Always check `/Docs/Requirements/` for specifications

## Core Development Principles

### 1. Task Management
- **Task Division**: Break all work into small, manageable tasks (max 2-4 hours each)
- **Task Numbering**: Use sequential numbering (task-001, task-002, etc.)
- **Subtask Definition**: Each task must have clearly defined subtasks
- **Documentation**: Store all task documentation in `/docs/tasks/` folder
- **Task Tracking**: Use TodoWrite tool to track progress on all tasks
- **Requirements Reference**: Link tasks to specific requirements from `/Docs/Requirements/`

### 2. Development Workflow (Mandatory for Each Task)

#### Phase 1: Analysis & Planning
- **Requirements Analysis**: Review relevant sections in `/Docs/Requirements/` folder
- **Implementation Plan**: Create detailed implementation strategy
- **Impact Assessment**: Document which files/modules will be affected
- **Dependencies**: Identify all Laravel packages and Vue libraries needed
- **Database Review**: Check `/Docs/Requirements/database_schema.md` for table structures

#### Phase 2: Implementation
- **Modular Code**: Write clean, modular, reusable code
- **Code Standards**: Follow PSR-12 for PHP and Vue.js style guide
- **Type Hints**: Include type hints for all PHP methods
- **Error Handling**: Implement try-catch blocks and proper validation
- **Logging**: Use Laravel's logging system for debugging
- **Follow Schema**: Implement exactly as defined in database_schema.md

#### Phase 3: Testing & Validation
- **Unit Tests**: Write PHPUnit tests for all new features
- **Feature Tests**: Create tests for API endpoints
- **Frontend Tests**: Test Vue components with Vitest
- **Test Coverage**: Maintain minimum 80% code coverage
- **Bug Fixes**: Run all tests and fix issues before proceeding
- **User Story Validation**: Ensure implementation satisfies user stories

#### Phase 4: Documentation & Commit
- **Code Documentation**: Add PHPDoc comments to all methods
- **API Documentation**: Update API documentation for new endpoints
- **Git Commit**: Create detailed commit with task reference
- **Status Report**: Provide completion status and testing steps
- **Requirements Tracking**: Note which requirements were implemented

### 3. Code Quality Standards

#### Laravel/PHP Standards
- Follow PSR-12 coding standard
- Use Laravel conventions for naming (controllers, models, migrations)
- Implement Repository pattern for complex queries
- Use Form Requests for validation
- Implement API Resources for response formatting
- Use Eloquent ORM effectively with relationships
- Follow database schema exactly as defined in `/Docs/Requirements/database_schema.md`

#### Vue.js Standards
- Use Composition API for all components
- Implement proper TypeScript types where applicable
- Use Pinia/Vuex for state management
- Follow component naming conventions (PascalCase)
- Implement proper prop validation
- Use async/await for API calls
- Implement UI components as per `/Docs/UIUX/` specifications (if available)

#### Database Standards
- **Naming Conventions**: Use snake_case for tables and columns
- **Migrations**: One migration per feature/table change
- **Indexes**: Add indexes as specified in database_schema.md
- **Relationships**: Define all relationships as documented
- **Seeders**: Create seeders for test data
- **Follow Schema**: STRICTLY follow `/Docs/Requirements/database_schema.md`

#### API Standards
- **RESTful Routes**: Follow REST conventions
- **Versioning**: Use API versioning (v1, v2)
- **Response Format**: Consistent JSON structure
- **Status Codes**: Use appropriate HTTP status codes
- **Authentication**: Protect routes with Sanctum middleware
- **Rate Limiting**: Implement rate limiting as per technical_requirements.md

### 4. User Role Implementation

**Refer to `/Docs/Requirements/functional_requirements.md` for complete feature list**

#### Admin Features (REQ-ADM-*)
- Full system control and user management
- System constants management (job types, skills, industries)
- Website customization (themes, branding)
- Subscription plan management
- Analytics and reporting
- Content moderation and quality control

#### Company Features (REQ-CMP-*)
- Job and project posting (normal, highlighted, featured)
- Candidate search based on subscription
- Application management and status tracking
- Bookmark system for candidates
- Company profile management
- Analytics dashboard

#### Candidate Features (REQ-CND-*)
- Advanced job/project search with filters
- One-click application with profile
- Application tracking with status updates
- Profile management (resume, skills, experience)
- Bookmark system for jobs/projects
- Personalized recommendations

### 5. Testing Requirements

#### Test Categories
- **Unit Tests**: Test individual methods and functions
- **Feature Tests**: Test complete features and workflows
- **API Tests**: Test all API endpoints with different scenarios
- **Browser Tests**: Test UI interactions with Laravel Dusk
- **User Story Tests**: Validate against user stories in `/Docs/Requirements/user_stories.md`

#### Test Standards
- Test file naming: `*Test.php`
- Use PHPUnit for backend tests
- Mock external services and APIs
- Test both success and failure cases
- Include validation testing
- Test coverage minimum: 80%

### 6. Documentation Standards

#### Code Documentation
```php
/**
 * Process job application
 * Implements: REQ-CND-013 (One-click apply)
 * 
 * @param Request $request
 * @param Job $job
 * @return JsonResponse
 * @throws ValidationException
 */
public function apply(Request $request, Job $job): JsonResponse
```

#### API Documentation Template
```markdown
### Endpoint: POST /api/jobs/{id}/apply
**Requirement**: REQ-CND-013

**Description**: Submit application for a job

**Authentication**: Required (Bearer token)

**Request Body**:
```json
{
  "cover_letter": "string",
  "resume_id": "integer"
}
```

**Response**:
```json
{
  "success": true,
  "message": "Application submitted successfully",
  "data": {
    "application_id": 123,
    "status": "pending"
  }
}
```
```

### 7. Git Workflow

#### Branch Strategy
- Main branch: `main` (production-ready code)
- Development branch: `develop` (integration branch)
- Feature branches: `feature/task-XXX-description`
- Bugfix branches: `bugfix/task-XXX-description`

#### Commit Guidelines
- Commit message format: `[Task-XXX] Feature: Brief description (Implements REQ-XXX-XXX)`
- Include detailed description in commit body
- Reference related requirements from `/Docs/Requirements/`
- Ensure all tests pass before committing

#### Pre-commit Checklist
- [ ] All tests passing
- [ ] Code follows Laravel/Vue standards
- [ ] Database migrations match schema documentation
- [ ] API documentation updated
- [ ] No sensitive data in code
- [ ] Performance impact assessed
- [ ] Requirements satisfied

### 8. Project Structure

```
Job-Portal/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Company/
│   │   │   └── Candidate/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   ├── Services/
│   └── Repositories/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── js/
│   │   ├── components/
│   │   ├── pages/
│   │   │   ├── admin/
│   │   │   ├── company/
│   │   │   └── candidate/
│   │   ├── stores/
│   │   └── utils/
│   └── views/
├── routes/
│   ├── api.php
│   ├── web.php
│   └── admin.php
├── tests/
│   ├── Unit/
│   ├── Feature/
│   └── Browser/
├── Docs/
│   ├── Requirements/
│   │   ├── functional_requirements.md
│   │   ├── technical_requirements.md
│   │   ├── database_schema.md
│   │   ├── user_stories.md
│   │   └── additional_features.md
│   └── UIUX/
└── docs/
    ├── tasks/
    └── api/
```

### 9. Security Guidelines

**Refer to `/Docs/Requirements/technical_requirements.md` Section 2 for complete security requirements**

#### Authentication & Authorization (TECH-SEC-*)
- Implement Laravel Sanctum for API authentication
- Use middleware for route protection
- Implement role-based permissions
- Validate user permissions for each action
- Session timeout after inactivity

#### Data Protection
- Validate all input data using Form Requests
- Sanitize output to prevent XSS
- Use prepared statements (Eloquent ORM)
- Implement CSRF protection
- Encrypt sensitive data
- GDPR compliance measures

#### File Uploads
- Validate file types and sizes
- Scan uploaded files for malware
- Store files outside public directory
- Implement access control for downloads

### 10. Performance Standards

**Refer to `/Docs/Requirements/technical_requirements.md` Section 3 for performance metrics**

#### Backend Performance (TECH-PERF-*)
- Page load time < 3 seconds
- API response time < 500ms
- Database query optimization with eager loading
- Implement caching for frequently accessed data
- Use queues for heavy operations (email, notifications)
- Support 1000+ concurrent users

#### Frontend Performance
- Lazy loading for components and routes
- Image optimization and compression
- Minimize bundle size with code splitting
- Implement virtual scrolling for large lists
- Use CDN for static assets
- Progressive Web App (PWA) capabilities

### 11. Subscription System Implementation

**Refer to `/Docs/Requirements/functional_requirements.md` Section 6 for complete subscription features**

#### Free Plan Limits
- Maximum 3 job/project postings
- Basic search capabilities
- Standard application features

#### Premium Plans
- Multiple tier configurations
- Unlimited job/project postings
- Featured and highlighted listings
- Advanced candidate search
- Full profile access
- Priority support
- Analytics access

#### Payment Integration (TECH-INT-001 to TECH-INT-005)
- Stripe/PayPal integration
- Automated billing and renewals
- Invoice generation
- Payment history tracking
- Webhook handling
- Refund processing

### 12. Notification System

**Refer to `/Docs/Requirements/functional_requirements.md` Section 5 for communication features**

#### Email Notifications (REQ-COM-*)
- Application status updates
- New job matches for candidates
- New applications for companies
- Subscription reminders
- Interview scheduling

#### In-App Notifications
- Real-time notifications using WebSockets/Pusher
- Notification preferences management
- Mark as read/unread functionality
- Notification history

### 13. Implementation Priority

#### Phase 1: Foundation (Weeks 1-3)
- Database setup as per `/Docs/Requirements/database_schema.md`
- Authentication system (users table, roles)
- Basic admin panel structure
- User role management

#### Phase 2: Core Functionality (Weeks 4-6)
- Job and project management (REQ-CMP-005 to REQ-CMP-012)
- Application workflow (REQ-CND-013 to REQ-CND-019)
- Basic search and filtering (REQ-SRC-001 to REQ-SRC-005)
- Company and candidate dashboards

#### Phase 3: Advanced Features (Weeks 7-9)
- Subscription system (REQ-PAY-001 to REQ-SUB-005)
- Advanced search capabilities
- Bookmark functionality
- Website customization features (REQ-ADM-009 to REQ-ADM-012)

#### Phase 4: Polish & Testing (Weeks 10-12)
- UI/UX refinements
- Performance optimization
- Security testing
- Bug fixes and documentation

## Quick Reference Commands

```bash
# Laravel Commands
php artisan migrate
php artisan db:seed
php artisan test
php artisan serve
php artisan queue:work

# NPM Commands
npm install
npm run dev
npm run build
npm test

# Composer Commands
composer install
composer update
composer dump-autoload

# Testing
php artisan test --coverage
php artisan dusk
```

## Important Reminders

- **ALWAYS** refer to `/Docs/Requirements/` for detailed specifications
- Use TodoWrite tool for task tracking
- Cross-reference with database_schema.md before creating migrations
- Validate against user_stories.md during implementation
- Follow the 3-tier architecture (Admin, Company, Candidate)
- Implement proper validation and error handling
- Write tests for all new features
- Optimize for mobile devices
- Focus on security and performance
- Document all API endpoints
- Use Laravel conventions and best practices
- Test subscription limits and payment flows
- Track which requirements are being implemented

---
Last Updated: 2025-08-15
Version: 2.0
Project: Multi-Role Job Portal Platform
Documentation: Complete requirements in `/Docs/Requirements/`