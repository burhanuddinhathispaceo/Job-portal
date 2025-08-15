# User Flow Documentation

## 1. Candidate User Flows

### 1.1 Registration Flow
```mermaid
Start → Landing Page → Click "Sign Up" → Choose "Find Jobs"
→ Enter Personal Details → Verify Email → Complete Profile
→ Upload Resume → Add Skills → Dashboard
```

**Steps:**
1. User lands on homepage
2. Clicks "Sign Up" or "Register" button
3. Selects "I want to find jobs" option
4. Fills registration form:
   - Full name
   - Email address
   - Mobile number
   - Password
5. Agrees to terms and conditions
6. Submits form
7. Receives verification email
8. Clicks verification link
9. Redirected to profile completion
10. Adds professional information
11. Uploads resume
12. Adds skills and experience
13. Lands on candidate dashboard

### 1.2 Job Search & Application Flow
```mermaid
Dashboard → Browse Jobs → Apply Filters → View Job Details
→ Click Apply → Review Application → Submit → Track Status
```

**Steps:**
1. User logs into dashboard
2. Navigates to job search
3. Enters search keywords
4. Applies filters:
   - Location
   - Salary range
   - Job type
   - Experience level
5. Views search results
6. Clicks on job to view details
7. Reviews job requirements
8. Clicks "Apply Now"
9. Reviews pre-filled information
10. Optionally adds cover letter
11. Submits application
12. Receives confirmation
13. Can track status in dashboard

### 1.3 Profile Management Flow
```mermaid
Dashboard → My Profile → Edit Section → Update Information
→ Save Changes → Verification (if needed) → Profile Updated
```

**Steps:**
1. Access profile from dashboard
2. Select section to edit:
   - Personal information
   - Work experience
   - Education
   - Skills
   - Resume
3. Make changes
4. Save updates
5. System validates changes
6. Profile updated notification
7. Completion percentage updates

### 1.4 Advanced Job Search Flow
```mermaid
Search Bar → Enter Keywords → Add Filters → Sort Results
→ Save Search → Set Alert → Receive Notifications
```

**Steps:**
1. Use advanced search option
2. Enter multiple keywords
3. Apply complex filters
4. Sort by relevance/date/salary
5. View refined results
6. Save search criteria
7. Set up job alerts
8. Receive email notifications
9. Quick apply from email

## 2. Company User Flows

### 2.1 Company Registration Flow
```mermaid
Landing Page → Sign Up → Choose "Hire Talent" → Company Details
→ Verify Email → Choose Plan → Payment → Setup Profile → Dashboard
```

**Steps:**
1. Click "For Employers" on homepage
2. Click "Sign Up"
3. Select "I want to hire talent"
4. Enter company information:
   - Company name
   - Industry
   - Size
   - Website
5. Admin user details:
   - Name
   - Email
   - Phone
6. Email verification
7. Select subscription plan
8. Enter payment details
9. Complete company profile
10. Add logo and description
11. Access company dashboard

### 2.2 Job Posting Flow
```mermaid
Dashboard → Post Job → Fill Details → Preview → Select Visibility
→ Publish → Share → Receive Applications
```

**Steps:**
1. Click "Post New Job" from dashboard
2. Enter job details:
   - Title
   - Description
   - Requirements
   - Salary range
3. Add required skills
4. Set application deadline
5. Preview job posting
6. Select visibility type:
   - Normal
   - Highlighted
   - Featured
7. Publish job
8. Share on social media (optional)
9. Job goes live
10. Receive application notifications

### 2.3 Application Management Flow
```mermaid
Dashboard → View Applications → Filter/Sort → Review Profile
→ Shortlist/Reject → Send Message → Schedule Interview → Make Decision
```

**Steps:**
1. Access applications from dashboard
2. Filter by job posting
3. Sort by date/relevance
4. Click to view candidate profile
5. Review resume and details
6. Take action:
   - Shortlist
   - Reject
   - Hold
7. Add internal notes
8. Send message to candidate
9. Schedule interview
10. Update application status
11. Send final decision

### 2.4 Candidate Search Flow
```mermaid
Dashboard → Search Candidates → Apply Filters → View Profiles
→ Bookmark → Contact → Track Response
```

**Steps:**
1. Access candidate search
2. Enter search criteria
3. Apply filters:
   - Skills
   - Experience
   - Location
   - Salary expectations
