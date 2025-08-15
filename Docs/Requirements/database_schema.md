# Database Schema Documentation

## Core Tables

### 1. users
Primary user authentication and role management table.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique user identifier |
| name | VARCHAR(255) | NOT NULL | User's full name |
| email | VARCHAR(255) | UNIQUE, NOT NULL | User's email address |
| email_verified_at | TIMESTAMP | NULLABLE | Email verification timestamp |
| password | VARCHAR(255) | NOT NULL | Hashed password |
| role | ENUM('admin','company','candidate') | NOT NULL | User role |
| mobile | VARCHAR(20) | UNIQUE, NULLABLE | Mobile number |
| status | ENUM('active','inactive','suspended') | DEFAULT 'active' | Account status |
| remember_token | VARCHAR(100) | NULLABLE | Remember me token |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE | Last update timestamp |

### 2. companies
Company profiles and details.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique company identifier |
| user_id | BIGINT | FOREIGN KEY (users.id) | Associated user account |
| company_name | VARCHAR(255) | NOT NULL | Company name |
| logo | VARCHAR(500) | NULLABLE | Logo URL/path |
| description | TEXT | NULLABLE | Company description |
| industry_id | BIGINT | FOREIGN KEY (industries.id) | Industry category |
| company_size | ENUM('1-10','11-50','51-200','201-500','500+') | NULLABLE | Company size |
| website | VARCHAR(255) | NULLABLE | Company website |
| address | TEXT | NULLABLE | Company address |
| city | VARCHAR(100) | NULLABLE | City |
| state | VARCHAR(100) | NULLABLE | State/Province |
| country | VARCHAR(100) | NULLABLE | Country |
| postal_code | VARCHAR(20) | NULLABLE | Postal code |
| founded_year | YEAR | NULLABLE | Year founded |
| linkedin_url | VARCHAR(255) | NULLABLE | LinkedIn profile |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE | Last update timestamp |

### 3. candidates
Candidate profiles and resume information.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique candidate identifier |
| user_id | BIGINT | FOREIGN KEY (users.id) | Associated user account |
| first_name | VARCHAR(100) | NOT NULL | First name |
| last_name | VARCHAR(100) | NOT NULL | Last name |
| profile_picture | VARCHAR(500) | NULLABLE | Profile picture URL/path |
| resume_path | VARCHAR(500) | NULLABLE | Resume file path |
| professional_summary | TEXT | NULLABLE | Professional summary |
| date_of_birth | DATE | NULLABLE | Date of birth |
| gender | ENUM('male','female','other') | NULLABLE | Gender |
| address | TEXT | NULLABLE | Address |
| city | VARCHAR(100) | NULLABLE | City |
| state | VARCHAR(100) | NULLABLE | State/Province |
| country | VARCHAR(100) | NULLABLE | Country |
| postal_code | VARCHAR(20) | NULLABLE | Postal code |
| experience_years | INT | DEFAULT 0 | Years of experience |
| current_salary | DECIMAL(10,2) | NULLABLE | Current salary |
| expected_salary | DECIMAL(10,2) | NULLABLE | Expected salary |
| notice_period | INT | NULLABLE | Notice period in days |
| linkedin_url | VARCHAR(255) | NULLABLE | LinkedIn profile |
| github_url | VARCHAR(255) | NULLABLE | GitHub profile |
| portfolio_url | VARCHAR(255) | NULLABLE | Portfolio website |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE | Last update timestamp |

