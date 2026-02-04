(() => {
	// javascript/script.js
	document.addEventListener('DOMContentLoaded', function () {
		initMobileMenu();
		initStickyMobileCTA();

		function initMobileMenu() {
			const nav = document.getElementById('site-navigation');
			const menuToggle = document.getElementById('menu-toggle');
			const mobileMenu = document.getElementById('mobile-menu');

			if (nav) {
				let isOpen = false;
				menuToggle.addEventListener('click', function () {
					if (!isOpen) {
						gsap.to(mobileMenu, {
							x: 0,
							duration: 0.35,
							ease: 'power2.out',
						});
					} else {
						gsap.to(mobileMenu, {
							x: '-110%',
							duration: 0.3,
							ease: 'power2.in',
						});
					}
					isOpen = !isOpen;
				});
				const toggles = document.querySelectorAll('.toggle-submenu');
				toggles.forEach((toggle) => {
					toggle.addEventListener('click', function () {
						const subMenu =
							this.parentElement.querySelector('.sub-menu');
						const icon = this.querySelector('svg');
						if (subMenu.classList.contains('hidden')) {
							subMenu.classList.remove('hidden');
							subMenu.classList.add('flex');
							icon.classList.add('rotate-180');
						} else {
							subMenu.classList.remove('flex');
							subMenu.classList.add('hidden');
							icon.classList.remove('rotate-180');
						}
					});
				});
			}
		}

		function initStickyMobileCTA() {
			const ctaWrapper = document.querySelector(
				'.sticky-mobile-cta-wrapper'
			);
			if (!ctaWrapper) return;

			const ctaBar = ctaWrapper.querySelector('.sticky-mobile-cta');
			if (!ctaBar) return;

			// Show the wrapper
			ctaWrapper.style.display = 'block';

			// Variables for scroll behavior
			let hasShown = false;
			let isScrolling = false;

			function handleScroll() {
				const scrollTop =
					window.pageYOffset || document.documentElement.scrollTop;

				if (scrollTop > 150) {
					// Show the CTA bar when scrolled more than 150px
					if (!hasShown) {
						ctaBar.classList.remove('hide');
						ctaBar.classList.add('show');
						hasShown = true;
					}
				} else if (scrollTop <= 150 && hasShown) {
					// Hide the CTA bar when scrolled back to 150px or less
					ctaBar.classList.remove('show');
					ctaBar.classList.add('hide');
					hasShown = false;
				}
			}

			// Initial setup - CTA is hidden
			ctaBar.classList.add('hide');

			// Throttle scroll events
			window.addEventListener('scroll', function () {
				if (!isScrolling) {
					requestAnimationFrame(function () {
						handleScroll();
						isScrolling = false;
					});
					isScrolling = true;
				}
			});
		}
	});
})();
