# Admin Job Management Module

## Overview
The Job Management module provides comprehensive tools for moderating, managing, and analyzing job postings. This module implements requirements REQ-ADM-005 and job-related analytics features.

## Features

### 1. Job Listing & Advanced Filtering
- **Endpoint**: `GET /admin/jobs`
- **Features**:
  - Paginated job listing (50 per page)
  - Status-based filtering (draft, active, inactive, expired, filled)
  - Visibility filtering (normal, highlighted, featured)
  - Company filtering
  - Job type filtering
  - Remote job filtering
  - Salary range filtering
  - Location-based filtering
  - Date range filtering
  - Advanced search functionality

### 2. Job Details & Management
- **Endpoint**: `GET /admin/jobs/{id}`
- **Features**:
  - Complete job details view
  - Application statistics
  - Performance metrics
  - Application trends analysis
  - Recent applications monitoring

### 3. Job Information Updates
- **Endpoint**: `PUT /admin/jobs/{id}`
- **Features**:
  - Update job information
  - Skills management
  - Requirements editing
  - Salary and experience range updates
  - Status and visibility control

### 4. Job Status Management
- **Change Status**: `POST /admin/jobs/{id}/change-status`
- **Change Visibility**: `POST /admin/jobs/{id}/change-visibility`
- **Features**:
  - Status management (draft, active, inactive, expired, filled)
  - Visibility control (normal, highlighted, featured)
  - Automatic application handling
  - Activity logging

### 5. Analytics & Performance Tracking
- **Analytics**: `GET /admin/jobs/{id}/analytics`
- **Statistics**: `GET /admin/jobs/statistics`
- **Features**:
  - Job performance metrics
  - Application conversion rates
  - Response time analysis
  - Candidate insights
  - Daily application trends

## Key Methods

### `index(Request $request)`
- Displays filtered job listings
- Comprehensive filtering options
- Statistics overview

### `show(Job $job)`
- Detailed job view
- Application statistics
- Performance analytics

### `update(Request $request, Job $job)`
- Updates job information
- Skills synchronization
- Publication timestamp management

### `changeStatus(Request $request, Job $job)`
- Changes job status
- Handles related applications
- Activity logging

### `analytics(Job $job)`
- Performance metrics calculation
- Application analysis
- Candidate insights generation

---

**Last Updated**: 2025-08-15  
**Version**: 1.0  
**Status**: Implemented  
**Dependencies**: Job, Company, JobType, Skill, Application models