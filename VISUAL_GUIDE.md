# 🎨 Visual Design Guide

## Color Palette

### Primary Colors
```
Blue (Primary):    #4A90E2  - Buttons, links, primary actions
Green (Success):   #50E3C2  - Success messages, positive indicators
Orange (Warning):  #F5A623  - Warnings, important notices
Red (Danger):      #EF4444  - Errors, delete actions
Purple (Info):     #BD10E0  - Information, special features
```

### Neutral Colors
```
Gray-50:   #F9FAFB  - Background
Gray-100:  #F3F4F6  - Light backgrounds
Gray-200:  #E5E7EB  - Borders
Gray-300:  #D1D5DB  - Disabled states
Gray-600:  #4B5563  - Secondary text
Gray-900:  #111827  - Primary text
White:     #FFFFFF  - Cards, modals
```

### Gradient Backgrounds
```
Landing Page: from-blue-50 to-indigo-100
CTA Section:  from-blue-600 to-indigo-600
```

## Typography

### Font Family
```css
Primary: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif
Fallback: 'Apple Color Emoji', 'Segoe UI Emoji'
```

### Font Sizes
```
Heading 1:  3xl (1.875rem / 30px)  - Page titles
Heading 2:  2xl (1.5rem / 24px)    - Section titles
Heading 3:  xl (1.25rem / 20px)    - Card titles
Body:       base (1rem / 16px)     - Regular text
Small:      sm (0.875rem / 14px)   - Helper text
Tiny:       xs (0.75rem / 12px)    - Labels
```

### Font Weights
```
Regular:    400  - Body text
Medium:     500  - Emphasized text
Semibold:   600  - Headings
Bold:       700  - Important headings
```

## Spacing System

### Padding/Margin Scale
```
1:  0.25rem (4px)
2:  0.5rem  (8px)
3:  0.75rem (12px)
4:  1rem    (16px)
6:  1.5rem  (24px)
8:  2rem    (32px)
12: 3rem    (48px)
16: 4rem    (64px)
20: 5rem    (80px)
```

## Border Radius

### Rounded Corners
```
sm:   0.125rem (2px)   - Small elements
md:   0.375rem (6px)   - Default
lg:   0.5rem   (8px)   - Buttons, inputs
xl:   0.75rem  (12px)  - Cards
2xl:  1rem     (16px)  - Large cards
full: 9999px           - Pills, badges
```

## Shadows

### Box Shadows
```
sm:   0 1px 2px 0 rgb(0 0 0 / 0.05)
md:   0 4px 6px -1px rgb(0 0 0 / 0.1)
lg:   0 10px 15px -3px rgb(0 0 0 / 0.1)
xl:   0 20px 25px -5px rgb(0 0 0 / 0.1)
2xl:  0 25px 50px -12px rgb(0 0 0 / 0.25)
```

## Components

### Buttons

#### Primary Button
```html
<button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-lg">
    Button Text
</button>
```

**States:**
- Default: bg-blue-600
- Hover: bg-blue-700
- Active: bg-blue-800
- Disabled: bg-gray-300 cursor-not-allowed

#### Secondary Button
```html
<button class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
    Button Text
</button>
```

#### Danger Button
```html
<button class="px-4 py-2 text-red-600 hover:text-red-900">
    Delete
</button>
```

### Input Fields

#### Text Input
```html
<input type="text" 
    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg 
           focus:ring-blue-500 focus:border-blue-500">
```

**States:**
- Default: border-gray-300
- Focus: ring-blue-500 border-blue-500
- Error: border-red-500
- Disabled: bg-gray-100

### Cards

#### Standard Card
```html
<div class="bg-white rounded-lg shadow p-6">
    <!-- Content -->
</div>
```

#### Hover Card
```html
<div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
    <!-- Content -->
</div>
```

#### Glassmorphism Card
```html
<div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-8">
    <!-- Content -->
</div>
```

### Badges

#### Category Badge
```html
<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
             bg-blue-100 text-blue-800">
    Work
</span>
```

**Colors:**
- Work: bg-blue-100 text-blue-800
- Personal: bg-green-100 text-green-800
- Banking: bg-orange-100 text-orange-800
- Social: bg-purple-100 text-purple-800

### Modals

#### Modal Overlay
```html
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <!-- Modal Content -->
    </div>
</div>
```

### Tables

