import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["darkButton", "lightButton"]

    connect() {
        this.applyTheme();
    }

    toggleTheme(event) {
        const theme = event.currentTarget.dataset.theme;
        localStorage.setItem('theme', theme);
        this.applyTheme();
    }

    applyTheme() {
        const theme = localStorage.getItem('theme') || 'dark';
        this.setRootTheme(theme);
        this.updateButtonState();
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

    updateButtonState() {
        const theme = localStorage.getItem('theme') || 'light';
        const darkButtons = document.querySelectorAll('[data-themes-target="darkButton"]');
        const lightButtons = document.querySelectorAll('[data-themes-target="lightButton"]');

        if (theme === 'dark') {
            darkButtons.forEach(button => button.classList.add('inactive'));
            lightButtons.forEach(button => button.classList.remove('inactive'));
        } else {
            lightButtons.forEach(button => button.classList.add('inactive'));
            darkButtons.forEach(button => button.classList.remove('inactive'));
        }
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
