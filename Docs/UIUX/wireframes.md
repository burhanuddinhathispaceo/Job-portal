# Wireframe Specifications

## 1. Public Pages

### 1.1 Homepage
```
┌─────────────────────────────────────────────────────────────┐
│ [Logo]  Jobs  Projects  Companies  About  Contact  [Login]  │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│            Find Your Dream Job                             │
│       [    Search Jobs/Projects    ] [Location] [Search]   │
│                                                             │
│       Popular: Developer Designer Manager Sales Remote     │
│                                                             │
├─────────────────────────────────────────────────────────────┤
│                    Featured Jobs                           │
│ ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐         │
│ │ Job Card │ │ Job Card │ │ Job Card │ │ Job Card │         │
│ └─────────┘ └─────────┘ └─────────┘ └─────────┘         │
├─────────────────────────────────────────────────────────────┤
│                  How It Works                              │
│     [1]            [2]            [3]            [4]       │
│  Create Profile  Search Jobs   Apply Online   Get Hired   │
├─────────────────────────────────────────────────────────────┤
│              Top Companies Hiring                          │
│  [Logo] [Logo] [Logo] [Logo] [Logo] [Logo]                │
├─────────────────────────────────────────────────────────────┤
│                    Statistics                              │
│   10K+ Jobs    5K+ Companies    50K+ Candidates          │
├─────────────────────────────────────────────────────────────┤
│ Footer: About | Privacy | Terms | Contact | Social Links   │
└─────────────────────────────────────────────────────────────┘
```

### 1.2 Job Listing Page
```
┌─────────────────────────────────────────────────────────────┐
│ [Logo]  [Navigation Menu]                    [User Menu]    │
├─────────────────────────────────────────────────────────────┤
│ Jobs > Search Results                                      │
├─────────────────────────────────────────────────────────────┤
│ ┌──────────────┬───────────────────────────────────────┐   │
│ │   FILTERS    │         SEARCH RESULTS (245)          │   │
│ ├──────────────┤                                       │   │
│ │ Job Type     │ ┌─────────────────────────────────┐  │   │
│ │ □ Full-time  │ │ Senior Developer                │  │   │
│ │ □ Part-time  │ │ TechCorp | San Francisco       │  │   │
│ │ □ Contract   │ │ $120k-150k | 2 days ago        │  │   │
│ │              │ │ [Save] [Quick Apply]           │  │   │
│ │ Location     │ └─────────────────────────────────┘  │   │
│ │ [City input] │                                       │   │
│ │              │ ┌─────────────────────────────────┐  │   │
│ │ Salary Range │ │ Product Manager                 │  │   │
│ │ [Min] - [Max]│ │ StartupXYZ | Remote            │  │   │
│ │              │ │ $100k-130k | 3 days ago        │  │   │
│ │ Experience   │ │ [Save] [Quick Apply]           │  │   │
│ │ ○ Entry      │ └─────────────────────────────────┘  │   │
│ │ ○ Mid        │                                       │   │
│ │ ○ Senior     │ [Load More Jobs]                      │   │
│ └──────────────┴───────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

### 1.3 Job Detail Page
```
┌─────────────────────────────────────────────────────────────┐
│ [Logo]  [Navigation Menu]                    [User Menu]    │
├─────────────────────────────────────────────────────────────┤
│ < Back to Search                                           │
├─────────────────────────────────────────────────────────────┤
│ ┌──────────────────────────────────┬───────────────────┐   │
│ │ [Company Logo]                   │   Similar Jobs    │   │
│ │                                   ├───────────────────┤   │
│ │ Senior Full Stack Developer       │ • UI Developer    │   │
│ │ TechCorp Inc.                     │ • Backend Dev     │   │
│ │ San Francisco, CA | Remote OK     │ • DevOps Engineer │   │
│ │ $120,000 - $150,000 per year      │                   │   │
│ │                                   ├───────────────────┤   │
│ │ [Apply Now] [Save Job]            │  Company Info     │   │
│ │                                   ├───────────────────┤   │
│ ├───────────────────────────────────┤ Industry: Tech    │   │
│ │ Job Description                   │ Size: 500+ emp    │   │
│ │ Lorem ipsum dolor sit amet...     │ Website: link     │   │
│ │                                   │                   │   │
│ │ Requirements                      │                   │   │
│ │ • 5+ years experience              │                   │   │
│ │ • React, Node.js                  │                   │   │
│ │                                   │                   │   │
│ │ Benefits                          │                   │   │
│ │ • Health insurance                │                   │   │
│ │ • 401k matching                   │                   │   │
│ └──────────────────────────────────┴───────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

## 2. Authentication Pages

