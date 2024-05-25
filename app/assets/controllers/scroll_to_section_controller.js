import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['title'];

    // Scrolls to the section corresponding to the clicked link
    scrollToSection(event) {
        event.preventDefault();

        // Retrieve the target section's ID from the clicked link's data-target attribute
        const targetId = event.currentTarget.getAttribute('data-target');

        // Select the HTML element corresponding to the target section ID
        const targetElement = document.querySelector(`#${targetId}`);

        if (targetElement) {
            // Calculate the header height to offset the scroll position correctly
            const headerHeight = document.querySelector('.header') ? document.querySelector('.header').offsetHeight : 0;

            // Calculate the target scroll position based on the current position of the target section
            const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - headerHeight;

            // Smooth scrolling to the target section
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        } else {
            console.error(`Element with ID ${targetId} not found.`);
        }
    }
}
