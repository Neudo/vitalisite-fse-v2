(() => {
	document.addEventListener('DOMContentLoaded', function () {
		initRevealY()
		initRevealY2()
		initRevealTitle()

		function initRevealY() {
			const revealY = document.querySelectorAll('.reveal-y')
			revealY.forEach((reveal) => {
				if (ScrollTrigger.isInViewport(reveal)) return;
				const duration = reveal.classList.contains('reveal-fast')
					? 0.3
					: 0.7
				const delay = reveal.classList.contains('reveal-delay')
					? 0.2
					: 0

				gsap.from(reveal, {
					y: 70,
					duration,
					delay,
					scrollTrigger: {
						trigger: reveal,
						start: 'top 90%',
						ease: 'power3.inOut',
					},
				})
			})
		}

		function initRevealY2() {
			const revealY2 = document.querySelectorAll('.reveal-y2')

			revealY2.forEach((reveal) => {
				const delay = reveal.dataset.revealDelay
				gsap.from(reveal, {
					y: 10,
					opacity: 0,
					duration: 0.4,
					delay,
					scrollTrigger: {
						trigger: reveal,
						start: 'top 90%',
					},
				})
			})
		}

		function initRevealTitle() {
			const revealTitle = document.querySelectorAll('.reveal-title')

			revealTitle.forEach((reveal) => {
				gsap.from(reveal, {
					y:10,
					opacity:0,
					duration: 0.5,
					ease: 'power3.out',
					scrollTrigger: {
						trigger: reveal,
						start: 'top bottom',
					},
				})
			})

		}

		function checkMenuOverflow() {
			const nav = document.getElementById('site-navigation')
			const navItemsHeight = nav.querySelector('ul').offsetHeight

			if (navItemsHeight > 40) {
				// Display menu mobile
				if(nav.classList.contains('nav-desktop')) {
					nav.classList.remove('nav-desktop')
				}
			} else {
				// Display menu desktop
				if(!nav.classList.contains('nav-desktop')) {
					nav.classList.add('nav-desktop')
				}
			}
		}
		window.addEventListener('resize', checkMenuOverflow)
		checkMenuOverflow()
	})
})()
