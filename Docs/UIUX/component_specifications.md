# Component Specifications

## 1. Navigation Components

### 1.1 Primary Navigation Header
```vue
<template>
  <nav class="primary-nav">
    <div class="nav-container">
      <div class="nav-logo">
        <img src="/logo.svg" alt="Logo" />
      </div>
      <ul class="nav-menu">
        <li><a href="/jobs">Jobs</a></li>
        <li><a href="/projects">Projects</a></li>
        <li><a href="/companies">Companies</a></li>
      </ul>
      <div class="nav-actions">
        <button class="btn-secondary">Login</button>
        <button class="btn-primary">Sign Up</button>
      </div>
    </div>
  </nav>
</template>
```

**Properties:**
- `isAuthenticated`: Boolean - Shows user menu vs login/signup
- `userRole`: String - Determines menu items
- `notifications`: Number - Badge count
- `mobileMenuOpen`: Boolean - Mobile menu state

**Events:**
- `toggleMobileMenu`: Toggle mobile menu
- `logout`: User logout action
- `navigateTo`: Navigation event

### 1.2 Sidebar Navigation
```vue
<template>
  <aside class="sidebar-nav">
    <ul class="sidebar-menu">
      <li v-for="item in menuItems" :key="item.id">
        <a :href="item.path" :class="{ active: item.active }">
          <i :class="item.icon"></i>
          <span>{{ item.label }}</span>
          <span v-if="item.badge" class="badge">{{ item.badge }}</span>
        </a>
      </li>
    </ul>
  </aside>
</template>
```

**Properties:**
- `menuItems`: Array - Menu configuration
- `collapsed`: Boolean - Sidebar collapse state
- `activeRoute`: String - Current active route

### 1.3 Breadcrumb Navigation
```vue
<template>
  <nav class="breadcrumb">
    <ol>
      <li v-for="(crumb, index) in breadcrumbs" :key="index">
        <a v-if="index < breadcrumbs.length - 1" :href="crumb.path">
          {{ crumb.label }}
        </a>
        <span v-else>{{ crumb.label }}</span>
      </li>
    </ol>
  </nav>
</template>
```

**Properties:**
- `breadcrumbs`: Array of {label, path}

## 2. Form Components

### 2.1 Input Field Component
```vue
<template>
  <div class="form-field">
    <label :for="id">{{ label }}<span v-if="required">*</span></label>
    <input
      :id="id"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :disabled="disabled"
      :class="{ error: hasError }"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <span v-if="hasError" class="error-message">{{ errorMessage }}</span>
    <span v-if="helpText" class="help-text">{{ helpText }}</span>
  </div>
</template>
```

**Properties:**
- `id`: String - Field ID
- `label`: String - Field label
- `type`: String - Input type (text, email, password, etc.)
- `modelValue`: Any - v-model value
- `placeholder`: String - Placeholder text
- `required`: Boolean - Required field
- `disabled`: Boolean - Disabled state
- `hasError`: Boolean - Error state
- `errorMessage`: String - Error message
- `helpText`: String - Helper text

**Events:**
- `update:modelValue`: Value update for v-model

### 2.2 Select Dropdown Component
```vue
<template>
  <div class="form-select">
    <label :for="id">{{ label }}<span v-if="required">*</span></label>
    <select
      :id="id"
      :value="modelValue"
      :disabled="disabled"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option value="">{{ placeholder }}</option>
      <option v-for="option in options" :key="option.value" :value="option.value">
        {{ option.label }}
      </option>
    </select>
    <span v-if="hasError" class="error-message">{{ errorMessage }}</span>
  </div>
</template>
```

**Properties:**
- `options`: Array of {label, value}
- `multiple`: Boolean - Multiple selection
- `searchable`: Boolean - Searchable dropdown

### 2.3 Checkbox Component
```vue
<template>
  <div class="form-checkbox">
    <input
      :id="id"
      type="checkbox"
      :checked="modelValue"
      :disabled="disabled"
      @change="$emit('update:modelValue', $event.target.checked)"
    />
    <label :for="id">{{ label }}</label>
  </div>
</template>
```

**Properties:**
- `modelValue`: Boolean - Checked state
- `indeterminate`: Boolean - Indeterminate state

### 2.4 Radio Group Component
```vue
<template>
  <div class="form-radio-group">
    <label>{{ label }}</label>
    <div v-for="option in options" :key="option.value" class="radio-option">
      <input
        :id="`${id}-${option.value}`"
        type="radio"
        :name="id"
        :value="option.value"
        :checked="modelValue === option.value"
        @change="$emit('update:modelValue', option.value)"
      />
      <label :for="`${id}-${option.value}`">{{ option.label }}</label>
    </div>
  </div>
</template>
```

