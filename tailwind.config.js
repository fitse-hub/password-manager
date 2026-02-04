/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Primary Palette
        primary: {
          DEFAULT: '#00E5FF',
          50: '#E5FCFF',
          100: '#CCF9FF',
          200: '#99F3FF',
          300: '#66EDFF',
          400: '#33E7FF',
          500: '#00E5FF',
          600: '#00B7CC',
          700: '#008999',
          800: '#005C66',
          900: '#002E33',
        },
        secondary: {
          DEFAULT: '#7CFFB2',
          50: '#F0FFF7',
          100: '#E0FFEF',
          200: '#C2FFDF',
          300: '#A3FFCF',
          400: '#85FFBF',
          500: '#7CFFB2',
          600: '#63CC8E',
          700: '#4A996B',
          800: '#326647',
          900: '#193324',
        },
        warning: {
          DEFAULT: '#FFB020',
          50: '#FFF8E5',
          100: '#FFF1CC',
          200: '#FFE399',
          300: '#FFD566',
          400: '#FFC733',
          500: '#FFB020',
          600: '#CC8D1A',
          700: '#996A13',
          800: '#66470D',
          900: '#332306',
        },
        danger: {
          DEFAULT: '#FF4D4F',
          50: '#FFE5E5',
          100: '#FFCCCC',
          200: '#FF9999',
          300: '#FF6666',
          400: '#FF4D4F',
          500: '#FF3333',
          600: '#CC2929',
          700: '#991F1F',
          800: '#661414',
          900: '#330A0A',
        },
        // Dark Mode Neutrals
        dark: {
          bg: '#0B0F1A',
          surface: '#12172A',
          card: '#161C34',
          border: '#232A4A',
          text: {
            primary: '#E8EBFF',
            secondary: '#9AA3C7',
          }
        },
        // Light Mode Neutrals
        light: {
          bg: '#F8F9FF',
          surface: '#FFFFFF',
          card: '#FAFBFF',
          border: '#E5E7EB',
          text: {
            primary: '#1F2937',
            secondary: '#6B7280',
          }
        }
      },
      fontFamily: {
        sans: ['Inter', 'SF Pro', 'Poppins', 'system-ui', 'sans-serif'],
        mono: ['JetBrains Mono', 'Fira Code', 'monospace'],
      },
      fontSize: {
        'app-title': ['32px', { lineHeight: '1.2', fontWeight: '700' }],
        'section-heading': ['24px', { lineHeight: '1.3', fontWeight: '600' }],
        'card-title': ['18px', { lineHeight: '1.4', fontWeight: '600' }],
        'body': ['16px', { lineHeight: '1.6', fontWeight: '400' }],
        'body-sm': ['14px', { lineHeight: '1.5', fontWeight: '400' }],
        'label': ['12px', { lineHeight: '1.4', fontWeight: '500' }],
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
      },
      borderRadius: {
        'button': '14px',
        'card': '18px',
        'card-lg': '22px',
        'modal': '24px',
        'input': '12px',
      },
      backdropBlur: {
        'glass': '12px',
      },
      boxShadow: {
        'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.1)',
        'card': '0 4px 16px rgba(0, 0, 0, 0.08)',
        'hover': '0 8px 24px rgba(0, 229, 255, 0.15)',
        'modal': '0 24px 48px rgba(0, 0, 0, 0.2)',
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'scale-in': 'scaleIn 0.2s ease-out',
        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        scaleIn: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
        pulseGlow: {
          '0%, 100%': { opacity: '1' },
          '50%': { opacity: '0.6' },
        },
      },
      transitionTimingFunction: {
        'smooth': 'cubic-bezier(0.4, 0, 0.2, 1)',
      },
    },
  },
  plugins: [],
}
