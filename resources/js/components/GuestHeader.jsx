import { Link } from '@inertiajs/react';
import LanguageSwitcher from './LanguageSwitcher';
import UserDropdown from '@/components/UserDropdown';

export default function GuestHeader({ auth, locale, lang }) {
    return (
        <header 
            style={{ zIndex: 100, marginInline:'50px', borderBottom:'1px solid #ccc', marginBottom:'40px'}} 
            className="grid grid-rows-[minmax(0,_1fr)] grid-cols-[1fr_1.5fr_1fr_120px] md:grid-cols-[1fr_1fr_1fr_120px] items-center gap-2 py-10 max-md:grid-cols-1 max-md:grid-rows-4 max-md:justify-items-center"
        >
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
                <LanguageSwitcher currentLocale={locale} lang={lang} />
            </div>
            <nav className="flex justify-end items-center gap-4 max-md:justify-center max-md:gap-2 md:col-start-2 md:col-end-3">
                <Link
                    href={route('login')}
                    className="text-black dark:text-white hover:text-[#FF2D20] dark:hover:text-[#FF2D20] transition-colors"
                    title={lang.home}
                >
                    <p className='color-red'>{lang.guestMessage}</p>
                </Link>
            </nav>
            <nav className="flex justify-end items-center ml-16 gap-4 max-md:justify-center max-md:ml-0 max-md:gap-2 md:col-start-3 md:col-end-4">
                <Link
                    href={route('register')}
                    className="text-black dark:text-white hover:text-[#FF2D20] dark:hover:text-[#FF2D20] transition-colors"
                    title={lang.home}
                >
                    <p className='color-red'>{lang.guestMessage_2}</p>
                </Link>
            </nav>
            <nav className="-mx-3 flex flex-1 justify-end md:justify-items-end align-items-center gap-3 max-md:justify-center max-md:gap-2 md:col-start-4 md:col-end-5" style={{ alignItems: 'center', textAlign: 'center'}}>                
                <UserDropdown lang={lang} auth={auth} />
            </nav>
        </header>
    );
}
