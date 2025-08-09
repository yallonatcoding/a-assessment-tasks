import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { PrimeReactProvider } from 'primereact/api';

import '../css/app.css';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.{tsx,jsx}', { eager: true })
    return pages[`./pages/${name}.jsx`] || pages[`./pages/${name}.tsx`];
  },
  setup({ el, App, props }) {
    createRoot(el).render(
      <PrimeReactProvider>
        <App {...props} />
      </PrimeReactProvider>
    )
  },
});