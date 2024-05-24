import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['card'];

    pressCard(event) {
        const card = event.currentTarget; // Get the pressed card element

        // Apply press animation to the card
        card.style.animation = "pressed 0.25s forwards";

        // Remove the animation style after the animation ends
        setTimeout(() => {
            card.style.animation = "";
        }, 250);

        // Navigate to..
        // window.location.href = "#";
    }
}
