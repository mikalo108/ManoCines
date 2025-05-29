import { useState } from 'react';
import { Link } from '@inertiajs/react';

export default function UserDropdown({ lang, auth }) {
    const [isOpen, setIsOpen] = useState(false);

    if (!auth.user) {
        return (
            <div className="relative inline-block text-left">
            <div>
                <button
                    type="button"
                    className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    id="menu-button"
                    aria-expanded={isOpen ? "true" : "false"}
                    aria-haspopup="true"
                    onClick={() => setIsOpen(!isOpen)}
                    >
                    <img src="/storage/general/user-icon.png" alt="Admin" />
                </button>
            </div>
            {isOpen && (
                <div
                className="absolute md:right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-700"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="menu-button"
                tabIndex="-1"
                style={{ left: '-114px' }}
                >
                <div className="py-1" role="none">
                    <Link
                    href={route('login')}
                    as="button"
                    className="text-gray-700 block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600 flex justify-right"
                    role="menuitem"
                    tabIndex="-1"
                    id="menu-item-1"
                    onClick={() => setIsOpen(false)}
                    >
                    {lang.login}
                    </Link>
                    <Link
                    href={route('register')}
                    as="button"
                    className="text-gray-700 block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600 flex justify-right"
                    role="menuitem"
                    tabIndex="-1"
                    id="menu-item-1"
                    onClick={() => setIsOpen(false)}
                    >
                    {lang.register}
                    </Link>
                </div>
                </div>
            )}
            </div>
        )
    }
    else if (auth.user || auth.user.is_admin) {
        return (
            <div className="relative inline-block text-left">
                <div>
                    <button
                        type="button"
                        className="rounded-full px-3 py-2 text-black ring-1 ring-transparent transition hover:bg-gray-500 hover:bg-opacity-20 hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        id="menu-button"
                        aria-expanded={isOpen ? "true" : "false"}
                        aria-haspopup="true"
                        onClick={() => setIsOpen(!isOpen)}
                    >
                        <img src="/storage/general/user-icon.png" alt='User' />
                    </button>
                </div>
                {isOpen && (
                    <div className="absolute md:right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-700" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabIndex="-1" style={{ left: -75 }}>
                        <div className="py-1" role="none">
                            <Link
                                href={route('dashboard')}
                                className="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
                                role="menuitem"
                                tabIndex="-1"
                                id="menu-item-0"
                                onClick={() => setIsOpen(false)}
                            >
                                {lang.dashboard}
                            </Link>
                            <Link
                                //href={route('myProfile.show')}
                                method="get"
                                as="button"
                                className="text-gray-700 block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600 flex justify-right"
                                role="menuitem"
                                tabIndex="-1"
                                id="menu-item-1"
                                onClick={() => setIsOpen(false)}
                            >
                                {lang.myProfile}
                            </Link>
                            <Link
                                href={route('logout')}
                                method="post"
                                as="button"
                                className="text-gray-700 block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600 flex justify-right"
                                role="menuitem"
                                tabIndex="-1"
                                id="menu-item-2"
                                onClick={() => setIsOpen(false)}
                            >
                                {lang.logout}
                            </Link>
                        </div>
                    </div>
                )}
            </div>
        )
    }        
}
