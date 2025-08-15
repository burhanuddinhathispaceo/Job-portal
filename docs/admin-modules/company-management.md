# Admin Company Management Module

## Overview
The Company Management module provides comprehensive tools for managing company accounts, verification processes, and monitoring company activities. This module implements requirements REQ-ADM-002 and related company management features.

## Features

### 1. Company Listing & Filtering
- **Endpoint**: `GET /admin/companies`
- **Features**:
  - Paginated company listing (50 per page)
  - Industry-based filtering
  - Company size filtering
  - Account status filtering
  - Subscription status filtering
  - Advanced search functionality
  - Company statistics dashboard

### 2. Company Profile Management
- **Endpoint**: `GET /admin/companies/{id}`
- **Features**:
  - Complete company profile view
  - Business information display
  - Job and project listings
  - Application statistics
  - Subscription details
  - Activity timeline

### 3. Company Information Updates
- **Endpoint**: `PUT /admin/companies/{id}`
- **Features**:
  - Update company profile information
  - Logo upload and management
  - Address and contact information
  - Industry classification
  - Website and social media links

### 4. Company Verification System
- **Verify**: `POST /admin/companies/{id}/verify`
- **Reject**: `POST /admin/companies/{id}/reject-verification`
- **Features**:
  - Manual company verification
  - Verification status tracking
  - Rejection with detailed reasons
  - Verification notes and comments
  - Automated notification system

### 5. Account Management
- **Suspend**: `POST /admin/companies/{id}/suspend`
- **Features**:
  - Account suspension with reason
  - Automatic job/project deactivation
  - Activity logging
  - Related data handling

### 6. Analytics & Reporting
- **Analytics**: `GET /admin/companies/{id}/analytics`
- **Export**: `GET /admin/companies/export`
- **Features**:
  - Company performance metrics
  - Job posting analytics
  - Application statistics
  - Monthly trend analysis
  - Data export functionality

## Implementation Details

### Controller
**File**: `app/Http/Controllers/Admin/CompanyController.php`

### Key Methods

#### `index(Request $request)`
- Displays paginated company list with advanced filters
- Includes comprehensive statistics
- Supports multi-criteria search

#### `show(Company $company)`
- Shows detailed company profile
- Loads all relationships and statistics
- Displays recent activities and performance metrics

#### `update(Request $request, Company $company)`
- Updates company information with validation
- Handles logo upload and file management
- Database transaction support

#### `verify(Request $request, Company $company)`
- Processes company verification
- Updates verification status
- Logs verification activities
- Triggers notification system

#### `rejectVerification(Request $request, Company $company)`
- Handles verification rejection
- Records rejection reasons
- Maintains verification audit trail

#### `suspend(Request $request, Company $company)`
- Suspends company account
- Deactivates related content
- Comprehensive activity logging

#### `analytics(Company $company)`
- Generates detailed analytics
- Performance metrics calculation
- Trend analysis and reporting

#### `getStatistics()`
- Company overview statistics
- Industry and size distribution
- Verification status breakdown

#### `export(Request $request)`
- Exports filtered company data
- Multiple format support
- Custom filter application

## Database Relations

### Companies Table
- Primary company profile table
- Links to users table via user_id
- Industry classification
- Verification status tracking

### Related Tables
- **users**: Authentication and account status
- **industries**: Industry classification
- **jobs**: Company job postings
- **projects**: Company project postings
- **subscriptions**: Subscription management
- **user_activities**: Activity logging

## Validation Rules

### Company Update
```php
'company_name' => 'required|string|max:255',
'description' => 'nullable|string|max:5000',
'industry_id' => 'required|exists:industries,id',
'company_size' => 'nullable|in:1-10,11-50,51-200,201-500,500+',
'website' => 'nullable|url|max:255',
'address' => 'nullable|string|max:500',
'city' => 'nullable|string|max:100',
'state' => 'nullable|string|max:100',
'country' => 'nullable|string|max:100',
'postal_code' => 'nullable|string|max:20',
'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
'linkedin_url' => 'nullable|url|max:255',
'logo' => 'nullable|image|max:2048'
```

### Verification Operations
```php
'verification_notes' => 'nullable|string|max:1000',
'rejection_reason' => 'required|string|max:1000'
```

### Account Suspension
```php
'reason' => 'required|string|max:500'
```

## Response Formats

