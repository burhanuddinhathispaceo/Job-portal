# Functional Requirements

## 1. User Management

### 1.1 Authentication & Registration
- **REQ-AUTH-001:** System shall support multi-role authentication (Admin, Company, Candidate)
- **REQ-AUTH-002:** Email and mobile number validation for unique user accounts
- **REQ-AUTH-003:** Secure password reset functionality via email
- **REQ-AUTH-004:** Session management with timeout capabilities
- **REQ-AUTH-005:** Remember me functionality for returning users

### 1.2 Role-Based Access Control
- **REQ-RBAC-001:** Admin role with full system access
- **REQ-RBAC-002:** Company role with company-specific features
- **REQ-RBAC-003:** Candidate role with job search and application features
- **REQ-RBAC-004:** Permission-based feature access for each role

## 2. Admin Features

### 2.1 User Management
- **REQ-ADM-001:** Create, read, update, delete candidate accounts
- **REQ-ADM-002:** Create, read, update, delete company accounts
- **REQ-ADM-003:** Bulk user import/export functionality
- **REQ-ADM-004:** User status management (active/inactive/suspended)

### 2.2 Content Management
- **REQ-ADM-005:** Job posting management with company assignment
- **REQ-ADM-006:** Project posting management with company assignment
- **REQ-ADM-007:** Category and skill database management
- **REQ-ADM-008:** System constants configuration (job types, industries, etc.)

### 2.3 Website Customization
- **REQ-ADM-009:** Theme management (dark/light mode)
- **REQ-ADM-010:** Logo and branding customization
- **REQ-ADM-011:** Homepage content management
- **REQ-ADM-012:** Header/footer customization

### 2.4 Subscription Management
- **REQ-ADM-013:** Create and manage subscription plans
- **REQ-ADM-014:** Define plan features and limitations
- **REQ-ADM-015:** Free plan with 3 jobs/projects limit
- **REQ-ADM-016:** Premium plan configuration

## 3. Company Features

### 3.1 Dashboard
- **REQ-CMP-001:** Analytics overview (views, applications, bookmarks)
- **REQ-CMP-002:** Recent activities and notifications display
- **REQ-CMP-003:** Subscription status and usage metrics
- **REQ-CMP-004:** Quick actions panel for common tasks

### 3.2 Job & Project Management
- **REQ-CMP-005:** Post normal job listings
- **REQ-CMP-006:** Post highlighted job listings (enhanced visibility)
- **REQ-CMP-007:** Post featured job listings (premium placement)
- **REQ-CMP-008:** Rich text editor for descriptions
- **REQ-CMP-009:** Set requirements and qualifications
- **REQ-CMP-010:** Define salary/budget ranges
- **REQ-CMP-011:** Set application deadlines
- **REQ-CMP-012:** Attachment support for additional documents

### 3.3 Candidate Management
- **REQ-CMP-013:** Advanced candidate search with filters
- **REQ-CMP-014:** View candidate profiles based on subscription
- **REQ-CMP-015:** Review submitted applications
- **REQ-CMP-016:** Approve/reject applications with feedback
- **REQ-CMP-017:** Application status tracking
- **REQ-CMP-018:** Communication tools for candidate interaction

### 3.4 Bookmark System
- **REQ-CMP-019:** Bookmark interesting candidates
- **REQ-CMP-020:** Bookmark relevant jobs/projects
- **REQ-CMP-021:** Organize bookmarks in categories
- **REQ-CMP-022:** Bulk bookmark management

## 4. Candidate Features

### 4.1 Dashboard
- **REQ-CND-001:** Application status overview
- **REQ-CND-002:** Recommended jobs/projects display
- **REQ-CND-003:** Profile completion status indicator
- **REQ-CND-004:** Recent activities and notifications

