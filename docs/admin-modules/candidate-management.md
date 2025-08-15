# Admin Candidate Management Module

## Overview
The Candidate Management module provides comprehensive tools for managing candidate profiles, monitoring activities, and analyzing candidate performance. This module implements requirements REQ-ADM-001 and candidate-related analytics features.

## Features

### 1. Candidate Listing & Advanced Filtering
- **Endpoint**: `GET /admin/candidates`
- **Features**:
  - Paginated candidate listing (50 per page)
  - Experience level filtering
  - Skills-based filtering
  - Location-based filtering
  - Account status filtering
  - Advanced search functionality
  - Candidate statistics dashboard

### 2. Candidate Profile Management
- **Endpoint**: `GET /admin/candidates/{id}`
- **Features**:
  - Complete candidate profile view
  - Resume and portfolio access
  - Skills and experience display
  - Application history tracking
  - Profile completion analysis
  - Activity timeline monitoring

### 3. Profile Information Updates
- **Endpoint**: `PUT /admin/candidates/{id}`
- **Features**:
  - Update personal information
  - Professional summary editing
  - Skills management
  - Resume upload handling
  - Profile picture management
  - Experience tracking

### 4. Account Management
- **Suspend**: `POST /admin/candidates/{id}/suspend`
- **Features**:
  - Account suspension with detailed reason
  - Automatic application withdrawal
  - Activity logging
  - Data integrity maintenance

### 5. Analytics & Performance Tracking
- **Analytics**: `GET /admin/candidates/{id}/analytics`
- **Statistics**: `GET /admin/candidates/statistics`
- **Features**:
  - Profile completion tracking
  - Application success rate analysis
  - Interview conversion metrics
  - Monthly activity trends
  - Skills demand analysis

### 6. Data Export & Reporting
- **Export**: `GET /admin/candidates/export`
- **Features**:
  - Filtered candidate data export
  - Multiple format support (CSV, Excel)
  - Custom field selection
  - Bulk data processing

## Implementation Details

### Controller
**File**: `app/Http/Controllers/Admin/CandidateController.php`

### Key Methods

#### `index(Request $request)`
- Displays paginated candidate list with advanced filters
- Multi-criteria search and filtering
- Comprehensive statistics overview

#### `show(Candidate $candidate)`
- Shows detailed candidate profile
- Profile completion calculation
- Application statistics analysis
- Recent activity tracking

#### `update(Request $request, Candidate $candidate)`
- Updates candidate information with validation
- Handles file uploads (resume, profile picture)
- Skills synchronization
- Profile completion recalculation

#### `suspend(Request $request, Candidate $candidate)`
- Suspends candidate account
- Withdraws pending applications
- Comprehensive activity logging

#### `analytics(Candidate $candidate)`
- Generates detailed performance analytics
- Application success rate calculation
- Response time analysis
- Interview conversion tracking

#### `getStatistics()`
- Candidate overview statistics
- Experience level distribution
- Skills demand analysis
- Registration trends

#### `export(Request $request)`
- Exports filtered candidate data
- Multiple format support
- Custom filter application

## Database Relations

### Candidates Table
- Primary candidate profile table
- Links to users table via user_id
- Contains personal and professional information
- Profile completion tracking

### Related Tables
- **users**: Authentication and account status
- **candidate_skills**: Many-to-many skills relationship
- **applications**: Job and project applications
- **bookmarks**: Saved jobs and projects
- **educations**: Educational background
- **work_experiences**: Professional experience
- **user_activities**: Activity logging

## Validation Rules

### Candidate Update
```php
'first_name' => 'required|string|max:100',
'last_name' => 'required|string|max:100',
'professional_summary' => 'nullable|string|max:2000',
'date_of_birth' => 'nullable|date|before:today',
'gender' => 'nullable|in:male,female,other',
'address' => 'nullable|string|max:500',
'city' => 'nullable|string|max:100',
'state' => 'nullable|string|max:100',
'country' => 'nullable|string|max:100',
'postal_code' => 'nullable|string|max:20',
'experience_years' => 'nullable|integer|min:0|max:50',
'current_salary' => 'nullable|numeric|min:0',
'expected_salary' => 'nullable|numeric|min:0',
'notice_period' => 'nullable|integer|min:0|max:365',
'linkedin_url' => 'nullable|url|max:255',
'github_url' => 'nullable|url|max:255',
'portfolio_url' => 'nullable|url|max:255',
'profile_picture' => 'nullable|image|max:2048',
'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
'skills' => 'nullable|array',
'skills.*' => 'exists:skills,id'
```

### Account Suspension
```php
'reason' => 'required|string|max:500'
```

## Response Formats

