import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css'

import Demo from './js/demo.js';

const d = new Demo();
d.log();

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
