import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h, DefineComponent } from 'vue';
import { initializeTheme } from '@/composables/useAppearance';
import AppLayout from '@/layouts/AppLayout.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { initializeFlashToast } from '@/lib/flashToast';
import PublicLayout from '@/layouts/PublicLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - PharmaVictoria` : 'PharmaVictoria'),

    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },

    layout: (name) => {

        if (name.startsWith('Public/')) {
            return PublicLayout;
        }


        switch (true) {
            case name === 'Welcome':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },

    progress: {
        color: '#4B5563',
    },
});

/**
 * PROTECCIÓN SSR PARA DOCKER
 * Solo ejecutamos código que dependa de 'window' o 'document' si estamos en el navegador.
 * Esto soluciona el error "window is not defined" y la pantalla negra.
 */
if (typeof window !== 'undefined') {
    // This will set light / dark mode on page load...
    initializeTheme();

    // This will listen for flash toast data from the server...
    initializeFlashToast();
}