### 4. jobs
Job listings posted by companies.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique job identifier |
| company_id | BIGINT | FOREIGN KEY (companies.id) | Posting company |
| title | VARCHAR(255) | NOT NULL | Job title |
| description | TEXT | NOT NULL | Job description |
| requirements | TEXT | NULLABLE | Job requirements |
| responsibilities | TEXT | NULLABLE | Job responsibilities |
| job_type_id | BIGINT | FOREIGN KEY (job_types.id) | Type of job |
| location | VARCHAR(255) | NULLABLE | Job location |
| is_remote | BOOLEAN | DEFAULT FALSE | Remote job flag |
| salary_min | DECIMAL(10,2) | NULLABLE | Minimum salary |
| salary_max | DECIMAL(10,2) | NULLABLE | Maximum salary |
| salary_currency | VARCHAR(3) | DEFAULT 'USD' | Salary currency |
| experience_min | INT | DEFAULT 0 | Minimum experience years |
| experience_max | INT | NULLABLE | Maximum experience years |
| education_level | VARCHAR(100) | NULLABLE | Required education |
| application_deadline | DATE | NULLABLE | Application deadline |
| status | ENUM('draft','active','inactive','expired','filled') | DEFAULT 'draft' | Job status |
| visibility | ENUM('normal','highlighted','featured') | DEFAULT 'normal' | Listing visibility |
| views_count | INT | DEFAULT 0 | Number of views |
| applications_count | INT | DEFAULT 0 | Number of applications |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE | Last update timestamp |
| published_at | TIMESTAMP | NULLABLE | Publication timestamp |

### 5. projects
Project/freelance opportunities posted by companies.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique project identifier |
| company_id | BIGINT | FOREIGN KEY (companies.id) | Posting company |
| title | VARCHAR(255) | NOT NULL | Project title |
| description | TEXT | NOT NULL | Project description |
| requirements | TEXT | NULLABLE | Project requirements |
| deliverables | TEXT | NULLABLE | Expected deliverables |
| project_type_id | BIGINT | FOREIGN KEY (project_types.id) | Type of project |
| budget_min | DECIMAL(10,2) | NULLABLE | Minimum budget |
| budget_max | DECIMAL(10,2) | NULLABLE | Maximum budget |
| budget_currency | VARCHAR(3) | DEFAULT 'USD' | Budget currency |
| duration_value | INT | NULLABLE | Project duration |
| duration_unit | ENUM('days','weeks','months') | NULLABLE | Duration unit |
| start_date | DATE | NULLABLE | Expected start date |
| application_deadline | DATE | NULLABLE | Application deadline |
| status | ENUM('draft','active','inactive','expired','completed') | DEFAULT 'draft' | Project status |
| visibility | ENUM('normal','highlighted','featured') | DEFAULT 'normal' | Listing visibility |
| views_count | INT | DEFAULT 0 | Number of views |
| applications_count | INT | DEFAULT 0 | Number of applications |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE | Last update timestamp |
| published_at | TIMESTAMP | NULLABLE | Publication timestamp |

### 6. applications
Job and project applications from candidates.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique application identifier |
| candidate_id | BIGINT | FOREIGN KEY (candidates.id) | Applying candidate |
| job_id | BIGINT | FOREIGN KEY (jobs.id), NULLABLE | Applied job (if job application) |
| project_id | BIGINT | FOREIGN KEY (projects.id), NULLABLE | Applied project (if project application) |
| cover_letter | TEXT | NULLABLE | Cover letter |
| resume_path | VARCHAR(500) | NULLABLE | Custom resume for application |
| status | ENUM('applied','viewed','shortlisted','interview','rejected','selected') | DEFAULT 'applied' | Application status |
| company_notes | TEXT | NULLABLE | Internal notes from company |
| rejection_reason | TEXT | NULLABLE | Reason for rejection |
| applied_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Application timestamp |
| viewed_at | TIMESTAMP | NULLABLE | When company viewed |
| responded_at | TIMESTAMP | NULLABLE | When company responded |

### 7. bookmarks
User bookmarks for jobs, projects, and candidates.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique bookmark identifier |
| user_id | BIGINT | FOREIGN KEY (users.id) | User who bookmarked |
| bookmarkable_type | VARCHAR(50) | NOT NULL | Type of bookmarked item |
| bookmarkable_id | BIGINT | NOT NULL | ID of bookmarked item |
| folder | VARCHAR(100) | NULLABLE | Bookmark folder/category |
| notes | TEXT | NULLABLE | Personal notes |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Bookmark timestamp |

