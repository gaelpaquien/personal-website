import { startStimulusApp } from '@symfony/stimulus-bundle';

const app = startStimulusApp();

import ThemesController from './controllers/themes_controller.js';
import AnimationFadeIn from './controllers/animation_fade_in_controller.js';
import AnimationText from './controllers/animation_text_controller.js';
import NavigationController from './controllers/navigation_controller.js';
import LanguageController from './controllers/language_controller.js';
import RedirectController from './controllers/redirect_controller.js';
import ScrollController from './controllers/scroll_controller.js';
import CardController from './controllers/card_controller.js';
import ReviewsCarouselController from './controllers/reviews_carousel_controller.js';
import InputFileController from './controllers/input_file.controller.js';
import FormController from './controllers/form_controller.js';
import ToastController from './controllers/toast_controller.js';

app.register('themes', ThemesController);
app.register('animation-fade-in-up', AnimationFadeIn);
app.register('animation-text', AnimationText);
app.register('navigation', NavigationController);
app.register('language', LanguageController);
app.register('redirect', RedirectController);
app.register('scroll', ScrollController);
app.register('card', CardController);
app.register('reviews-carousel', ReviewsCarouselController);
app.register('input-file', InputFileController);
app.register('form', FormController);
app.register('toast', ToastController);