4. View search results
5. Click to view full profile
6. Bookmark interesting candidates
7. Send connection request
8. Send direct message
9. Track responses

### 2.5 Subscription Management Flow
```mermaid
Dashboard → Subscription → View Current Plan → Upgrade/Downgrade
→ Select New Plan → Payment → Confirmation → Updated Access
```

**Steps:**
1. Access subscription settings
2. View current plan details
3. Check usage statistics
4. Browse available plans
5. Select new plan
6. Review changes
7. Enter payment details
8. Confirm upgrade/downgrade
9. Receive confirmation
10. Access updated features

## 3. Admin User Flows

### 3.1 User Management Flow
```mermaid
Admin Panel → Users → Filter by Role → Select User → View Details
→ Edit/Suspend/Delete → Confirm Action → Log Activity
```

**Steps:**
1. Login to admin panel
2. Navigate to user management
3. Filter users by role/status
4. Search for specific user
5. View user details
6. Take action:
   - Edit profile
   - Suspend account
   - Delete account
   - Reset password
7. Confirm action
8. System logs activity
9. Send notification to user

### 3.2 Content Moderation Flow
```mermaid
Admin Panel → Pending Reviews → Review Content → Approve/Reject
→ Add Feedback → Update Status → Notify User
```

**Steps:**
1. Access moderation queue
2. View pending items
3. Review job/project posting
4. Check for violations
5. Make decision:
   - Approve
   - Reject
   - Request changes
6. Add admin notes
7. Update content status
8. Notify posting company
9. Log moderation action

### 3.3 System Configuration Flow
```mermaid
Admin Panel → Settings → Select Category → Modify Settings
→ Preview Changes → Save → Deploy → Monitor Impact
```

**Steps:**
1. Access system settings
2. Choose configuration category:
   - General settings
   - Email templates
   - Payment settings
   - Feature flags
3. Modify settings
4. Preview changes
5. Save configuration
6. Deploy to production
7. Monitor system impact
8. Rollback if needed

### 3.4 Analytics Review Flow
```mermaid
Admin Panel → Analytics → Select Metrics → Set Date Range
→ Generate Report → Export Data → Share with Team
```

**Steps:**
1. Access analytics dashboard
2. Select metric category
3. Set date range
4. Apply filters
5. Generate report
6. View visualizations
7. Export to PDF/Excel
8. Share with stakeholders
9. Schedule automated reports

## 4. Cross-Role Flows

### 4.1 Password Reset Flow
```mermaid
Login Page → Forgot Password → Enter Email → Receive Link
→ Click Link → Enter New Password → Confirm → Login
```

**Steps:**
1. Click "Forgot Password" on login
2. Enter registered email
3. Submit request
4. Receive reset email
5. Click reset link
6. Enter new password
7. Confirm password
8. Submit change
9. Receive confirmation
10. Login with new password

### 4.2 Notification Management Flow
```mermaid
Settings → Notifications → Select Preferences → Save
→ Receive Notifications → Take Action → Mark as Read
```

**Steps:**
1. Access notification settings
2. Choose notification types:
   - Email notifications
   - In-app notifications
   - SMS notifications
3. Set frequency
4. Save preferences
5. Receive notifications
6. Click to view details
7. Take required action
8. Mark as read/archive

### 4.3 Search and Filter Flow
```mermaid
Enter Search → Auto-suggest → Select Option → Apply Filters
→ Sort Results → Paginate → Save Search
```

**Steps:**
1. Enter search term
2. View auto-suggestions
3. Select from suggestions
4. Apply additional filters
5. Sort results
6. Navigate pages
7. Save search for later
8. Export results (if applicable)

## 5. Payment Flows

### 5.1 Subscription Purchase Flow
```mermaid
Select Plan → Review Features → Add to Cart → Enter Payment
→ Confirm → Process → Receipt → Activate Features
```

**Steps:**
1. Browse subscription plans
2. Compare features
3. Select desired plan
4. Review pricing
5. Add to cart
6. Enter payment information:
   - Card details
   - Billing address
7. Apply discount code (if any)
8. Review order
9. Confirm purchase
10. Process payment
11. Receive receipt
12. Features activated immediately

### 5.2 Payment Method Update Flow
```mermaid
Billing Settings → Payment Methods → Add/Edit Card → Verify
→ Set as Default → Save → Confirmation
```

