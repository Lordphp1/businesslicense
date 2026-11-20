/* Meridian Investment Agency — public site behaviour (vanilla JS) */
(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* Reveal-on-scroll: add .is-visible once per element */
    var revealables = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && !reduceMotion && revealables.length > 0) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        revealables.forEach(function (el) { io.observe(el); });
    } else {
        revealables.forEach(function (el) { el.classList.add('is-visible'); });
    }
})();