### 8. subscriptions
Company subscription records.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique subscription identifier |
| company_id | BIGINT | FOREIGN KEY (companies.id) | Subscribing company |
| plan_id | BIGINT | FOREIGN KEY (subscription_plans.id) | Subscription plan |
| status | ENUM('active','expired','cancelled','suspended') | DEFAULT 'active' | Subscription status |
| start_date | DATE | NOT NULL | Subscription start date |
| end_date | DATE | NOT NULL | Subscription end date |
| auto_renew | BOOLEAN | DEFAULT TRUE | Auto-renewal flag |
| payment_method | VARCHAR(50) | NULLABLE | Payment method used |
| transaction_id | VARCHAR(255) | NULLABLE | Payment transaction ID |
| amount_paid | DECIMAL(10,2) | NOT NULL | Amount paid |
| currency | VARCHAR(3) | DEFAULT 'USD' | Payment currency |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE | Last update timestamp |

### 9. subscription_plans
Available subscription plans and features.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique plan identifier |
| name | VARCHAR(100) | NOT NULL | Plan name |
| description | TEXT | NULLABLE | Plan description |
| price | DECIMAL(10,2) | NOT NULL | Plan price |
| currency | VARCHAR(3) | DEFAULT 'USD' | Price currency |
| duration_days | INT | NOT NULL | Plan duration in days |
| job_post_limit | INT | DEFAULT 0 | Number of job posts allowed |
| project_post_limit | INT | DEFAULT 0 | Number of project posts allowed |
| featured_posts | INT | DEFAULT 0 | Number of featured posts |
| highlighted_posts | INT | DEFAULT 0 | Number of highlighted posts |
| candidate_search | BOOLEAN | DEFAULT FALSE | Can search candidates |
| candidate_view_limit | INT | DEFAULT 0 | Candidate profiles viewable |
| analytics_access | BOOLEAN | DEFAULT FALSE | Advanced analytics access |
| priority_support | BOOLEAN | DEFAULT FALSE | Priority support flag |
| is_active | BOOLEAN | DEFAULT TRUE | Plan availability |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE | Last update timestamp |

## Configuration Tables

### 10. job_types
Types of employment.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | VARCHAR(100) | NOT NULL | Job type name |
| slug | VARCHAR(100) | UNIQUE, NOT NULL | URL-friendly slug |
| description | TEXT | NULLABLE | Type description |
| is_active | BOOLEAN | DEFAULT TRUE | Active status |

### 11. project_types
Types of projects.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | VARCHAR(100) | NOT NULL | Project type name |
| slug | VARCHAR(100) | UNIQUE, NOT NULL | URL-friendly slug |
| description | TEXT | NULLABLE | Type description |
| is_active | BOOLEAN | DEFAULT TRUE | Active status |

### 12. skills
Skills database.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | VARCHAR(100) | NOT NULL | Skill name |
| category | VARCHAR(100) | NULLABLE | Skill category |
| is_active | BOOLEAN | DEFAULT TRUE | Active status |

### 13. industries
Industry classifications.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | VARCHAR(100) | NOT NULL | Industry name |
| slug | VARCHAR(100) | UNIQUE, NOT NULL | URL-friendly slug |
| parent_id | BIGINT | FOREIGN KEY (industries.id), NULLABLE | Parent industry |
| is_active | BOOLEAN | DEFAULT TRUE | Active status |

### 14. locations
Geographical data for locations.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| name | VARCHAR(100) | NOT NULL | Location name |
| type | ENUM('country','state','city') | NOT NULL | Location type |
| parent_id | BIGINT | FOREIGN KEY (locations.id), NULLABLE | Parent location |
| code | VARCHAR(10) | NULLABLE | Location code |
| is_active | BOOLEAN | DEFAULT TRUE | Active status |

## Junction Tables