### 2.5 File Upload Component
```vue
<template>
  <div class="file-upload">
    <label>{{ label }}</label>
    <div class="upload-area" @drop="handleDrop" @dragover.prevent>
      <input
        type="file"
        :accept="accept"
        :multiple="multiple"
        @change="handleFileSelect"
        ref="fileInput"
      />
      <div v-if="!files.length" class="upload-prompt">
        <i class="icon-upload"></i>
        <p>Drag & drop files or <button @click="$refs.fileInput.click()">browse</button></p>
      </div>
      <div v-else class="file-list">
        <div v-for="file in files" :key="file.name" class="file-item">
          <span>{{ file.name }}</span>
          <button @click="removeFile(file)">×</button>
        </div>
      </div>
    </div>
  </div>
</template>
```

**Properties:**
- `accept`: String - Accepted file types
- `multiple`: Boolean - Multiple files
- `maxSize`: Number - Max file size in bytes
- `maxFiles`: Number - Max number of files

**Events:**
- `filesSelected`: Files selected
- `fileRemoved`: File removed
- `uploadProgress`: Upload progress

## 3. Display Components

### 3.1 Card Component
```vue
<template>
  <div class="card" :class="[variant, { clickable, elevated }]">
    <div v-if="$slots.header" class="card-header">
      <slot name="header"></slot>
    </div>
    <div class="card-body">
      <slot></slot>
    </div>
    <div v-if="$slots.footer" class="card-footer">
      <slot name="footer"></slot>
    </div>
  </div>
</template>
```

**Properties:**
- `variant`: String - Card variant (default, bordered, elevated)
- `clickable`: Boolean - Clickable card
- `elevated`: Boolean - Shadow elevation

### 3.2 Job Card Component
```vue
<template>
  <div class="job-card">
    <div class="job-header">
      <img :src="job.companyLogo" :alt="job.companyName" class="company-logo" />
      <div class="job-meta">
        <span class="company-name">{{ job.companyName }}</span>
        <span class="post-date">{{ formatDate(job.postedDate) }}</span>
      </div>
    </div>
    <h3 class="job-title">{{ job.title }}</h3>
    <div class="job-details">
      <span class="location"><i class="icon-location"></i> {{ job.location }}</span>
      <span class="job-type">{{ job.type }}</span>
      <span class="salary">{{ formatSalary(job.salary) }}</span>
    </div>
    <div class="job-tags">
      <span v-for="skill in job.skills" :key="skill" class="skill-tag">
        {{ skill }}
      </span>
    </div>
    <div class="job-actions">
      <button class="btn-icon" @click="saveJob">
        <i :class="job.saved ? 'icon-heart-filled' : 'icon-heart'"></i>
      </button>
      <button class="btn-primary" @click="applyJob">Quick Apply</button>
    </div>
  </div>
</template>
```

**Properties:**
- `job`: Object - Job data
- `showActions`: Boolean - Show action buttons
- `featured`: Boolean - Featured styling

### 3.3 Modal Component
```vue
<template>
  <teleport to="body">
    <transition name="modal">
      <div v-if="visible" class="modal-overlay" @click="closeOnOverlay && close()">
        <div class="modal-container" :class="size" @click.stop>
          <div class="modal-header">
            <h2>{{ title }}</h2>
            <button class="modal-close" @click="close()">×</button>
          </div>
          <div class="modal-body">
            <slot></slot>
          </div>
          <div v-if="$slots.footer" class="modal-footer">
            <slot name="footer"></slot>
          </div>
        </div>
      </div>
    </transition>
  </teleport>
</template>
```

**Properties:**
- `visible`: Boolean - Modal visibility
- `title`: String - Modal title
- `size`: String - Modal size (small, medium, large, full)
- `closeOnOverlay`: Boolean - Close on overlay click
- `closeOnEsc`: Boolean - Close on ESC key

**Events:**
- `close`: Modal close event

### 3.4 Alert Component
```vue
<template>
  <div class="alert" :class="[type, { dismissible }]">
    <i :class="iconClass"></i>
    <div class="alert-content">
      <strong v-if="title">{{ title }}</strong>
      <p>{{ message }}</p>
    </div>
    <button v-if="dismissible" class="alert-close" @click="$emit('dismiss')">×</button>
  </div>
</template>
```

**Properties:**
- `type`: String - Alert type (success, warning, error, info)
- `title`: String - Alert title
- `message`: String - Alert message
- `dismissible`: Boolean - Can be dismissed
- `autoClose`: Number - Auto close after milliseconds

