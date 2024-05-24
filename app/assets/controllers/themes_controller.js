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
        // Apply the theme variables to the :root element
        this.setRootTheme(theme);
        // Update the state of the theme toggle buttons
        this.updateButtonState();
    }

    setRootTheme(theme) {
        const root = document.documentElement;

        if (theme === 'dark') {
            root.style.setProperty('--color-primary', '#0a111f');
            root.style.setProperty('--color-secondary', '#0f192e');
            root.style.setProperty('--color-tertiary', '#1c263c');
            root.style.setProperty('--color-text', '#EAEAEA');

            root.style.setProperty('--color-primary-r', 10);
            root.style.setProperty('--color-primary-g', 17);
            root.style.setProperty('--color-primary-b', 31);
            root.style.setProperty('--color-secondary-r', 15);
            root.style.setProperty('--color-secondary-g', 25);
            root.style.setProperty('--color-secondary-b', 46);
            root.style.setProperty('--color-tertiary-r', 28);
            root.style.setProperty('--color-tertiary-g', 38);
            root.style.setProperty('--color-tertiary-b', 60);
            root.style.setProperty('--color-text-r', 234);
            root.style.setProperty('--color-text-g', 234);
            root.style.setProperty('--color-text-b', 234);
        } else {
            root.style.setProperty('--color-primary', '#e4e5f1');
            root.style.setProperty('--color-secondary', '#d2d3db');
            root.style.setProperty('--color-tertiary', '#9394a5');
            root.style.setProperty('--color-text', '#1c263c');

            root.style.setProperty('--color-primary-r', 228);
            root.style.setProperty('--color-primary-g', 229);
            root.style.setProperty('--color-primary-b', 241);
            root.style.setProperty('--color-secondary-r', 210);
            root.style.setProperty('--color-secondary-g', 211);
            root.style.setProperty('--color-secondary-b', 219);
            root.style.setProperty('--color-tertiary-r', 147);
            root.style.setProperty('--color-tertiary-g', 148);
            root.style.setProperty('--color-tertiary-b', 165);
            root.style.setProperty('--color-text-r', 28);
            root.style.setProperty('--color-text-g', 38);
            root.style.setProperty('--color-text-b', 60);
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
}
