import React from 'react';
import { Link } from '@inertiajs/react';
import { route } from 'ziggy-js';

const Ziggy = window.Ziggy;

export default function LanguageSwitcher({ currentLocale }) {
    return (
        <div className="flex space-x-2 gap-2 ml-5">
            <Link
                href={route('localeSwitch', { locale: 'es' }, {}, Ziggy)}
                as="a"
                preserveScroll={false}
                preserveState={false} 
                className={`p-1 rounded-full  px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white border rounded ${currentLocale === 'es' ? 'border-red-600' : 'border-transparent'}`}>
                <img src="/storage/general/es.png" alt="Español" className="h-6 w-6" />
            </Link>
            <Link
                href={route('localeSwitch', { locale: 'en' }, {}, Ziggy)}
                as="a"
                preserveScroll={false}
                preserveState={false} 
                className={`p-1 rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white border rounded ${currentLocale === 'en' ? 'border-red-600' : 'border-transparent'}`}>
                <img src="/storage/general/en.png" alt="English" className="h-6 w-6" />
            </Link>
        </div>
    );
}
