import AdminHeader from '@/Components/AdminHeader';
import { usePage } from '@inertiajs/react';
import { useState } from 'react';

export default function AdminLayout({ children }) {
    const { auth, locale, lang } = usePage().props;

    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    return (
        <div className="bg-gray-50 text-black/50 dark:bg-zinc-800 dark:text-white/50">
                <AdminHeader auth={auth} locale={locale} lang={lang} />
    
                <div className="bg-gray-50 text-black/50 dark:bg-zinc-800 dark:text-white/50">
                    {children}
                </div>
                <footer className="py-12 text-center text-sm text-black dark:text-white/70">
                    <hr className='py-6' style={{opacity:'50%'}} />
                    <p>
                        MañoCines 2025. {lang.copyright}
                    </p>
                </footer>
        </div>
    );
}
