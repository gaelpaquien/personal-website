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
        const theme = localStorage.getItem('theme') || 'light';
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
        if (theme === 'dark') {
            this.darkButtonTarget.classList.add('inactive');
            this.lightButtonTarget.classList.remove('inactive');
        } else {
            this.lightButtonTarget.classList.add('inactive');
            this.darkButtonTarget.classList.remove('inactive');
        }
    }

    updateThemeColor(theme) {
        const themeColors = {
            dark: '#061128',
            light: '#e4e5f1'
        };

        const themeColorMetaTag = document.querySelector('meta[name="theme-color"]');

        if (themeColorMetaTag) {
            themeColorMetaTag.setAttribute('content', themeColors[theme]);
        }
    }
}