### Candidate List Response
```json
{
  "data": [
    {
      "id": 1,
      "first_name": "John",
      "last_name": "Doe",
      "profile_picture": "/storage/candidate-pictures/profile.jpg",
      "experience_years": 5,
      "city": "New York",
      "state": "NY",
      "user": {
        "email": "john.doe@example.com",
        "status": "active"
      },
      "skills": [
        {
          "skill": {
            "name": "JavaScript"
          },
          "proficiency": "advanced",
          "years_experience": 5
        }
      ],
      "profile_completion": 85,
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

### Candidate Analytics Response
```json
{
  "profile_stats": {
    "profile_completion": 85,
    "profile_views": 234,
    "resume_downloads": 67,
    "skills_count": 12
  },
  "application_stats": {
    "total_applications": 45,
    "success_rate": 15,
    "avg_response_time": 72,
    "interview_rate": 22
  },
  "monthly_data": [
    {
      "month": "Jan 2024",
      "applications_sent": 8,
      "interviews_received": 2
    }
  ],
  "top_skills": [
    {
      "name": "JavaScript",
      "proficiency": "advanced",
      "years_experience": 5
    }
  ]
}
```

## File Management

### Profile Pictures
- Maximum file size: 2MB
- Supported formats: JPG, PNG, GIF
- Storage: Public directory for web access
- Automatic cleanup of old files

### Resumes
- Maximum file size: 5MB
- Supported formats: PDF, DOC, DOCX
- Storage: Private directory for security
- Access control through application

### Storage Structure
```
storage/
├── app/
│   ├── public/
│   │   └── candidate-pictures/
│   │       ├── candidate_1_profile.jpg
│   │       └── candidate_2_profile.png
│   └── private/
│       └── candidate-resumes/
│           ├── candidate_1_resume.pdf
│           └── candidate_2_resume.docx
```

## Profile Completion Algorithm

### Completion Factors
1. **Basic Information** (40%):
   - First name, last name
   - Professional summary
   - Experience years
   - Location (city, state, country)

2. **Professional Details** (30%):
   - LinkedIn profile
   - Expected salary
   - Skills (at least 3)

3. **Assets** (30%):
   - Profile picture
   - Resume upload
   - Portfolio/GitHub links

### Calculation Method
```php
$completionPercentage = (completedFields / totalFields) * 100;
```

## Analytics Features

### Profile Analytics
- **Profile Views**: Track how often profile is viewed
- **Resume Downloads**: Monitor resume download frequency
- **Skills Analysis**: Popular skills and proficiency levels
- **Completion Score**: Profile completeness rating

### Application Analytics
- **Success Rate**: Percentage of successful applications
- **Response Time**: Average time to receive response
- **Interview Rate**: Percentage leading to interviews
- **Application Trends**: Monthly application patterns

### Performance Metrics
- **Job Match Score**: Compatibility with available positions
- **Market Value**: Salary expectations vs. market rates
- **Activity Score**: Platform engagement level
- **Growth Trends**: Skill development over time

## Security Features

### Access Control
- Admin authentication required
- Permission-based access (`admin:candidates.manage`)
- Sensitive data protection

### Data Protection
- Resume files stored in private directory
- Personal information encryption
- Activity logging for all modifications
- GDPR compliance features

### File Security
- Virus scanning for uploaded files
- File type validation
- Size restrictions
- Secure download mechanisms

## Error Handling

### Common Errors
- **404**: Candidate not found
- **403**: Insufficient permissions
- **422**: Validation errors
- **413**: File size too large
- **415**: Unsupported file type

### Error Responses
```json
{
  "success": false,
  "message": "Candidate update failed",
  "errors": {
    "resume": ["Resume file is too large"],
    "skills": ["Invalid skill selected"]
  }
}
```

## Related Requirements

### Functional Requirements
- **REQ-ADM-001**: Create, read, update, delete candidate accounts
- **REQ-CND-020** to **REQ-CND-026**: Profile management features
- **REQ-ANL-009** to **REQ-ANL-012**: Candidate analytics

### Security Requirements
- **TECH-SEC-001**: Authentication and authorization
- **TECH-SEC-003**: Input validation and sanitization
- **TECH-SEC-004**: File upload security
- **TECH-SEC-005**: Data encryption

### Performance Requirements
- **TECH-PERF-001**: Page load optimization
- **TECH-PERF-002**: Database query efficiency
- **TECH-PERF-003**: File handling performance

## API Endpoints

### REST API Routes
```php
GET    /admin/candidates              # List candidates
GET    /admin/candidates/{id}         # Show candidate
PUT    /admin/candidates/{id}         # Update candidate
POST   /admin/candidates/{id}/suspend # Suspend candidate
GET    /admin/candidates/{id}/analytics # Candidate analytics
GET    /admin/candidates/statistics   # Get statistics
GET    /admin/candidates/export       # Export candidates
```

## Testing

### Unit Tests
- Profile completion calculation
- Analytics algorithm accuracy
- File upload validation
- Business logic verification

### Feature Tests
- Candidate CRUD operations
- File upload functionality
- Analytics generation
- Export functionality

### Browser Tests
- Profile editing interface
- File upload interactions
- Analytics dashboard
- Search and filtering

## Future Enhancements

### Planned Features
- AI-powered skill recommendations
- Automated profile optimization
- Advanced matching algorithms
- Candidate scoring system
- Resume parsing automation
- Video profile support

### Performance Optimizations
- Caching for analytics data
- Background processing for exports
- Image optimization
- Search index optimization
- Lazy loading for large datasets

---

**Last Updated**: 2025-08-15  
**Version**: 1.0  
**Status**: Implemented  
**Dependencies**: Candidate, User, Skill, Application models