### 3.5 Badge Component
```vue
<template>
  <span class="badge" :class="[variant, size]">
    <slot></slot>
    <button v-if="removable" class="badge-remove" @click="$emit('remove')">×</button>
  </span>
</template>
```

**Properties:**
- `variant`: String - Badge variant (primary, success, warning, danger)
- `size`: String - Badge size (small, medium, large)
- `removable`: Boolean - Show remove button

## 4. Data Display Components

### 4.1 Table Component
```vue
<template>
  <div class="table-wrapper">
    <table class="data-table">
      <thead>
        <tr>
          <th v-for="column in columns" :key="column.key" @click="sort(column.key)">
            {{ column.label }}
            <i v-if="column.sortable" :class="getSortIcon(column.key)"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in sortedData" :key="row.id">
          <td v-for="column in columns" :key="column.key">
            <slot :name="`cell-${column.key}`" :row="row">
              {{ row[column.key] }}
            </slot>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="table-footer">
      <pagination :total="total" :page="page" @change="changePage" />
    </div>
  </div>
</template>
```

**Properties:**
- `columns`: Array - Column configuration
- `data`: Array - Table data
- `sortable`: Boolean - Enable sorting
- `selectable`: Boolean - Row selection
- `loading`: Boolean - Loading state

### 4.2 Pagination Component
```vue
<template>
  <div class="pagination">
    <button :disabled="currentPage === 1" @click="goToPage(currentPage - 1)">
      Previous
    </button>
    <button
      v-for="page in visiblePages"
      :key="page"
      :class="{ active: page === currentPage }"
      @click="goToPage(page)"
    >
      {{ page }}
    </button>
    <button :disabled="currentPage === totalPages" @click="goToPage(currentPage + 1)">
      Next
    </button>
  </div>
</template>
```

**Properties:**
- `currentPage`: Number - Current page
- `totalPages`: Number - Total pages
- `visibleRange`: Number - Visible page range

### 4.3 Tabs Component
```vue
<template>
  <div class="tabs">
    <div class="tab-headers">
      <button
        v-for="tab in tabs"
        :key="tab.id"
        :class="{ active: tab.id === activeTab }"
        @click="activeTab = tab.id"
      >
        {{ tab.label }}
        <span v-if="tab.badge" class="tab-badge">{{ tab.badge }}</span>
      </button>
    </div>
    <div class="tab-content">
      <div v-for="tab in tabs" :key="tab.id" v-show="tab.id === activeTab">
        <slot :name="tab.id"></slot>
      </div>
    </div>
  </div>
</template>
```

**Properties:**
- `tabs`: Array - Tab configuration
- `defaultTab`: String - Default active tab
- `variant`: String - Tab style variant

## 5. Feedback Components

### 5.1 Loading Spinner
```vue
<template>
  <div class="spinner" :class="size">
    <div class="spinner-circle"></div>
    <p v-if="text" class="spinner-text">{{ text }}</p>
  </div>
</template>
```

**Properties:**
- `size`: String - Spinner size (small, medium, large)
- `text`: String - Loading text
- `overlay`: Boolean - Show with overlay

### 5.2 Progress Bar
```vue
<template>
  <div class="progress-bar">
    <div class="progress-track">
      <div class="progress-fill" :style="{ width: percentage + '%' }">
        <span v-if="showLabel" class="progress-label">{{ percentage }}%</span>
      </div>
    </div>
  </div>
</template>
```

**Properties:**
- `value`: Number - Current value
- `max`: Number - Maximum value
- `showLabel`: Boolean - Show percentage label
- `variant`: String - Color variant

### 5.3 Toast Notification
```vue
<template>
  <transition-group name="toast" tag="div" class="toast-container">
    <div
      v-for="toast in toasts"
      :key="toast.id"
      class="toast"
      :class="toast.type"
    >
      <i :class="getIcon(toast.type)"></i>
      <div class="toast-content">
        <strong>{{ toast.title }}</strong>
        <p>{{ toast.message }}</p>
      </div>
      <button class="toast-close" @click="removeToast(toast.id)">×</button>
      <div v-if="toast.progress" class="toast-progress" :style="{ width: toast.progress + '%' }"></div>
    </div>
  </transition-group>
</template>
```

**Properties:**
- `position`: String - Toast position
- `duration`: Number - Auto-dismiss duration

## 6. Interactive Components