### 15. job_skills
Many-to-many relationship between jobs and skills.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| job_id | BIGINT | FOREIGN KEY (jobs.id) | Job reference |
| skill_id | BIGINT | FOREIGN KEY (skills.id) | Skill reference |
| is_required | BOOLEAN | DEFAULT TRUE | Required vs preferred |
| PRIMARY KEY | (job_id, skill_id) | Composite key |

### 16. project_skills
Many-to-many relationship between projects and skills.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| project_id | BIGINT | FOREIGN KEY (projects.id) | Project reference |
| skill_id | BIGINT | FOREIGN KEY (skills.id) | Skill reference |
| is_required | BOOLEAN | DEFAULT TRUE | Required vs preferred |
| PRIMARY KEY | (project_id, skill_id) | Composite key |

### 17. candidate_skills
Many-to-many relationship between candidates and skills.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| candidate_id | BIGINT | FOREIGN KEY (candidates.id) | Candidate reference |
| skill_id | BIGINT | FOREIGN KEY (skills.id) | Skill reference |
| proficiency | ENUM('beginner','intermediate','advanced','expert') | DEFAULT 'intermediate' | Skill level |
| years_experience | INT | DEFAULT 0 | Years of experience |
| PRIMARY KEY | (candidate_id, skill_id) | Composite key |

## System Tables

### 18. website_settings
Website customization settings.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| key | VARCHAR(100) | UNIQUE, NOT NULL | Setting key |
| value | TEXT | NULLABLE | Setting value |
| type | VARCHAR(50) | DEFAULT 'string' | Value type |
| group | VARCHAR(100) | DEFAULT 'general' | Settings group |
| description | TEXT | NULLABLE | Setting description |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE | Last update timestamp |

### 19. user_activities
User action logs.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| user_id | BIGINT | FOREIGN KEY (users.id) | User reference |
| activity_type | VARCHAR(100) | NOT NULL | Type of activity |
| description | TEXT | NULLABLE | Activity description |
| ip_address | VARCHAR(45) | NULLABLE | User IP address |
| user_agent | TEXT | NULLABLE | Browser user agent |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Activity timestamp |

### 20. notifications
User notifications.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| user_id | BIGINT | FOREIGN KEY (users.id) | User reference |
| type | VARCHAR(100) | NOT NULL | Notification type |
| title | VARCHAR(255) | NOT NULL | Notification title |
| message | TEXT | NOT NULL | Notification message |
| data | JSON | NULLABLE | Additional data |
| is_read | BOOLEAN | DEFAULT FALSE | Read status |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| read_at | TIMESTAMP | NULLABLE | When read |

## Indexes

### Performance Indexes
- `idx_users_email` on users(email)
- `idx_users_role` on users(role)
- `idx_jobs_company` on jobs(company_id)
- `idx_jobs_status` on jobs(status)
- `idx_projects_company` on projects(company_id)
- `idx_applications_candidate` on applications(candidate_id)
- `idx_applications_job` on applications(job_id)
- `idx_applications_status` on applications(status)
- `idx_bookmarks_user` on bookmarks(user_id)
- `idx_subscriptions_company` on subscriptions(company_id)

### Composite Indexes
- `idx_applications_candidate_job` on applications(candidate_id, job_id)
- `idx_bookmarks_user_type` on bookmarks(user_id, bookmarkable_type)
- `idx_jobs_status_visibility` on jobs(status, visibility)

## Relationships

### One-to-One
- users ↔ companies (via user_id)
- users ↔ candidates (via user_id)

### One-to-Many
- companies → jobs
- companies → projects
- companies → subscriptions
- subscription_plans → subscriptions
- industries → companies
- job_types → jobs
- project_types → projects

### Many-to-Many
- jobs ↔ skills (via job_skills)
- projects ↔ skills (via project_skills)
- candidates ↔ skills (via candidate_skills)

### Polymorphic
- bookmarks → jobs/projects/candidates (via bookmarkable_type/id)