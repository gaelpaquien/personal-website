import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["darkButton", "lightButton"]

    connect() {
        // Apply the theme when the controller connects
        this.applyTheme();
    }

    toggleTheme(event) {
        // Set the theme based on the clicked button's data-theme attribute
        const theme = event.currentTarget.dataset.theme;
        localStorage.setItem('theme', theme);
        this.applyTheme();
    }

    applyTheme() {
        // Retrieve the theme from localStorage or default to 'dark'
        const theme = localStorage.getItem('theme') || 'dark';
        // Apply the theme class to the <html> element
        this.setRootTheme(theme);
        // Update the state of the theme toggle buttons
        this.updateButtonState();
        // Update the theme color meta tag
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
        // Update button states based on the current theme
        const theme = localStorage.getItem('theme') || 'dark';
        if (theme === 'dark') {
            this.darkButtonTarget.classList.add('inactive');
            this.lightButtonTarget.classList.remove('inactive');
        } else {
            this.lightButtonTarget.classList.add('inactive');
            this.darkButtonTarget.classList.remove('inactive');
        }
    }

    updateThemeColor(theme) {
        // Define the primary colors for each theme
        const themeColors = {
            dark: '#061128',
            light: '#e4e5f1'
        };

        // Get the meta tag
        const themeColorMetaTag = document.querySelector('meta[name="theme-color"]');

        // Update the content attribute with the appropriate color
        if (themeColorMetaTag) {
            themeColorMetaTag.setAttribute('content', themeColors[theme]);
        }
    }
}
