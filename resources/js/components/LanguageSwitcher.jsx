import React from 'react';
import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function LanguageSwitcher({ currentLocale }) {
    const switchLocale = (locale) => {
        router.get(route('locale.switch', { locale }), {}, {
            preserveScroll: true,
            preserveState: false,
            onSuccess: () => {
                router.reload();

            }
        });
    };

    return (
        <div className="flex space-x-2 gap-2 ml-5">
            <button
                onClick={() => switchLocale('es')}
                className={`p-1 rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white border rounded ${currentLocale === 'es' ? 'border-red-600' : 'border-transparent'}`}
            >
                <img src="/storage/general/es.png" alt="Español" className="h-6 w-6" />
            </button>
            <button
                onClick={() => switchLocale('en')}
                className={`p-1 rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white border rounded ${currentLocale === 'en' ? 'border-red-600' : 'border-transparent'}`}
            >
                <img src="/storage/general/en.png" alt="English" className="h-6 w-6" />
            </button>
        </div>
    );
}