### 6.1 Dropdown Menu
```vue
<template>
  <div class="dropdown" v-click-outside="closeDropdown">
    <button class="dropdown-trigger" @click="toggleDropdown">
      {{ triggerText }}
      <i class="icon-chevron-down"></i>
    </button>
    <transition name="dropdown">
      <div v-if="isOpen" class="dropdown-menu" :class="alignment">
        <a
          v-for="item in items"
          :key="item.id"
          class="dropdown-item"
          :class="{ active: item.active, disabled: item.disabled }"
          @click="selectItem(item)"
        >
          <i v-if="item.icon" :class="item.icon"></i>
          {{ item.label }}
        </a>
      </div>
    </transition>
  </div>
</template>
```

**Properties:**
- `items`: Array - Menu items
- `alignment`: String - Menu alignment (left, right, center)
- `closeOnSelect`: Boolean - Close on item selection

### 6.2 Autocomplete Component
```vue
<template>
  <div class="autocomplete">
    <input
      v-model="query"
      @input="search"
      @focus="showSuggestions = true"
      :placeholder="placeholder"
    />
    <div v-if="showSuggestions && suggestions.length" class="suggestions">
      <div
        v-for="suggestion in suggestions"
        :key="suggestion.id"
        class="suggestion-item"
        @click="selectSuggestion(suggestion)"
      >
        <span v-html="highlightMatch(suggestion.label)"></span>
      </div>
    </div>
  </div>
</template>
```

**Properties:**
- `suggestions`: Array - Suggestion items
- `minChars`: Number - Minimum characters to trigger
- `debounce`: Number - Debounce delay

### 6.3 Date Picker Component
```vue
<template>
  <div class="date-picker">
    <input
      :value="formattedDate"
      @click="showCalendar = true"
      :placeholder="placeholder"
      readonly
    />
    <div v-if="showCalendar" class="calendar-popup">
      <!-- Calendar implementation -->
    </div>
  </div>
</template>
```

**Properties:**
- `modelValue`: Date - Selected date
- `minDate`: Date - Minimum selectable date
- `maxDate`: Date - Maximum selectable date
- `format`: String - Date format

## 7. Layout Components

### 7.1 Grid Component
```vue
<template>
  <div class="grid" :class="`cols-${columns}`" :style="{ gap: gap + 'px' }">
    <slot></slot>
  </div>
</template>
```

**Properties:**
- `columns`: Number - Number of columns
- `gap`: Number - Gap between items
- `responsive`: Boolean - Responsive columns

### 7.2 Container Component
```vue
<template>
  <div class="container" :class="[size, { fluid }]">
    <slot></slot>
  </div>
</template>
```

**Properties:**
- `size`: String - Container size (small, medium, large)
- `fluid`: Boolean - Full width container

### 7.3 Sidebar Layout
```vue
<template>
  <div class="layout-sidebar">
    <aside class="sidebar" :class="{ collapsed }">
      <slot name="sidebar"></slot>
    </aside>
    <main class="main-content">
      <slot></slot>
    </main>
  </div>
</template>
```

**Properties:**
- `sidebarWidth`: String - Sidebar width
- `collapsible`: Boolean - Can collapse sidebar
- `collapsed`: Boolean - Sidebar collapsed state

## 8. Utility Components

### 8.1 Avatar Component
```vue
<template>
  <div class="avatar" :class="[size, { online: showStatus && isOnline }]">
    <img v-if="src" :src="src" :alt="alt" />
    <span v-else class="avatar-initials">{{ initials }}</span>
    <span v-if="showStatus" class="avatar-status"></span>
  </div>
</template>
```

**Properties:**
- `src`: String - Image source
- `alt`: String - Alt text
- `size`: String - Avatar size
- `showStatus`: Boolean - Show online status

### 8.2 Chip Component
```vue
<template>
  <div class="chip" :class="[variant, { selected, deletable }]">
    <img v-if="avatar" :src="avatar" class="chip-avatar" />
    <span class="chip-label">{{ label }}</span>
    <button v-if="deletable" class="chip-delete" @click="$emit('delete')">×</button>
  </div>
</template>
```

**Properties:**
- `label`: String - Chip label
- `avatar`: String - Avatar image
- `selected`: Boolean - Selected state
- `deletable`: Boolean - Show delete button

### 8.3 Tooltip Component
```vue
<template>
  <div class="tooltip-wrapper">
    <div ref="trigger" @mouseenter="show" @mouseleave="hide">
      <slot></slot>
    </div>
    <teleport to="body">
      <transition name="tooltip">
        <div v-if="visible" class="tooltip" :class="position" :style="tooltipStyle">
          {{ content }}
        </div>
      </transition>
    </teleport>
  </div>
</template>
```

**Properties:**
- `content`: String - Tooltip content
- `position`: String - Tooltip position (top, bottom, left, right)
- `delay`: Number - Show delay in ms