### 4.2 Job & Project Search
- **REQ-CND-005:** Keyword-based search functionality
- **REQ-CND-006:** Location-based filtering
- **REQ-CND-007:** Salary/budget range filtering
- **REQ-CND-008:** Company size and industry filters
- **REQ-CND-009:** Job type and experience level filters
- **REQ-CND-010:** Grid and list view options
- **REQ-CND-011:** Sorting options (date, salary, relevance)
- **REQ-CND-012:** Save search queries for future use

### 4.3 Application Management
- **REQ-CND-013:** One-click apply with profile
- **REQ-CND-014:** Custom cover letter attachment
- **REQ-CND-015:** Application tracking system
- **REQ-CND-016:** Status notifications (applied, viewed, shortlisted, rejected, selected)
- **REQ-CND-017:** Complete application timeline view
- **REQ-CND-018:** Interview schedule management
- **REQ-CND-019:** Application analytics

### 4.4 Profile Management
- **REQ-CND-020:** Personal information management
- **REQ-CND-021:** Professional summary and objectives
- **REQ-CND-022:** Work experience with descriptions
- **REQ-CND-023:** Education background management
- **REQ-CND-024:** Skills and certifications
- **REQ-CND-025:** Portfolio/project showcase
- **REQ-CND-026:** Resume upload (PDF format)

### 4.5 Bookmark System
- **REQ-CND-027:** Bookmark interesting jobs/projects
- **REQ-CND-028:** Organize bookmarks in folders
- **REQ-CND-029:** Bookmark sharing capabilities
- **REQ-CND-030:** Expiry notifications for bookmarked items

## 5. Communication Features

### 5.1 Notifications
- **REQ-COM-001:** Email notifications for important events
- **REQ-COM-002:** In-app notification system
- **REQ-COM-003:** Real-time updates for critical actions
- **REQ-COM-004:** Notification preferences management

### 5.2 Messaging
- **REQ-COM-005:** Application status updates
- **REQ-COM-006:** Interview scheduling notifications
- **REQ-COM-007:** Subscription renewal reminders
- **REQ-COM-008:** System announcements

## 6. Payment & Subscription

### 6.1 Payment Processing
- **REQ-PAY-001:** Stripe integration for payments
- **REQ-PAY-002:** PayPal support as alternative
- **REQ-PAY-003:** Automatic subscription renewal
- **REQ-PAY-004:** Invoice generation and management
- **REQ-PAY-005:** Payment history tracking

### 6.2 Subscription Management
- **REQ-SUB-001:** Free plan with limitations
- **REQ-SUB-002:** Multiple premium plan tiers
- **REQ-SUB-003:** Plan upgrade/downgrade functionality
- **REQ-SUB-004:** Usage tracking and limits enforcement
- **REQ-SUB-005:** Grace period for expired subscriptions

## 7. Search & Discovery

### 7.1 Search Functionality
- **REQ-SRC-001:** Full-text search across jobs/projects
- **REQ-SRC-002:** Advanced filtering options
- **REQ-SRC-003:** Search result relevance ranking
- **REQ-SRC-004:** Search history and saved searches
- **REQ-SRC-005:** Auto-complete and suggestions

### 7.2 Recommendations
- **REQ-REC-001:** Job recommendations based on profile
- **REQ-REC-002:** Similar job suggestions
- **REQ-REC-003:** Company recommendations
- **REQ-REC-004:** Skill-based matching

## 8. Reporting & Analytics

### 8.1 Admin Analytics
- **REQ-ANL-001:** System-wide usage statistics
- **REQ-ANL-002:** User growth metrics
- **REQ-ANL-003:** Revenue and subscription reports
- **REQ-ANL-004:** Job posting trends

### 8.2 Company Analytics
- **REQ-ANL-005:** Job posting performance metrics
- **REQ-ANL-006:** Application statistics
- **REQ-ANL-007:** Candidate engagement metrics
- **REQ-ANL-008:** ROI on subscription

### 8.3 Candidate Analytics
- **REQ-ANL-009:** Profile view statistics
- **REQ-ANL-010:** Application success rate
- **REQ-ANL-011:** Job match scores
- **REQ-ANL-012:** Activity timeline