/**
 * IRAN INFO - JavaScript Principal
 * Fonctionnalités: Menu responsive, Lazy loading, Smooth scroll
 */

(function() {
  'use strict';

  // === CONFIGURATION === //
  const config = {
    headerSelector: '.site-header',
    mobileBreakpoint: 768,
  };

  // === UTILITAIRES === //
  const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  };

  // === HEADER STICKY AVEC SHADOW === //
  function initStickyHeader() {
    const header = document.querySelector(config.headerSelector);
    if (!header) return;

    const addShadow = () => {
      if (window.scrollY > 10) {
        header.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
      } else {
        header.style.boxShadow = '0 1px 2px 0 rgba(0, 0, 0, 0.1)';
      }
    };

    window.addEventListener('scroll', debounce(addShadow, 10));
    addShadow(); // Initial call
  }

  // === LAZY LOADING IMAGES === //
  function initLazyLoading() {
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
              img.removeAttribute('data-src');
            }
            img.classList.add('loaded');
            observer.unobserve(img);
          }
        });
      }, {
        rootMargin: '50px 0px',
        threshold: 0.01
      });

      document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
      });
    } else {
      // Fallback pour navigateurs anciens
      document.querySelectorAll('img[data-src]').forEach(img => {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
      });
    }
  }

  // === SMOOTH SCROLL POUR ANCRES === //
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          e.preventDefault();
          const headerHeight = document.querySelector(config.headerSelector)?.offsetHeight || 0;
          const targetPosition = targetElement.offsetTop - headerHeight - 20;

          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          });
        }
      });
    });
  }

  // === NAVIGATION ACTIVE === //
  function initActiveNavigation() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.main-nav a').forEach(link => {
      const linkPath = new URL(link.href).pathname;
      if (linkPath === currentPath) {
        link.classList.add('active');
      }
    });
  }

  // === EXTERNAL LINKS (ouvre dans nouvel onglet) === //
  function initExternalLinks() {
    document.querySelectorAll('a[href^="http"]').forEach(link => {
      if (!link.href.includes(window.location.hostname)) {
        link.setAttribute('target', '_blank');
        link.setAttribute('rel', 'noopener noreferrer');
      }
    });
  }

  // === BOUTON RETOUR EN HAUT === //
  function initBackToTop() {
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '↑';
    backToTop.className = 'back-to-top';
    backToTop.setAttribute('aria-label', 'Retour en haut');
    backToTop.style.cssText = `
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: var(--color-primary, #1a3a52);
      color: white;
      border: none;
      font-size: 24px;
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    `;

    document.body.appendChild(backToTop);

    const toggleBackToTop = debounce(() => {
      if (window.scrollY > 300) {
        backToTop.style.opacity = '1';
        backToTop.style.visibility = 'visible';
      } else {
        backToTop.style.opacity = '0';
        backToTop.style.visibility = 'hidden';
      }
    }, 100);

    window.addEventListener('scroll', toggleBackToTop);

    backToTop.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // === IMAGE LIGHTBOX (FRONT) === //
  function initImageLightbox() {
    const modal = document.getElementById('front-image-lightbox');
    const modalImage = document.getElementById('front-lightbox-image');
    if (!modal || !modalImage) return;

    const openLightbox = (src, altText) => {
      if (!src) return;
      modalImage.src = src;
      modalImage.alt = altText || 'Image agrandie';
      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    };

    const closeLightbox = () => {
      modal.classList.remove('is-open');
      modal.setAttribute('aria-hidden', 'true');
      modalImage.src = '';
      document.body.style.overflow = '';
    };

    document.querySelectorAll('.js-zoomable-image').forEach((img) => {
      img.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        const zoomSrc = img.getAttribute('data-zoom-src') || img.currentSrc || img.src;
        openLightbox(zoomSrc, img.alt || 'Image agrandie');
      });
    });

    modal.querySelectorAll('[data-close-lightbox]').forEach((btn) => {
      btn.addEventListener('click', closeLightbox);
    });

    modal.addEventListener('click', (event) => {
      if (event.target === modal) {
        closeLightbox();
      }
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && modal.classList.contains('is-open')) {
        closeLightbox();
      }
    });
  }

  // === PROTECTION CONSOLE (optionnel, pour production) === //
  function disableConsole() {
    if (window.location.hostname !== 'localhost' && !window.location.hostname.includes('127.0.0.1')) {
      console.log = console.warn = console.error = function() {};
    }
  }

  // === ANALYTICS PLACEHOLDER === //
  function initAnalytics() {
    // Placeholder pour Google Analytics ou autre
    // window.dataLayer = window.dataLayer || [];
    // function gtag(){dataLayer.push(arguments);}
    // gtag('js', new Date());
    // gtag('config', 'GA_MEASUREMENT_ID');
  }

  // === RECHERCHE LOCALE (si implémentée) === //
  function initSearchFunctionality() {
    const searchInput = document.querySelector('input[type="search"]');
    if (!searchInput) return;

    searchInput.addEventListener('input', debounce(function(e) {
      const query = e.target.value.toLowerCase().trim();
      if (query.length < 2) return;

      // Implémentation de la recherche ici
      console.log('Recherche:', query);
    }, 300));
  }

  // === INITIALISATION === //
  function init() {
    // Vérifier que le DOM est chargé
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', init);
      return;
    }

    // Initialiser tous les modules
    initStickyHeader();
    initLazyLoading();
    initSmoothScroll();
    initActiveNavigation();
    initExternalLinks();
    initBackToTop();
    initSearchFunctionality();
    initImageLightbox();
    // initAnalytics(); // Décommenter en production
    // disableConsole(); // Décommenter en production

    // Log pour dev
    console.log('✓ Iran Info - Site initialisé');
  }

  // Démarrer l'initialisation
  init();

})();
