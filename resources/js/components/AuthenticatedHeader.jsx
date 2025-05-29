import { Link } from '@inertiajs/react';
import { useState } from 'react';
import UserDropdown from '@/components/UserDropdown';
import CartDropdown from '@/components/CartDropdown';

export default function AuthenticatedHeader({ currentPage, auth, locale, lang }) {
    const [isOpen, setIsOpen] = useState(false);

    const activeLinkStyle = {
        backgroundColor: 'rgba(107, 114, 128, 0.2)',
        color: '#000', 
        borderRadius: '9999px',
        transition: 'all 0.2s',
    };

    return (
        <header 
            style={{ zIndex: 100, marginInline:'50px', borderBottom:'1px solid #ccc', marginBottom:'40px'}} 
            className="grid grid-rows-[minmax(0,_1fr)] grid-cols-[1fr_1.5fr_1fr_120px] md:grid-cols-[1fr_1fr_1fr_120px] items-center gap-2 py-10 max-md:grid-cols-1 max-md:grid-rows-3 max-md:justify-items-center"
        >
            <div className='flex lg:justify-space-evently flex items-center gap-7'>
                <Link
                    href={route('home')}
                    className="flex items-center gap-2 max-md:justify-center"
                    title="MañoCines"
                >
                    <img src="/storage/general/logo.webp" alt="Logo" width='80vw' />
                    <h2 className="lg:text-2xl flex font-bold text-black dark:text-white">
                        MañoCines
                    </h2>                
                </Link>
                
            </div>
            <nav className="lg:grid lg:gap-2 lg:justify-items-center lg:grid-cols-3 lg:grid-rows-1">
                    <Link
                        href={route('films.index')}
                        style={currentPage === 'films' ? activeLinkStyle : null}
                        className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        {lang.films}
                    </Link>
                    <Link
                        href={route('cinemas.index')}
                        style={currentPage === 'cinemas' ? activeLinkStyle : null}
                        className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        {lang.cinemas}
                    </Link>
            </nav>
            <nav className="-mx-3 flex flex-1 justify-end md:justify-items-end align-items-center gap-3 max-md:justify-center max-md:gap-2 md:col-start-4 md:col-end-5" style={{ alignItems: 'center', textAlign: 'center'}}>
                <CartDropdown auth={auth} />
                <UserDropdown lang={lang} auth={auth} />
            </nav>
        </header>
    );
}
