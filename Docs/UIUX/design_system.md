# Design System Specification

## 1. Brand Identity

### 1.1 Color Palette

#### Primary Colors
- **Primary Blue:** #2563EB (Main brand color for CTAs and important elements)
- **Primary Dark:** #1E40AF (Hover states and emphasis)
- **Primary Light:** #60A5FA (Backgrounds and subtle highlights)

#### Secondary Colors
- **Success Green:** #10B981 (Success messages, completed states)
- **Warning Yellow:** #F59E0B (Warnings, pending states)
- **Error Red:** #EF4444 (Error messages, critical actions)
- **Info Cyan:** #06B6D4 (Informational messages)

#### Neutral Colors
- **Gray 900:** #111827 (Primary text)
- **Gray 700:** #374151 (Secondary text)
- **Gray 500:** #6B7280 (Placeholder text)
- **Gray 300:** #D1D5DB (Borders)
- **Gray 100:** #F3F4F6 (Backgrounds)
- **White:** #FFFFFF (Cards, primary background)

#### Dark Mode Colors
- **Dark Background:** #0F172A
- **Dark Surface:** #1E293B
- **Dark Border:** #334155
- **Dark Text Primary:** #F1F5F9
- **Dark Text Secondary:** #CBD5E1

### 1.2 Typography

#### Font Families
- **Primary Font:** Inter (Sans-serif)
  - Headings and body text
  - Fallback: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif

- **Monospace Font:** "Fira Code", "Courier New"
  - Code snippets, technical content

#### Font Sizes
- **Heading 1:** 48px / 3rem (Line height: 1.2)
- **Heading 2:** 36px / 2.25rem (Line height: 1.3)
- **Heading 3:** 30px / 1.875rem (Line height: 1.3)
- **Heading 4:** 24px / 1.5rem (Line height: 1.4)
- **Heading 5:** 20px / 1.25rem (Line height: 1.4)
- **Heading 6:** 18px / 1.125rem (Line height: 1.5)
- **Body Large:** 18px / 1.125rem (Line height: 1.75)
- **Body Regular:** 16px / 1rem (Line height: 1.75)
- **Body Small:** 14px / 0.875rem (Line height: 1.75)
- **Caption:** 12px / 0.75rem (Line height: 1.5)

#### Font Weights
- **Light:** 300 (Subtle text)
- **Regular:** 400 (Body text)
- **Medium:** 500 (Emphasis)
- **Semibold:** 600 (Subheadings)
- **Bold:** 700 (Headings)

## 2. Spacing System

### 2.1 Base Unit
- Base unit: 4px
- All spacing values are multiples of the base unit

### 2.2 Spacing Scale
- **xs:** 4px (0.25rem)
- **sm:** 8px (0.5rem)
- **md:** 16px (1rem)
- **lg:** 24px (1.5rem)
- **xl:** 32px (2rem)
- **2xl:** 48px (3rem)
- **3xl:** 64px (4rem)
- **4xl:** 96px (6rem)

### 2.3 Component Spacing
- **Button Padding:** 12px 24px (vertical horizontal)
- **Card Padding:** 24px
- **Form Field Spacing:** 16px between fields
- **Section Spacing:** 64px between major sections
- **Grid Gutter:** 24px

## 3. Layout Grid

### 3.1 Desktop Grid (≥1280px)
- **Columns:** 12
- **Gutter:** 24px
- **Margin:** 64px
- **Max Container Width:** 1280px

### 3.2 Tablet Grid (768px - 1279px)
- **Columns:** 8
- **Gutter:** 20px
- **Margin:** 32px

### 3.3 Mobile Grid (<768px)
- **Columns:** 4
- **Gutter:** 16px
- **Margin:** 16px

## 4. Component Library

### 4.1 Buttons

