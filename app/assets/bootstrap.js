import { startStimulusApp } from '@symfony/stimulus-bundle';

// Start the Stimulus application
const app = startStimulusApp();

// Import controllers
import AnimationFadeIn from './controllers/animation_fade_in_controller.js';
import NavigationController from './controllers/navigation_controller.js';
import ThemesController from './controllers/themes_controller.js';
import LanguageController from './controllers/language_controller.js';
import RedirectController from './controllers/redirect_controller.js';
import ScrollToTopController from './controllers/scroll_to_top_controller.js';
import ScrollToSectionController from './controllers/scroll_to_section_controller.js';
import ScrollToNextSectionController from './controllers/scroll_to_next_section_controller.js';
import PortfolioCardController from './controllers/portfolio_card_controller.js';
import ReviewsCarouselController from './controllers/reviews_carousel_controller.js';
import ReviewsPopupController from './controllers/reviews_popup_controller.js';

// Register controllers with Stimulus application
app.register('animation-fade-in-up', AnimationFadeIn);
app.register('navigation', NavigationController);
app.register('themes', ThemesController);
app.register('language', LanguageController);
app.register('redirect', RedirectController);
app.register('scroll-to-top', ScrollToTopController);
app.register('scroll-to-section', ScrollToSectionController);
app.register('scroll-to-next-section', ScrollToNextSectionController);
app.register('portfolio-card', PortfolioCardController);
app.register('reviews-carousel', ReviewsCarouselController);
app.register('reviews-popup', ReviewsPopupController);
