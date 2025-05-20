import GuestHeader from '../Components/GuestHeader';
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children, auth }) {
    return (
        <div className="bg-gray-50 text-black/50 dark:bg-zinc-800 dark:text-white/50">
            <GuestHeader auth={auth} />

            <div className="bg-gray-50 text-black/50 dark:bg-zinc-800 dark:text-white/50">
                {children}
            </div>
        </div>
    );
}