### 2.1 Login Page
```
┌─────────────────────────────────────────────────────────────┐
│                         [Logo]                              │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│                    Welcome Back!                           │
│                                                             │
│              ┌─────────────────────────┐                   │
│              │  Email                  │                   │
│              │  [___________________]  │                   │
│              │                         │                   │
│              │  Password               │                   │
│              │  [___________________]  │                   │
│              │                         │                   │
│              │  □ Remember me          │                   │
│              │                         │                   │
│              │  [    Login    ]        │                   │
│              │                         │                   │
│              │  Forgot Password?       │                   │
│              │                         │                   │
│              │  ─────── OR ─────────   │                   │
│              │                         │                   │
│              │  [Login with Google]    │                   │
│              │  [Login with LinkedIn]  │                   │
│              │                         │                   │
│              │  New user? Sign up      │                   │
│              └─────────────────────────┘                   │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### 2.2 Registration Page
```
┌─────────────────────────────────────────────────────────────┐
│                         [Logo]                              │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│                 Create Your Account                        │
│                                                             │
│         I want to:  [Hire Talent] [Find Jobs]             │
│                                                             │
│              ┌─────────────────────────┐                   │
│              │  Full Name              │                   │
│              │  [___________________]  │                   │
│              │                         │                   │
│              │  Email                  │                   │
│              │  [___________________]  │                   │
│              │                         │                   │
│              │  Mobile Number          │                   │
│              │  [___________________]  │                   │
│              │                         │                   │
│              │  Password               │                   │
│              │  [___________________]  │                   │
│              │                         │                   │
│              │  Confirm Password       │                   │
│              │  [___________________]  │                   │
│              │                         │                   │
│              │  □ I agree to Terms     │                   │
│              │                         │                   │
│              │  [    Sign Up    ]      │                   │
│              │                         │                   │
│              │  Have account? Login    │                   │
│              └─────────────────────────┘                   │
└─────────────────────────────────────────────────────────────┘
```

## 3. Admin Dashboard

### 3.1 Admin Dashboard Overview
```
┌─────────────────────────────────────────────────────────────┐
│ Admin Panel     [Search]              [Notifications] [User]│
├────────┬────────────────────────────────────────────────────┤
│        │                 Dashboard                          │
│ ≡ Menu │  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐ │
│        │  │  Users  │ │  Jobs   │ │ Projects│ │ Revenue │ │
│ □ Dash │  │  5,234  │ │  1,023  │ │   342   │ │ $45.2K  │ │
│        │  └─────────┘ └─────────┘ └─────────┘ └─────────┘ │
│ □ Users│                                                    │
│        │  Recent Activities          User Growth Chart      │
│ □ Jobs │  ┌──────────────────┐     ┌────────────────────┐ │
│        │  │ • New user signed│     │     📈 Graph       │ │
│ □ Proj │  │ • Job posted     │     │                    │ │
│        │  │ • Payment received│     └────────────────────┘ │
│ □ Comp │  └──────────────────┘                             │
│        │                                                    │
│ □ Subs │  Pending Approvals                                │
│        │  ┌────────────────────────────────────────────┐   │
│ □ Sett │  │ Job Title | Company | Action               │   │
│        │  │ Developer | ABC Co  | [Approve] [Reject]   │   │
│ □ Repo │  └────────────────────────────────────────────┘   │
└────────┴────────────────────────────────────────────────────┘
```

### 3.2 User Management Page
```
┌─────────────────────────────────────────────────────────────┐
│ Admin Panel > User Management                               │
├─────────────────────────────────────────────────────────────┤
│ [Add User] [Import CSV] [Export]     [Search] [Filter ▼]   │
├─────────────────────────────────────────────────────────────┤
│ ┌──────────────────────────────────────────────────────┐   │
│ │ □ | Name | Email | Role | Status | Actions           │   │
│ ├──────────────────────────────────────────────────────┤   │
│ │ □ | John Doe | john@email | Candidate | Active | ⋮   │   │
│ │ □ | Jane Co | jane@company | Company | Active | ⋮    │   │
│ │ □ | Bob Smith | bob@email | Candidate | Inactive | ⋮ │   │
│ └──────────────────────────────────────────────────────┘   │
│                                                             │
│ Showing 1-10 of 5,234  [<] [1] [2] [3] ... [524] [>]      │
└─────────────────────────────────────────────────────────────┘
```

## 4. Company Dashboard

### 4.1 Company Dashboard Overview
```
┌─────────────────────────────────────────────────────────────┐
│ Company Dashboard            [Post Job]    [Profile] [User] │
├────────┬────────────────────────────────────────────────────┤
│        │              Dashboard Overview                    │
│ ≡ Menu │  ┌──────────┐ ┌──────────┐ ┌──────────┐         │
│        │  │ Active   │ │Applications│ │ Views    │         │
│ □ Dash │  │ Jobs: 5  │ │    142     │ │  3,421   │         │
│        │  └──────────┘ └──────────┘ └──────────┘         │
│ □ Jobs │                                                    │
│        │  Active Job Postings                              │
│ □ Apps │  ┌────────────────────────────────────────────┐   │
│        │  │ Job Title | Applications | Status | Action │   │
│ □ Cand │  │ Developer |     23      | Active | Edit ⋮  │   │
│        │  │ Designer  |     15      | Active | Edit ⋮  │   │
│ □ Proj │  └────────────────────────────────────────────┘   │
│        │                                                    │
│ □ Subs │  Recent Applications                              │
│        │  ┌────────────────────────────────────────────┐   │
│ □ Prof │  │ [Photo] John Doe                           │   │
│        │  │ Applied for: Senior Developer              │   │
│ □ Bill │  │ 2 hours ago | [View] [Shortlist] [Reject] │   │
│        │  └────────────────────────────────────────────┘   │
└────────┴────────────────────────────────────────────────────┘
```

### 4.2 Post Job Page
```
┌─────────────────────────────────────────────────────────────┐
│ Company Dashboard > Post New Job                            │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ Job Information                                            │
│ ┌─────────────────────────────────────────────────────┐   │
│ │ Job Title *                                         │   │
│ │ [_____________________________________________]     │   │
│ │                                                     │   │
│ │ Job Type *              Location *                  │   │
│ │ [Select Type ▼]         [Enter Location]           │   │
│ │                                                     │   │
│ │ Salary Range                                        │   │
│ │ [Min $] - [Max $]       [Currency ▼]               │   │
│ │                                                     │   │
│ │ Job Description *                                   │   │
│ │ [Rich Text Editor                              ]    │   │
│ │ [                                              ]    │   │
│ │ [                                              ]    │   │
│ │                                                     │   │
│ │ Requirements *                                      │   │
│ │ [Rich Text Editor                              ]    │   │
│ │                                                     │   │
│ │ Skills Required                                     │   │
│ │ [+ Add Skill] React Node.js MongoDB               │   │
│ │                                                     │   │
│ │ Application Deadline                                │   │
│ │ [Date Picker]                                      │   │
│ │                                                     │   │
│ │ Listing Type                                        │   │
│ │ ○ Normal ○ Highlighted ○ Featured                  │   │
│ │                                                     │   │
│ │ [Save as Draft]  [Preview]  [Publish Job]          │   │
│ └─────────────────────────────────────────────────────┐   │
└─────────────────────────────────────────────────────────────┘
```

## 5. Candidate Dashboard

### 5.1 Candidate Dashboard Overview
```
┌─────────────────────────────────────────────────────────────┐
│ Candidate Dashboard                         [Profile] [User]│
├────────┬────────────────────────────────────────────────────┤
│        │              My Dashboard                          │
│ ≡ Menu │  Profile Completion: [████████░░] 80%             │
│        │                                                    │
│ □ Dash │  ┌──────────┐ ┌──────────┐ ┌──────────┐         │
│        │  │Applications│ │ Profile  │ │ Bookmarks│         │
│ □ Jobs │  │    12     │ │ Views: 45│ │    8     │         │
│        │  └──────────┘ └──────────┘ └──────────┘         │
│ □ Apps │                                                    │
│        │  Recommended Jobs                                 │
│ □ Prof │  ┌────────────────────────────────────────────┐   │
│        │  │ Senior Developer at TechCorp               │   │
│ □ Book │  │ San Francisco | $120k-150k                 │   │
│        │  │ Match: 92% | [View] [Quick Apply]          │   │
│ □ Sett │  └────────────────────────────────────────────┘   │
│        │                                                    │
│        │  Application Status                              │
│        │  ┌────────────────────────────────────────────┐   │
│        │  │ Job Title | Company | Status | Date        │   │
│        │  │ Developer | ABC Co  | Review | 2 days ago  │   │
│        │  │ Designer  | XYZ Inc | Applied| 5 days ago  │   │
│        │  └────────────────────────────────────────────┘   │
└────────┴────────────────────────────────────────────────────┘
```

### 5.2 Profile Management Page
```
┌─────────────────────────────────────────────────────────────┐
│ Candidate Dashboard > My Profile                            │
├─────────────────────────────────────────────────────────────┤
│ [Personal] [Experience] [Education] [Skills] [Resume]       │
├─────────────────────────────────────────────────────────────┤
│ Personal Information                                        │
│ ┌─────────────────────────────────────────────────────┐   │
│ │ [Photo]  Upload Photo                                │   │
│ │                                                       │   │
│ │ First Name *           Last Name *                   │   │
│ │ [________________]     [________________]           │   │
│ │                                                       │   │
│ │ Email *                Mobile *                      │   │
│ │ [________________]     [________________]           │   │
│ │                                                       │   │
│ │ Professional Summary                                 │   │
│ │ [Text Area                                      ]    │   │
│ │ [                                               ]    │   │
│ │                                                       │   │
│ │ Current Location       Willing to Relocate          │   │
│ │ [________________]     □ Yes                        │   │
│ │                                                       │   │
│ │ Expected Salary        Notice Period                │   │
│ │ [________________]     [Select ▼]                   │   │
│ │                                                       │   │
│ │ LinkedIn URL           Portfolio URL                │   │
│ │ [________________]     [________________]           │   │
│ │                                                       │   │
│ │ [Cancel]  [Save Changes]                            │   │
│ └─────────────────────────────────────────────────────┐   │
└─────────────────────────────────────────────────────────────┘
```

### 5.3 Job Application Page
```
┌─────────────────────────────────────────────────────────────┐
│ Apply for: Senior Developer at TechCorp                     │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ Your Profile Information                                   │
│ ┌─────────────────────────────────────────────────────┐   │
│ │ Name: John Doe                                      │   │
│ │ Email: john@email.com                               │   │
│ │ Phone: +1 234 567 8900                              │   │
│ │ [Edit Profile]                                      │   │
│ └─────────────────────────────────────────────────────┘   │
│                                                             │
│ Resume                                                      │
│ ┌─────────────────────────────────────────────────────┐   │
│ │ ○ Use my uploaded resume (resume_2024.pdf)          │   │
│ │ ○ Upload a new resume [Choose File]                 │   │
│ └─────────────────────────────────────────────────────┘   │
│                                                             │
│ Cover Letter (Optional)                                    │
│ ┌─────────────────────────────────────────────────────┐   │
│ │ [Text Area for cover letter                    ]    │   │
│ │ [                                               ]    │   │
│ │ [                                               ]    │   │
│ └─────────────────────────────────────────────────────┘   │
│                                                             │
│ Additional Information                                     │
│ ┌─────────────────────────────────────────────────────┐   │
│ │ How did you hear about this position?               │   │
│ │ [Select ▼]                                          │   │
│ │                                                      │   │
│ │ Are you authorized to work in this location?        │   │
│ │ ○ Yes  ○ No                                         │   │
│ └─────────────────────────────────────────────────────┘   │
│                                                             │
│ [Cancel]  [Submit Application]                             │
└─────────────────────────────────────────────────────────────┘
```

## 6. Mobile Responsive Layouts

### 6.1 Mobile Navigation
```
┌─────────────────┐
│ ≡  Logo    🔍 👤│
├─────────────────┤
│ Active Drawer:  │
│ ┌─────────────┐ │
│ │ × Close     │ │
│ │             │ │
│ │ Dashboard   │ │
│ │ Jobs        │ │
│ │ Applications│ │
│ │ Profile     │ │
│ │ Settings    │ │
│ │ Logout      │ │
│ └─────────────┘ │
└─────────────────┘
```

### 6.2 Mobile Job Card
```
┌─────────────────┐
│ Job Title       │
│ Company Name    │
│ 📍 Location     │
│ 💰 Salary       │
│                 │
│ [Save] [Apply]  │
└─────────────────┘
```

### 6.3 Mobile Form Layout
```
┌─────────────────┐
│ Form Title      │
├─────────────────┤
│ Label           │
│ [___________]   │
│                 │
│ Label           │
│ [___________]   │
│                 │
│ Label           │
│ [Select ▼]      │
│                 │
│ [Full Width Btn]│
└─────────────────┘
```

## 7. Component States

### 7.1 Button States
- Default: Normal appearance
- Hover: Slight color change, cursor pointer
- Active: Pressed appearance
- Disabled: Grayed out, cursor not-allowed
- Loading: Spinner icon

### 7.2 Form Field States
- Default: Normal border
- Focus: Blue border with shadow
- Error: Red border with error message
- Success: Green border with checkmark
- Disabled: Gray background

### 7.3 Card States
- Default: Normal appearance
- Hover: Elevated shadow, slight scale
- Selected: Border highlight
- Disabled: Reduced opacity

## 8. Notification Patterns

### 8.1 Success Notification
```
┌─────────────────────────────┐
│ ✓ Success!                  │
│ Your job has been posted.   │
└─────────────────────────────┘
```

### 8.2 Error Notification
```
┌─────────────────────────────┐
│ ⚠ Error                     │
│ Please fill required fields.│
└─────────────────────────────┘
```

### 8.3 Info Notification
```
┌─────────────────────────────┐
│ ℹ Information               │
│ Profile updated successfully│
└─────────────────────────────┘
```