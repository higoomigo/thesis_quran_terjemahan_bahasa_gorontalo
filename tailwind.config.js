import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class", // Mengaktifkan Dark Mode berbasis class
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // Skema Warna Material Design 3 (Master)
                "primary-fixed": "#a6f2d1",
                "surface": "#f9f9ff",
                "on-tertiary-container": "#a8d0bc",
                "on-secondary-fixed": "#331200",
                "tertiary": "#1e4334",
                "surface-bright": "#f9f9ff",
                "secondary-container": "#fd8a42",
                "error": "#ba1a1a",
                "tertiary-container": "#365a4a",
                "surface-tint": "#1b6b51",
                "on-tertiary-fixed": "#002115",
                "primary-fixed-dim": "#8bd6b6",
                "on-primary-fixed": "#002116",
                "inverse-surface": "#2a313d",
                "on-primary-container": "#8bd6b7",
                "on-background": "#151c27",
                "background": "#f9f9ff",
                "tertiary-fixed-dim": "#a8cfbc",
                "secondary": "#9b4500",
                "on-primary": "#ffffff",
                "surface-container-low": "#f0f3ff",
                "inverse-primary": "#8bd6b6",
                "on-secondary-container": "#682c00",
                "on-surface": "#151c27",
                "primary-container": "#065f46",
                "on-tertiary": "#ffffff",
                "error-container": "#ffdad6",
                "surface-container-lowest": "#ffffff",
                "on-surface-variant": "#3f4944",
                "primary": "#004532",
                "surface-container-high": "#e2e8f8",
                "secondary-fixed": "#ffdbca",
                "on-error-container": "#93000a",
                "surface-container-highest": "#dce2f3",
                "on-secondary-fixed-variant": "#763300",
                "outline": "#6f7973",
                "on-primary-fixed-variant": "#00513b",
                "on-secondary": "#ffffff",
                "on-error": "#ffffff",
                "tertiary-fixed": "#c3ecd7",
                "surface-dim": "#d3daea",
                "surface-container": "#e7eefe",
                "inverse-on-surface": "#ebf1ff",
                "outline-variant": "#bec9c2",
                "surface-variant": "#dce2f3",
                "secondary-fixed-dim": "#ffb68e",
                "on-tertiary-fixed-variant": "#294e3f",
                "surface-dark": "#1e293b", // Tambahan dari snippet kedua lu
                // Palet Hijau Emerald Khusus
                emerald: {
                    50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0',
                    300: '#6ee7b7', 400: '#34d399', 500: '#10b981',
                    600: '#059669', 700: '#047857', 800: '#065f46',
                    900: '#064e3b', 950: '#022c22',
                },
                // Palet Slate Khusus
                slate: {
                    50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0',
                    300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b',
                    600: '#475569', 700: '#334155', 800: '#1e293b',
                    900: '#0f172a', 950: '#020617',
                }
            },
            borderRadius: { 
                "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" 
            },
            spacing: { 
                "unit": "4px", "xs": "0.25rem", "sm": "0.5rem", "md": "1rem", 
                "lg": "1.5rem", "gutter": "1.5rem", "xl": "2.5rem", "container-max": "1200px" 
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Noto Serif', ...defaultTheme.fontFamily.serif],
                "label-md": ["Inter"], 
                "caption": ["Inter"], 
                "headline-lg": ["Inter"],
                "headline-xl": ["Inter"], 
                "body-reading-translation": ["Inter"], 
                "body-reading-arabic": ["Noto Serif"]
            },
            fontSize: {
                "label-md": ["14px", { "lineHeight": "1.4", "letterSpacing": "0.02em", "fontWeight": "500" }],
                "caption": ["12px", { "lineHeight": "1.4", "fontWeight": "400" }],
                "headline-lg": ["28px", { "lineHeight": "1.3", "fontWeight": "600" }],
                "headline-xl": ["36px", { "lineHeight": "1.2", "fontWeight": "700" }],
                "body-reading-translation": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                "body-reading-arabic": ["32px", { "lineHeight": "2.0", "fontWeight": "400" }]
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/container-queries'),
    ]
};