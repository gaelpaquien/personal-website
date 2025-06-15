import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["frenchButton", "englishButton"]
    static values = {
        defaultLanguage: { type: String, default: 'fr' }
    }

    connect() {
        this.forceSyncLanguage();
        this.applyLanguage();
    }

    toggleLanguage(event) {
        const language = event.currentTarget.dataset.language;
        const currentLanguage = this.getCurrentAppLanguage();

        if (language === currentLanguage) {
            return;
        }

        document.documentElement.lang = language;

        localStorage.setItem('language', language);
        this.updateButtonState(language);
    }

    forceSyncLanguage() {
        const realLanguage = this.getRealCurrentLanguage();

        if (document.documentElement.lang !== realLanguage) {
            document.documentElement.lang = realLanguage;
        }

        localStorage.setItem('language', realLanguage);
    }

    getRealCurrentLanguage() {
        const pathLang = window.location.pathname.startsWith('/fr') ? 'fr' :
            window.location.pathname.startsWith('/en') ? 'en' : null;

        if (pathLang) {
            return pathLang;
        }

        const storedLang = localStorage.getItem('language');
        if (storedLang && ['fr', 'en'].includes(storedLang)) {
            return storedLang;
        }

        return 'fr';
    }

    getCurrentAppLanguage() {
        return this.getRealCurrentLanguage();
    }

    applyLanguage() {
        const currentLanguage = this.getCurrentAppLanguage();
        this.updateButtonState(currentLanguage);
    }

    updateButtonState(language) {
        requestAnimationFrame(() => {
            const frenchButtons = document.querySelectorAll('[data-language-target="frenchButton"]');
            const englishButtons = document.querySelectorAll('[data-language-target="englishButton"]');

            [...frenchButtons, ...englishButtons].forEach(button => {
                button.classList.remove('inactive', 'active');
            });

            if (language === 'fr') {
                frenchButtons.forEach(button => button.classList.add('inactive'));
                englishButtons.forEach(button => button.classList.remove('inactive'));
            } else {
                englishButtons.forEach(button => button.classList.add('inactive'));
                frenchButtons.forEach(button => button.classList.remove('inactive'));
            }
        });
    }
}