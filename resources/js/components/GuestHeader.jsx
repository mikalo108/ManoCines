import { Link } from '@inertiajs/react';
import LanguageSwitcher from './LanguageSwitcher';
import Register from '@/Pages/Auth/Register';

export default function GuestHeader({ auth, locale, register, login, dashboard, films, cinemas }) {
    return (
        <header className="grid items-center gap-2 py-10 grid-cols-3 grid-rows-1 max-md:grid-cols-1 max-md:grid-rows-3 max-md:justify-items-center" style={{ zIndex: 100, marginInline:'50px'}}>
            <div className='flex lg:justify-space-evently flex items-center gap-7'>
                <Link
                    href={route('home')}
                    className="flex items-center gap-2 max-md:justify-center"
                    title="MañoCines"
                >
                    <img src="storage/general/logo.webp" alt="Logo" width='80vw' />
                    <h2 className="lg:text-2xl flex font-bold text-black dark:text-white">
                        MañoCines
                    </h2>                
                </Link>
                
            </div>
            <nav className="max-md:hidden lg:grid lg:gap-2 lg:justify-items-center lg:grid-cols-3 lg:grid-rows-1">
                
                    <Link
                        href={route('film.index')}
                        className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        {films}
                    </Link>
                    <Link
                        href={route('cinema.index')}
                        className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        {cinemas}
                    </Link>
            </nav>
            <nav className="-mx-3 flex flex-1 justify-end md:justify-items-end">
                {auth?.user ? (
                    <Link
                        href={route('dashboard')}
                        className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        {dashboard}
                    </Link>
                ) : (
                    <>
                        <Link
                            href={route('login')}
                            className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            {login}
                        </Link>
                        <Link
                            href={route('register')}
                            className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            {register}
                        </Link>
                    </>
                )}
                <LanguageSwitcher currentLocale={locale} />
            </nav>
            
        </header>
    );
}
