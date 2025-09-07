// resources/js/app.js

// import css (so Vite bundles it)
import '../css/app.css';


/* ----- Bootstrap JS (v5) ----- */
import 'bootstrap';

/* ----- vendor plugins (moved from public/assets/js) ----- */
/* place old vendor files in resources/js/vendor/ and import them */
// import './vendor/jquery-1.12.4.min.js';      // only if you must keep the old one (avoid duplication)
// import './vendor/jquery.scrollUp.min.js';
// import './vendor/slick.min.js';
// import './vendor/jquery.slicknav.min.js';

/* your app JS (migrated) */
import './main.js';

// any DOM ready initialization can live here or inside main.js
