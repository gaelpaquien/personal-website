import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["darkButton", "lightButton"]

    connect() {
        this.syncThemeFromDOM();
        this.applyTheme();
    }

    toggleTheme(event) {
        const theme = event.currentTarget.dataset.theme;
        const currentTheme = localStorage.getItem('theme') || 'dark';

        if (theme === currentTheme) {
            return;
        }

        localStorage.setItem('theme', theme);
        this.applyTheme();
    }

    syncThemeFromDOM() {
        const root = document.documentElement;
        const isDark = root.classList.contains('theme-dark');
        const currentTheme = isDark ? 'dark' : 'light';

        const storedTheme = localStorage.getItem('theme');
        if (storedTheme !== currentTheme) {
            localStorage.setItem('theme', currentTheme);
        }
    }

    applyTheme() {
        const theme = localStorage.getItem('theme') || 'dark';
        this.setRootTheme(theme);
        this.updateButtonState(theme);
        this.updateThemeColor(theme);
    }

    setRootTheme(theme) {
        const root = document.documentElement;

        if (theme === 'dark') {
            root.classList.remove('theme-light');
            root.classList.add('theme-dark');
        } else {
            root.classList.remove('theme-dark');
            root.classList.add('theme-light');
        }
    }

    updateButtonState(theme) {
        requestAnimationFrame(() => {
            const darkButtons = document.querySelectorAll('[data-themes-target="darkButton"]');
            const lightButtons = document.querySelectorAll('[data-themes-target="lightButton"]');

            [...darkButtons, ...lightButtons].forEach(button => {
                button.classList.remove('inactive');
            });

            if (theme === 'dark') {
                darkButtons.forEach(button => button.classList.add('inactive'));
            } else {
                lightButtons.forEach(button => button.classList.add('inactive'));
            }
        });
    }

    updateThemeColor(theme) {
        const themeColors = {
            dark: '#201d1e',
            light: '#F9F7F7'
        };

        const themeColorMetaTag = document.querySelector('meta[name="theme-color"]');
        if (themeColorMetaTag) {
            themeColorMetaTag.setAttribute('content', themeColors[theme]);
        }
    }
}