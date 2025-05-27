import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import AdminLayout from '@/Layouts/AdminLayout.jsx';
import { Head, usePage } from '@inertiajs/react';
import LanguageSwitcher from '@/components/LanguageSwitcher';

export default function Dashboard(props) {
    const user = usePage().props.auth.user;

    // Comprobar si el usuario es admin para devolver el layout correspondiente
    const Layout = user.role === 'admin' ? AdminLayout : AuthenticatedLayout;

    return (
        <Layout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
            locale={props.locale} 
            auth={props.auth} 
            lang={props.lang} 
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            {props.auth.user.role === 'admin' ? (
                                <p className="text-lg font-semibold">
                                    {props.lang.welcome}, Admin! {props.lang.dashboard_description}
                                </p>
                            ) : (
                                <p className="text-lg font-semibold">
                                    {props.lang.welcome}, {user.name}! {props.lang.dashboard_description} 
                                </p>
                            )}
                        </div>
                    </div>
                    <fieldset>
                        <div className="flex pl-20 items-center mt-10 gap-5 mb-4">
                            <label> {props.lang.languageSwitcher_desc} </label>
                            <LanguageSwitcher currentLocale={props.locale} />
                        </div>
                    </fieldset>
                </div>
            </div>
        </Layout>
    );
}