**Steps:**
1. Access billing settings
2. View current payment methods
3. Add new card or edit existing
4. Enter card details
5. Verify with small charge
6. Set as default (optional)
7. Save changes
8. Receive confirmation
9. Update applied to subscription

## 6. Communication Flows

### 6.1 Message Flow (Company to Candidate)
```mermaid
View Application → Click Message → Compose → Send
→ Candidate Notified → Response → Continue Thread
```

**Steps:**
1. Company views application
2. Clicks message button
3. Composes message
4. Sends to candidate
5. Candidate receives notification
6. Candidate views message
7. Candidate responds
8. Conversation continues
9. History saved

### 6.2 Interview Scheduling Flow
```mermaid
Select Candidate → Schedule Interview → Choose Date/Time
→ Add Details → Send Invite → Candidate Confirms → Calendar Update
```

**Steps:**
1. Company selects candidate
2. Clicks schedule interview
3. Selects date and time
4. Adds meeting details:
   - Location/video link
   - Interviewers
   - Duration
5. Sends calendar invite
6. Candidate receives notification
7. Candidate confirms/reschedules
8. Both calendars updated
9. Reminder sent before interview

## 7. Error Handling Flows

### 7.1 Form Validation Error Flow
```mermaid
Fill Form → Submit → Validation Error → Show Errors
→ Fix Errors → Resubmit → Success
```

**Steps:**
1. User fills form
2. Submits with errors
3. System validates
4. Shows error messages
5. Highlights problem fields
6. User corrects errors
7. Resubmits form
8. Validation passes
9. Success message shown

### 7.2 Payment Failure Flow
```mermaid
Process Payment → Payment Fails → Show Error → Retry Options
→ Update Payment → Retry → Success/Contact Support
```

**Steps:**
1. Payment processing initiated
2. Payment fails
3. Error message displayed
4. Options provided:
   - Retry with same card
   - Use different payment method
   - Contact support
5. User takes action
6. Retry payment
7. Success or escalate to support

### 7.3 Session Timeout Flow
```mermaid
Idle Time → Warning Message → User Action/No Action
→ Session Expires → Redirect to Login → Re-authenticate
```

**Steps:**
1. User idle for set period
2. Warning message appears
3. Countdown timer shown
4. User can:
   - Continue session
   - Logout
   - No action
5. Session expires if no action
6. Redirect to login
7. User re-authenticates
8. Return to previous page (if possible)

## 8. Onboarding Flows

### 8.1 New Candidate Onboarding
```mermaid
First Login → Welcome Screen → Profile Tour → Feature Highlights
→ Complete Profile → First Job Search → Tutorial Complete
```

**Steps:**
1. First login after registration
2. Welcome message
3. Interactive tour starts
4. Highlight key features:
   - Profile sections
   - Job search
   - Applications
5. Prompt to complete profile
6. Guide through first search
7. Show how to apply
8. Onboarding complete
9. Option to revisit tour

### 8.2 New Company Onboarding
```mermaid
First Login → Welcome → Company Setup → Post First Job
→ Tour Features → Subscription Info → Support Resources
```

**Steps:**
1. First company login
2. Welcome screen
3. Complete company profile
4. Guided job posting
5. Tour of features:
   - Application management
   - Candidate search
   - Analytics
6. Subscription benefits explained
7. Support resources shown
8. Onboarding checklist
9. First job posted

## 9. Mobile-Specific Flows

### 9.1 Mobile Quick Apply Flow
```mermaid
Job List → Swipe Right to Save → Swipe Up for Details
→ Tap Apply → Confirm → Applied
```

**Steps:**
1. Browse jobs on mobile
2. Swipe actions:
   - Right: Save job
   - Left: Skip
   - Up: View details
3. Tap apply button
4. Review quick application
5. Confirm with touch/face ID
6. Application submitted
7. Continue browsing

### 9.2 Mobile Document Upload Flow
```mermaid
Profile → Resume Section → Upload → Choose Source
→ Camera/Files/Cloud → Select → Upload → Process → Confirm
```

**Steps:**
1. Access profile on mobile
2. Navigate to resume section
3. Tap upload button
4. Choose source:
   - Take photo
   - Files app
   - Cloud storage
5. Select document
6. Upload progress shown
7. Processing/conversion
8. Preview document
9. Confirm and save