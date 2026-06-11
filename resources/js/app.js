document.documentElement.classList.add('js');

const revealItems = document.querySelectorAll('[data-reveal]');
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const isCoarsePointer = window.matchMedia('(pointer: coarse)').matches;
const isCompactViewport = window.innerWidth < 1024;
const perfLite = prefersReducedMotion || isCoarsePointer || isCompactViewport;

document.documentElement.classList.toggle('perf-lite', perfLite);

if ('IntersectionObserver' in window && !perfLite) {
    const revealObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -12% 0px', threshold: 0.12 },
    );

    revealItems.forEach((item) => revealObserver.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
}

const storyCarousels = document.querySelectorAll('[data-story-carousel]');

storyCarousels.forEach((carousel) => {
    const slides = Array.from(carousel.querySelectorAll('[data-story-slide]'));
    const controls = Array.from(carousel.querySelectorAll('[data-story-control]'));
    const intervalMs = Number(carousel.dataset.storyInterval || 5500);
    let activeIndex = 0;
    let timer = null;

    if (slides.length === 0) {
        return;
    }

    const setActiveSlide = (nextIndex) => {
        activeIndex = (nextIndex + slides.length) % slides.length;

        slides.forEach((slide, index) => {
            const isActive = index === activeIndex;

            slide.classList.toggle('is-active', isActive);
            slide.toggleAttribute('hidden', !isActive);
            slide.setAttribute('aria-hidden', String(!isActive));
        });

        controls.forEach((control, index) => {
            const isActive = index === activeIndex;

            control.classList.toggle('is-active', isActive);
            control.setAttribute('aria-selected', String(isActive));
        });
    };

    const stop = () => {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    };

    const start = () => {
        if (perfLite || slides.length < 2 || timer) {
            return;
        }

        timer = window.setInterval(() => setActiveSlide(activeIndex + 1), intervalMs);
    };

    controls.forEach((control, index) => {
        control.addEventListener('click', () => {
            stop();
            setActiveSlide(index);
            start();
        });
    });

    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);
    carousel.addEventListener('focusin', stop);
    carousel.addEventListener('focusout', start);

    setActiveSlide(0);
    start();
});

const stickyCta = document.querySelector('[data-sticky-cta]');
const floatingContact = document.querySelector('[data-floating-contact]');
const quoteForm = document.querySelector('#quote-form');

if ((stickyCta || floatingContact) && quoteForm && 'IntersectionObserver' in window) {
    const stickyObserver = new IntersectionObserver(
        ([entry]) => {
            stickyCta?.classList.toggle('is-hidden', entry.isIntersecting);
            floatingContact?.classList.toggle('is-hidden', entry.isIntersecting);
        },
        { threshold: 0.2 },
    );

    stickyObserver.observe(quoteForm);
}

const heroVisualSections = document.querySelectorAll('[data-hero-visuals]');

heroVisualSections.forEach((section) => {
    const scenes = Array.from(section.querySelectorAll('[data-hero-scene]'));
    const controls = Array.from(section.querySelectorAll('[data-hero-control]'));
    const intervalMs = Number(section.dataset.heroInterval || 4000);
    let activeIndex = 0;
    let timer = null;

    if (scenes.length === 0) {
        return;
    }

    const setActiveScene = (nextIndex) => {
        activeIndex = (nextIndex + scenes.length) % scenes.length;

        scenes.forEach((scene, index) => {
            const isActive = index === activeIndex;

            scene.classList.toggle('is-active', isActive);
            scene.toggleAttribute('hidden', !isActive);
            scene.setAttribute('aria-hidden', String(!isActive));
        });

        controls.forEach((control, index) => {
            const isActive = index === activeIndex;

            control.classList.toggle('is-active', isActive);
            control.setAttribute('aria-selected', String(isActive));
        });
    };

    const stop = () => {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    };

    const start = () => {
        if (perfLite || scenes.length < 2 || timer) {
            return;
        }

        timer = window.setInterval(() => setActiveScene(activeIndex + 1), intervalMs);
    };

    controls.forEach((control, index) => {
        control.addEventListener('click', () => {
            stop();
            setActiveScene(index);
            start();
        });
    });

    section.addEventListener('mouseenter', stop);
    section.addEventListener('mouseleave', start);
    section.addEventListener('focusin', stop);
    section.addEventListener('focusout', start);

    setActiveScene(0);
    start();
});

const feedbackCarousels = document.querySelectorAll('[data-feedback-carousel]');

feedbackCarousels.forEach((carousel) => {
    const slides = Array.from(carousel.querySelectorAll('[data-feedback-slide]'));
    const controls = Array.from(carousel.querySelectorAll('[data-feedback-control]'));
    const intervalMs = Number(carousel.dataset.feedbackInterval || 5000);
    let activeIndex = 0;
    let timer = null;

    if (slides.length === 0) {
        return;
    }

    const setActiveSlide = (nextIndex) => {
        activeIndex = (nextIndex + slides.length) % slides.length;

        slides.forEach((slide, index) => {
            const isActive = index === activeIndex;

            slide.classList.toggle('is-active', isActive);
            slide.toggleAttribute('hidden', !isActive);
            slide.setAttribute('aria-hidden', String(!isActive));
        });

        controls.forEach((control, index) => {
            const isActive = index === activeIndex;

            control.classList.toggle('is-active', isActive);
            control.setAttribute('aria-selected', String(isActive));
        });
    };

    const stop = () => {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    };

    const start = () => {
        if (perfLite || slides.length < 2 || timer) {
            return;
        }

        timer = window.setInterval(() => setActiveSlide(activeIndex + 1), intervalMs);
    };

    controls.forEach((control, index) => {
        control.addEventListener('click', () => {
            stop();
            setActiveSlide(index);
            start();
        });
    });

    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);
    carousel.addEventListener('focusin', stop);
    carousel.addEventListener('focusout', start);

    setActiveSlide(0);
    start();
});

const countUpItems = document.querySelectorAll('[data-count-up]');

if ('IntersectionObserver' in window) {
    const countObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const element = entry.target;
                const target = Number(element.dataset.countUp || 0);

                if (!Number.isFinite(target)) {
                    observer.unobserve(element);
                    return;
                }

                if (perfLite) {
                    element.textContent = String(target);
                    observer.unobserve(element);
                    return;
                }

                let current = 0;
                const steps = 24;
                const increment = Math.max(1, Math.ceil(target / steps));
                const timer = window.setInterval(() => {
                    current = Math.min(target, current + increment);
                    element.textContent = String(current);

                    if (current >= target) {
                        window.clearInterval(timer);
                    }
                }, 36);

                observer.unobserve(element);
            });
        },
        { threshold: 0.4 },
    );

    countUpItems.forEach((item) => countObserver.observe(item));
}
