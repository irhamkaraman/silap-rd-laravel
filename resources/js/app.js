import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import focus from '@alpinejs/focus';

// Register plugins
Alpine.plugin(intersect);
Alpine.plugin(focus);

// ── Dark Mode Store ─────────────────────────────────────────────────────────
Alpine.store('theme', {
    dark: localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),

    init() {
        this.apply();
        // Watch OS preference changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                this.dark = e.matches;
                this.apply();
            }
        });
    },

    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        this.apply();
    },

    apply() {
        document.documentElement.classList.toggle('dark', this.dark);
    }
});

// ── File Preview Component ──────────────────────────────────────────────────
Alpine.data('fileUpload', () => ({
    files: [],
    dragging: false,

    handleFiles(fileList) {
        const allowed = ['image/jpeg','image/png','image/gif','video/mp4','video/quicktime','video/x-msvideo','video/webm'];
        const maxSize = 20 * 1024 * 1024; // 20MB

        Array.from(fileList).slice(0, 5).forEach(file => {
            if (!allowed.includes(file.type)) return;
            if (file.size > maxSize) return;

            const reader = new FileReader();
            reader.onload = e => {
                this.files.push({
                    name: file.name,
                    size: (file.size / 1024 / 1024).toFixed(1),
                    type: file.type.startsWith('video/') ? 'video' : 'image',
                    preview: file.type.startsWith('image/') ? e.target.result : null,
                });
            };
            reader.readAsDataURL(file);
        });
    },

    removeFile(index) {
        this.files.splice(index, 1);
    },

    formatSize(mb) {
        return mb < 1 ? `${(mb * 1024).toFixed(0)} KB` : `${mb} MB`;
    }
}));

// ── Tracking Code Copy ──────────────────────────────────────────────────────
Alpine.data('trackingCode', (code) => ({
    code,
    copied: false,
    async copy() {
        await navigator.clipboard.writeText(this.code);
        this.copied = true;
        setTimeout(() => this.copied = false, 2500);
    }
}));

// ── Submit Form Loading ─────────────────────────────────────────────────────
Alpine.data('complaintForm', () => ({
    loading: false,
    submit() {
        this.loading = true;
    }
}));

// Start Alpine
window.Alpine = Alpine;
Alpine.start();