#### Data Table
```html
<table class="w-full">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Header
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">
                Content
            </td>
        </tr>
    </tbody>
</table>
```

### Icons

#### SVG Icons (Heroicons)
```html
<!-- Lock Icon -->
<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
    </path>
</svg>
```

**Icon Sizes:**
- Small: w-4 h-4 (16px)
- Medium: w-5 h-5 (20px)
- Large: w-8 h-8 (32px)
- XLarge: w-12 h-12 (48px)

## Animations

### Transitions
```css
transition: all 0.3s ease-in-out;
```

**Common Transitions:**
- Button hover: 0.2s
- Card hover: 0.3s
- Modal fade: 0.3s
- Page transitions: 0.5s

### Hover Effects

#### Button Hover
```html
<button class="transform hover:scale-105 transition">
    Hover Me
</button>
```

#### Card Hover
```html
<div class="hover:shadow-xl hover:-translate-y-1 transition">
    Card Content
</div>
```

## Layout

### Container Widths
```
max-w-7xl:  80rem (1280px)  - Main content
max-w-4xl:  56rem (896px)   - Forms, articles
max-w-md:   28rem (448px)   - Modals, cards
```

### Grid System
```html
<!-- 3 Column Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Items -->
</div>

<!-- 2 Column Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Items -->
</div>
```

### Flexbox Layouts
```html
<!-- Centered Content -->
<div class="flex items-center justify-center">
    <!-- Content -->
</div>

<!-- Space Between -->
<div class="flex justify-between items-center">
    <!-- Content -->
</div>
```

## Responsive Breakpoints

```
sm:  640px   - Small tablets
md:  768px   - Tablets
lg:  1024px  - Laptops
xl:  1280px  - Desktops
2xl: 1536px  - Large desktops
```

### Mobile-First Approach
```html
<!-- Stack on mobile, row on desktop -->
<div class="flex flex-col md:flex-row">
    <!-- Content -->
</div>

<!-- Full width on mobile, half on desktop -->
<div class="w-full md:w-1/2">
    <!-- Content -->
</div>
```

## Page Layouts

### Landing Page Structure
```
Header (Navigation)
  ├── Logo
  ├── Login Link
  └── Register Button

Hero Section
  ├── Headline
  ├── Subheadline
  └── CTA Buttons

Features Section
  └── 3-Column Grid
      ├── Feature Card 1
      ├── Feature Card 2
      └── Feature Card 3

Security Notice
  └── Centered Card

CTA Section
  └── Gradient Background

Footer
  └── Copyright & Links
```

### Dashboard Layout
```
Sidebar (Fixed Left)
  ├── Logo
  ├── Navigation Links
  └── Logout Button

Main Content (Right)
  ├── Header
  │   ├── Page Title
  │   └── Add Button
  ├── Statistics Cards
  │   ├── Total Credentials
  │   ├── Categories
  │   └── Favorites
  └── Credentials Table
      ├── Table Header
      ├── Table Rows
      └── Pagination
```

### Settings Page Layout
```
2-Column Grid
  ├── Left Column
  │   ├── Update Profile Card
  │   └── 2FA Card
  └── Right Column
      ├── Change Password Card
      └── Activity Log Card
```

## Best Practices

### Accessibility
- Use semantic HTML
- Provide alt text for images
- Ensure sufficient color contrast
- Support keyboard navigation
- Use ARIA labels where needed

### Performance
- Minimize CSS/JS bundle size
- Use lazy loading for images
- Optimize SVG icons
- Leverage browser caching
- Use CDN for assets

### Consistency
- Use design tokens
- Follow spacing system
- Maintain color palette
- Use consistent typography
- Apply uniform border radius

## Dark Mode (Ready to Implement)

### Color Adjustments
```
Background:     bg-gray-900
Cards:          bg-gray-800
Text Primary:   text-gray-100
Text Secondary: text-gray-400
Borders:        border-gray-700
```

### Toggle Implementation
```html
<button onclick="toggleDarkMode()" 
        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
    <!-- Sun/Moon Icon -->
</button>
```

## Print Styles (Future)

```css
@media print {
    .no-print { display: none; }
    body { background: white; }
    .card { box-shadow: none; border: 1px solid #ccc; }
}
```

---

**Design System Version:** 1.0.0
**Last Updated:** February 3, 2026
**Framework:** Tailwind CSS 4.0
