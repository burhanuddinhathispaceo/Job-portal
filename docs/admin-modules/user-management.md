# Admin User Management Module

## Overview
The User Management module provides comprehensive CRUD operations for managing users, companies, and candidates in the system. This module implements requirements REQ-ADM-001 through REQ-ADM-004.

## Features

### 1. User Listing & Search
- **Endpoint**: `GET /admin/users`
- **Features**:
  - Paginated user listing (50 per page)
  - Role-based filtering (admin, company, candidate)
  - Status filtering (active, inactive, suspended)
  - Search by name, email, or mobile
  - User statistics dashboard

### 2. User Details & Profile Management
- **Endpoint**: `GET /admin/users/{id}`
- **Features**:
  - Complete user profile view
  - Role-specific information display
  - Recent activity timeline
  - Account status management

### 3. User Information Updates
- **Endpoint**: `PUT /admin/users/{id}`
- **Features**:
  - Update basic user information
  - Role-specific data updates
  - Password reset functionality
  - Email/mobile validation

### 4. User Status Management
- **Toggle Status**: `POST /admin/users/{id}/toggle-status`
- **Suspend User**: `POST /admin/users/{id}/suspend`
- **Features**:
  - Active/inactive status toggle
  - Account suspension with reason
  - Activity logging
  - Automatic related data handling

### 5. Bulk Operations
- **Import**: `POST /admin/users/bulk-import`
- **Export**: `GET /admin/users/bulk-export`
- **Features**:
  - CSV/Excel file import
  - Multiple export formats
  - Batch user creation
  - Import validation and error reporting

## Implementation Details

### Controller
**File**: `app/Http/Controllers/Admin/UserManagementController.php`

### Key Methods

#### `index(Request $request)`
- Displays paginated user list with filters
- Includes user statistics
- Supports search and role filtering

#### `show(User $user)`
- Shows detailed user profile
- Loads relationships (company/candidate)
- Displays recent activities

#### `update(Request $request, User $user)`
- Updates user information with validation
- Handles role-specific data updates
- Database transaction support

#### `toggleStatus(User $user)`
- Toggles user active/inactive status
- Returns JSON response for AJAX calls

#### `suspend(Request $request, User $user)`
- Suspends user account with reason
- Logs suspension activity
- Handles related data cleanup

#### `destroy(User $user)`
- Soft deletes user account
- Handles cascade operations
- Maintains data integrity

#### `bulkImport(Request $request)`
- Processes CSV/Excel file uploads
- Validates and imports user data
- Returns import statistics

#### `bulkExport(Request $request)`
- Exports filtered user data
- Supports multiple formats
- Generates downloadable files

## Database Relations

### Users Table
- Primary user authentication table
- Stores basic user information
- Role-based access control

### Related Tables
- **companies**: Company-specific profile data
- **candidates**: Candidate-specific profile data
- **user_activities**: User action logs

## Validation Rules

### User Update
```php
'name' => 'required|string|max:255',
'email' => 'required|email|max:255|unique:users,email,{id}',
'mobile' => 'nullable|string|max:20|unique:users,mobile,{id}',
'status' => 'required|in:active,inactive,suspended',
'password' => 'nullable|string|min:8|confirmed'
```

### Bulk Import
```php
'file' => 'required|file|mimes:csv,xlsx,xls|max:5120',
'role' => 'required|in:company,candidate'
```

### User Suspension
```php
'reason' => 'required|string|max:500'
```

## Response Formats

### User List Response
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "candidate",
      "status": "active",
      "created_at": "2024-01-01T00:00:00Z",
      "company": null,
      "candidate": {
        "first_name": "John",
        "last_name": "Doe"
      }
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 50,
    "total": 150
  }
}
```

### Status Toggle Response
```json
{
  "success": true,
  "message": "User status updated successfully",
  "status": "inactive"
}
```

### Bulk Import Response
```json
{
  "success": true,
  "message": "Import completed successfully",
  "results": {
    "total_rows": 100,
    "successful_imports": 95,
    "failed_imports": 5,
    "errors": [
      "Row 3: Email already exists",
      "Row 7: Invalid role specified"
    ]
  }
}
```

## Security Features

### Access Control
- Admin authentication required
- Permission-based access (`admin:users.manage`)
- Role validation for operations

### Data Protection
- Input validation and sanitization
- SQL injection prevention
- XSS protection
- CSRF token validation

### Activity Logging
- User modification tracking
- Suspension reason logging
- Admin action audit trail

## Error Handling

### Common Errors
- **404**: User not found
- **403**: Insufficient permissions
- **422**: Validation errors
- **500**: Database/server errors

### Error Responses
```json
{
  "success": false,
  "message": "User update failed",
  "errors": {
    "email": ["Email already exists"]
  }
}
```

## Related Requirements

### Functional Requirements
- **REQ-ADM-001**: Create, read, update, delete candidate accounts
- **REQ-ADM-002**: Create, read, update, delete company accounts
- **REQ-ADM-003**: Bulk user import/export functionality
- **REQ-ADM-004**: User status management (active/inactive/suspended)

### Security Requirements
- **TECH-SEC-001**: Authentication and authorization
- **TECH-SEC-003**: Input validation and sanitization
- **TECH-SEC-005**: Activity logging and audit trails

## Testing

### Unit Tests
- Controller method testing
- Validation rule testing
- Database relationship testing

### Feature Tests
- User CRUD operations
- Bulk import/export functionality
- Status management workflows

### Browser Tests
- Admin interface navigation
- Form submissions and validations
- AJAX status updates

## Future Enhancements

### Planned Features
- Advanced user analytics
- Automated user verification
- Custom user roles and permissions
- Bulk user communication tools
- User activity dashboard
- Export scheduling

### Performance Optimizations
- Database query optimization
- Caching for user statistics
- Asynchronous import processing
- Background export generation

---

**Last Updated**: 2025-08-15  
**Version**: 1.0  
**Status**: Implemented  
**Dependencies**: User, Company, Candidate models