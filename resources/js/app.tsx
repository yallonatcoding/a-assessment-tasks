import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { PrimeReactProvider } from 'primereact/api';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.{tsx,jsx}'),
        ),
    setup({ el, App, props }) {
        createRoot(el).render(
            <PrimeReactProvider>
                <App {...props} />
            </PrimeReactProvider>
        )
    },
    progress: {
        color: '#4B5563',
    },
});
