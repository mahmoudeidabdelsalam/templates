// import external dependencies
import 'jquery';
import 'slick-carousel/slick/slick.js';
import 'devbridge-autocomplete/dist/jquery.autocomplete.min';
import 'masonry-layout/dist/masonry.pkgd';
import 'lightgallery/dist/js/lightgallery-all.min';
import 'lightslider/dist/js/lightslider.min';
import 'select2/dist/js/select2.min';
import 'select2/dist/js/select2.full.min';
import 'slideout/dist/slideout';
import 'isotope-layout/dist/isotope.pkgd.min';
import 'imagesloaded/imagesloaded.pkgd.min';
import 'aos/dist/aos';

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
