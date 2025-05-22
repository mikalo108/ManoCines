import GuestHeader from '../Components/GuestHeader';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children, auth, copyright, locale }) {
    return (
        <div className="bg-gray-50 text-black/50 dark:bg-zinc-800 dark:text-white/50">
            <GuestHeader auth={auth} locale={locale} />

            <div className="bg-gray-50 text-black/50 dark:bg-zinc-800 dark:text-white/50">
                {children}
            </div>
            <footer className="py-12 text-center text-sm text-black dark:text-white/70">
                <hr className='py-6' style={{opacity:'50%'}} />
                <p>
                    MañoCines 2025. {copyright}
                </p>
            </footer>
        </div>
    );
}