#### Primary Button
- Background: Primary Blue (#2563EB)
- Text: White
- Padding: 12px 24px
- Border Radius: 8px
- Font Weight: 600
- Hover: Darken 10%
- Active: Darken 20%
- Disabled: Opacity 50%

#### Secondary Button
- Background: Transparent
- Border: 2px solid Primary Blue
- Text: Primary Blue
- Padding: 10px 22px
- Border Radius: 8px
- Hover: Light blue background

#### Ghost Button
- Background: Transparent
- Text: Gray 700
- Padding: 12px 24px
- Hover: Gray 100 background

#### Button Sizes
- **Small:** Height 32px, Font 14px
- **Medium:** Height 40px, Font 16px
- **Large:** Height 48px, Font 18px

### 4.2 Form Elements

#### Input Fields
- Height: 44px
- Border: 1px solid Gray 300
- Border Radius: 6px
- Padding: 12px 16px
- Font Size: 16px
- Focus: Blue border with shadow
- Error: Red border

#### Select Dropdown
- Same styling as input fields
- Dropdown icon on right
- Custom dropdown menu styling

#### Checkbox & Radio
- Size: 20px × 20px
- Border: 2px solid Gray 400
- Checked: Primary Blue background
- Border Radius: 4px (checkbox), 50% (radio)

#### Textarea
- Min Height: 100px
- Same border and padding as inputs
- Resize: Vertical only

### 4.3 Cards

#### Basic Card
- Background: White
- Border Radius: 12px
- Padding: 24px
- Box Shadow: 0 1px 3px rgba(0,0,0,0.1)
- Hover: Elevated shadow

#### Job Card
- Title: Font size 20px, weight 600
- Company: Font size 16px, gray 600
- Location: Font size 14px, gray 500
- Salary: Font size 16px, weight 500
- Tags: Inline badges
- Apply Button: Primary button, small size

### 4.4 Navigation

#### Header Navigation
- Height: 64px
- Background: White
- Shadow: 0 1px 3px rgba(0,0,0,0.1)
- Logo: Left aligned
- Menu Items: Centered or right aligned
- Mobile: Hamburger menu

#### Sidebar Navigation
- Width: 260px
- Background: White or light gray
- Menu Items: Full width, hover highlight
- Active Item: Blue background, white text
- Icons: 20px × 20px, left of text

### 4.5 Modals

#### Modal Container
- Max Width: 600px (default)
- Background: White
- Border Radius: 16px
- Padding: 32px
- Overlay: Black 50% opacity

#### Modal Header
- Font Size: 24px
- Font Weight: 600
- Margin Bottom: 24px
- Close Button: Top right

### 4.6 Alerts & Notifications

#### Alert Types
- **Success:** Green background, darker green text
- **Warning:** Yellow background, darker yellow text
- **Error:** Red background, darker red text
- **Info:** Blue background, darker blue text

#### Toast Notifications
- Position: Top right
- Width: 360px
- Auto-dismiss: 5 seconds
- Progress bar indicator

### 4.7 Tables

#### Table Design
- Header: Gray 100 background, font weight 600
- Rows: White background, hover gray 50
- Borders: Horizontal only, gray 200
- Padding: 12px 16px per cell
- Responsive: Horizontal scroll on mobile

### 4.8 Badges & Tags

#### Badge Styles
- Padding: 4px 12px
- Border Radius: 16px
- Font Size: 12px
- Font Weight: 500
- Colors: Based on status/type

#### Status Badges
- **Active:** Green background
- **Pending:** Yellow background
- **Inactive:** Gray background
- **Featured:** Blue background
- **Urgent:** Red background

## 5. Icons

### 5.1 Icon Library
- **Primary:** Heroicons or Feather Icons
- **Size Standard:** 20px × 20px
- **Size Small:** 16px × 16px
- **Size Large:** 24px × 24px
- **Stroke Width:** 2px

### 5.2 Common Icons
- Dashboard: Grid
- Jobs: Briefcase
- Projects: Folder
- Applications: Document
- Profile: User
- Settings: Cog
- Notifications: Bell
- Search: Magnifying Glass
- Filter: Funnel
- Close: X
- Edit: Pencil
- Delete: Trash
- Save: Check
- Cancel: X Circle

## 6. Responsive Breakpoints

### 6.1 Breakpoint Values
- **Mobile:** 0 - 767px
- **Tablet:** 768px - 1023px
- **Desktop:** 1024px - 1279px
- **Large Desktop:** 1280px+

### 6.2 Responsive Behaviors
- **Navigation:** Hamburger menu on mobile/tablet
- **Grid:** Column reduction on smaller screens
- **Cards:** Stack vertically on mobile
- **Tables:** Horizontal scroll or card view on mobile
- **Modals:** Full screen on mobile
- **Forms:** Full width inputs on mobile

## 7. Animation & Transitions

### 7.1 Transition Durations
- **Fast:** 150ms (hover effects)
- **Normal:** 250ms (general transitions)
- **Slow:** 350ms (page transitions)

### 7.2 Easing Functions
- **Default:** cubic-bezier(0.4, 0, 0.2, 1)
- **Ease In:** cubic-bezier(0.4, 0, 1, 1)
- **Ease Out:** cubic-bezier(0, 0, 0.2, 1)
- **Ease In Out:** cubic-bezier(0.4, 0, 0.2, 1)

### 7.3 Common Animations
- **Fade In:** Opacity 0 to 1
- **Slide Up:** TranslateY 20px to 0
- **Scale:** Scale 0.95 to 1
- **Loading Spinner:** Rotate 360deg infinite

## 8. Accessibility Guidelines

### 8.1 Color Contrast
- **Normal Text:** 4.5:1 minimum ratio
- **Large Text:** 3:1 minimum ratio
- **UI Components:** 3:1 minimum ratio

### 8.2 Focus States
- Visible focus outline for all interactive elements
- Focus outline: 2px solid blue
- Focus outline offset: 2px

### 8.3 Touch Targets
- Minimum size: 44px × 44px
- Spacing between targets: 8px minimum

### 8.4 Screen Reader Support
- Proper heading hierarchy
- Alt text for images
- ARIA labels for icons
- Form label associations
- Error message associations

## 9. Dark Mode Specifications

### 9.1 Color Inversions
- Backgrounds: Dark blues/grays
- Text: Light grays/whites
- Borders: Darker shades
- Shadows: Reduced or removed

### 9.2 Component Adaptations
- Cards: Dark surface color
- Inputs: Dark background, light text
- Buttons: Adjusted colors for contrast
- Icons: Light colored

## 10. Print Styles

### 10.1 Print Optimizations
- Hide navigation elements
- Remove backgrounds and shadows
- Black text on white background
- Simplified layouts
- Page break controls
- Link URLs displayed