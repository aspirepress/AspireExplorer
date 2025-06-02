jQuery(document).ready(function () {
	new AeLightbox();
	if( jQuery('#not-found').length !== 0 ) {
		new FallingText({
			container: document.getElementById('not-found'),
			text: 'No Plugins Found',
			width: 600,
			height: 400
		});
	}
});

class AeLightbox {
	constructor() {
		this.overlay = null;
		this.overlayImg = null;
		this.closeBtn = null;
		this.bindOpen();
	}

	bindOpen() {
		jQuery('#accordion-content-screenshots ol a').on('click', (e) => {
			e.preventDefault();
			const imgSrc = jQuery(e.currentTarget).find('img').attr('src');
			this.createLightboxMarkup(imgSrc);
		});
	}

	createLightboxMarkup(imgSrc) {
		jQuery('#ae-lightbox-overlay').remove();
		// Find the caption from the <p> sibling of the clicked <a>
		const $link = jQuery(`#accordion-content-screenshots ol a img[src='${imgSrc}']`).closest('a');
		let caption = '';
		if ($link.length) {
			const $captionP = $link.next('p');
			if ($captionP.length) {
				caption = $captionP.html();
			}
		}
		jQuery('body').append(
			jQuery('<div>', { id: 'ae-lightbox-overlay', css: { display: 'flex' } }).append(
				jQuery('<span>', { id: 'ae-lightbox-close', html: '&times;' }),
				jQuery('<img>', { id: 'ae-lightbox-img', src: imgSrc, alt: 'Screenshot preview' }),
				caption ? jQuery('<div>', { id: 'ae-lightbox-caption', html: caption }) : null
			)
		);
		this.overlay = jQuery('#ae-lightbox-overlay');
		this.overlayImg = jQuery('#ae-lightbox-img');
		this.closeBtn = jQuery('#ae-lightbox-close');
		this.bindClose();
	}

	bindClose() {
		this.closeBtn.on('click', () => {
			this.destroy();
		});

		this.overlay.on('click', (e) => {
			if (e.target === this.overlay[0]) {
				this.destroy();
			}
		});

		jQuery(document).on('keydown.aelightbox', (e) => {
			if (e.key === 'Escape') {
				this.destroy();
			}
		});
	}

	destroy() {
		if (this.overlay) {
			this.overlay.remove();
			this.overlay = null;
			this.overlayImg = null;
			this.closeBtn = null;
			jQuery(document).off('keydown.aelightbox');
		}
	}
}

class FallingText {
	constructor({ container, text, width, height }) {
		this.container = container;
		this.text = text.toUpperCase();
		this.width = width;
		this.height = height;

		this.FONT = {
			'A': ["01110", "10001", "10001", "11111", "10001", "10001", "10001"],
			'D': ["11110", "10001", "10001", "10001", "10001", "10001", "11110"],
			'E': ["11111", "10000", "10000", "11110", "10000", "10000", "11111"],
			'F': ["11111", "10000", "10000", "11110", "10000", "10000", "10000"],
			'G': ["01110", "10001", "10000", "10111", "10001", "10001", "01111"],
			'I': ["11111", "00100", "00100", "00100", "00100", "00100", "11111"],
			'L': ["10000", "10000", "10000", "10000", "10000", "10000", "11111"],
			'N': ["10001", "11001", "10101", "10011", "10001", "10001", "10001"],
			'O': ["01110", "10001", "10001", "10001", "10001", "10001", "01110"],
			'P': ["11110", "10001", "10001", "11110", "10000", "10000", "10000"],
			'S': ["01111", "10000", "10000", "01110", "00001", "00001", "11110"],
			'U': ["10001", "10001", "10001", "10001", "10001", "10001", "01110"],
			' ': ["00000", "00000", "00000", "00000", "00000", "00000", "00000"]
		};

		this.CHAR_WIDTH = 5;
		this.CHAR_HEIGHT = 7;
		this.LETTER_SPACING = 1;

		this.blocks = [];
		this.init();
	}

	init() {
		jQuery(this.container).css({ width: this.width + 'px', height: this.height + 'px' });

		const cols = this.text.length * (this.CHAR_WIDTH + this.LETTER_SPACING) - this.LETTER_SPACING;
		const rows = this.CHAR_HEIGHT;

		this.blockSize = Math.floor(Math.min(this.width / cols, this.height / rows));
		jQuery(this.container).css('--block-size', `${this.blockSize}px`);

		this.createBlocks();
		this.animate();
	}

	shuffle(array) {
		for (let i = array.length - 1; i > 0; i--) {
			const j = Math.floor(Math.random() * (i + 1));
			[array[i], array[j]] = [array[j], array[i]];
		}
	}

	createBlocks() {
		const totalTextWidth = (this.text.length * (this.CHAR_WIDTH + this.LETTER_SPACING) - this.LETTER_SPACING) * this.blockSize;
		const startX = Math.floor((this.width - totalTextWidth) / 2);
		const startY = Math.floor((this.height - this.CHAR_HEIGHT * this.blockSize) / 2);

		const targets = [];

		for (let i = 0; i < this.text.length; i++) {
			const ch = this.text[i];
			const glyph = this.FONT[ch] || this.FONT[' '];

			for (let row = 0; row < glyph.length; row++) {
				for (let col = 0; col < glyph[row].length; col++) {
					if (glyph[row][col] === '1') {
						const x = startX + (i * (this.CHAR_WIDTH + this.LETTER_SPACING) + col) * this.blockSize;
						const y = startY + row * this.blockSize;
						targets.push({ x, y });
					}
				}
			}
		}

		this.shuffle(targets);
		const now = performance.now();

		for (let i = 0; i < targets.length; i++) {
			const delay = now + Math.random() * 2000;
			this.blocks.push(new this.Block(targets[i].x, targets[i].y, delay, this));
		}
	}

	animate() {
		const now = performance.now();
		this.blocks.forEach(block => block.update(now));
		requestAnimationFrame(() => this.animate());
	}

	Block = class {
		constructor(x, targetY, delay, context) {
			this.context = context;
			this.x = x;
			this.y = 0;
			this.targetY = targetY;
			this.delay = delay;
			this.settled = false;
			this.visible = false;

			this.el = jQuery('<div class="block"></div>')
				.css({
					width: context.blockSize + 'px',
					height: context.blockSize + 'px',
					left: x + 'px',
					opacity: 0
				})
				.appendTo(jQuery(context.container));
		}

		update(time) {
			if (this.settled || time < this.delay) return;

			if (!this.visible) {
				this.el.css('opacity', 1);
				this.visible = true;
			}

			if (!this.fallSpeed) {
				this.fallSpeed = (this.context.blockSize / 4) * (0.7 + Math.random() * 0.6);
			}
			const fallSpeed = this.fallSpeed;

			const nextY = this.y + fallSpeed;

			if (nextY >= this.targetY) {
				this.y = this.targetY;
				this.settled = true;
			} else {
				this.y = nextY;
			}

			this.el.css('top', this.y + 'px');
		}
	};
}