### Company List Response
```json
{
  "data": [
    {
      "id": 1,
      "company_name": "Tech Solutions Inc",
      "logo": "/storage/company-logos/logo.png",
      "industry": {
        "name": "Technology"
      },
      "user": {
        "email": "contact@techsolutions.com",
        "status": "active"
      },
      "verification_status": "verified",
      "subscription": {
        "status": "active",
        "plan": {
          "name": "Premium"
        }
      },
      "created_at": "2024-01-01T00:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "per_page": 50,
    "total": 150
  }
}
```

### Company Analytics Response
```json
{
  "job_stats": {
    "total_jobs": 25,
    "active_jobs": 18,
    "total_views": 1250,
    "total_applications": 342
  },
  "project_stats": {
    "total_projects": 8,
    "active_projects": 5,
    "total_views": 456,
    "total_applications": 89
  },
  "monthly_data": [
    {
      "month": "Jan 2024",
      "jobs_posted": 5,
      "applications_received": 45
    }
  ],
  "top_jobs": [
    {
      "id": 1,
      "title": "Senior Developer",
      "views_count": 234,
      "applications_count": 67
    }
  ]
}
```

### Verification Response
```json
{
  "success": true,
  "message": "Company verified successfully"
}
```

## Security Features

### Access Control
- Admin authentication required
- Permission-based access (`admin:companies.manage`)
- Operation-specific authorization

### Data Protection
- Input validation and sanitization
- File upload security
- SQL injection prevention
- XSS protection

### Activity Logging
- Verification status changes
- Account modifications
- Administrative actions
- Suspension activities

## File Management

### Logo Upload
- Maximum file size: 2MB
- Supported formats: JPG, PNG, GIF
- Automatic old file cleanup
- Secure storage in public directory

### Storage Structure
```
storage/
├── app/
│   └── public/
│       └── company-logos/
│           ├── company_1_logo.png
│           └── company_2_logo.jpg
```

## Verification Workflow

### Status Flow
1. **Pending** - Default status for new companies
2. **Under Review** - Admin reviewing company details
3. **Verified** - Company approved and verified
4. **Rejected** - Company verification rejected with reason

### Verification Criteria
- Complete company profile information
- Valid business details
- Legitimate website and contact information
- Industry compliance
- Terms of service acceptance

## Error Handling

### Common Errors
- **404**: Company not found
- **403**: Insufficient permissions
- **422**: Validation errors
- **413**: File too large
- **500**: Database/server errors

### Error Responses
```json
{
  "success": false,
  "message": "Company update failed",
  "errors": {
    "company_name": ["Company name is required"],
    "logo": ["Logo file is too large"]
  }
}
```

## Related Requirements

### Functional Requirements
- **REQ-ADM-002**: Create, read, update, delete company accounts
- **REQ-CMP-001**: Analytics overview
- **REQ-CMP-002**: Recent activities display
- **REQ-CMP-003**: Subscription status monitoring

### Security Requirements
- **TECH-SEC-001**: Authentication and authorization
- **TECH-SEC-002**: Data encryption
- **TECH-SEC-003**: Input validation
- **TECH-SEC-004**: File upload security

### Performance Requirements
- **TECH-PERF-001**: Page load optimization
- **TECH-PERF-002**: Database query efficiency
- **TECH-PERF-003**: File handling performance

## API Endpoints

### REST API Routes
```php
GET    /admin/companies              # List companies
GET    /admin/companies/{id}         # Show company
PUT    /admin/companies/{id}         # Update company
POST   /admin/companies/{id}/verify  # Verify company
POST   /admin/companies/{id}/reject-verification  # Reject verification
POST   /admin/companies/{id}/suspend # Suspend company
GET    /admin/companies/{id}/analytics # Company analytics
GET    /admin/companies/export       # Export companies
GET    /admin/companies/statistics   # Get statistics
```

## Testing

### Unit Tests
- Controller method functionality
- Validation rule testing
- Business logic verification

### Feature Tests
- Company CRUD operations
- Verification workflow
- File upload handling
- Analytics generation

### Browser Tests
- Admin interface navigation
- Form submissions
- File upload interactions
- AJAX operations

## Future Enhancements

### Planned Features
- Automated verification system
- Company performance scoring
- Bulk company operations
- Advanced analytics dashboard
- Company communication tools
- Integration with external verification services

### Performance Optimizations
- Caching for company statistics
- Image optimization for logos
- Lazy loading for analytics
- Background processing for exports

---

**Last Updated**: 2025-08-15  
**Version**: 1.0  
**Status**: Implemented  
**Dependencies**: Company, User, Industry, Job, Project models