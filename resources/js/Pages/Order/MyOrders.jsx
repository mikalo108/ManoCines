import React, { useEffect } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, usePage, router } from '@inertiajs/react';

export default function MyOrders(props) {
    const { auth, ordersUser, locale, lang } = usePage().props;
    const user = auth?.user;

    const localeMap = {
        es: 'es-ES',
        en: 'en-US',
    };

    // Obtener locale para la fecha
    const fullLocale = localeMap[props.locale] || 'en-US';


    // Elegir layout según rol
    const Layout = user?.role === 'Admin'
        ? AdminLayout
        : user
        ? AuthenticatedLayout
        : GuestLayout;

    // Redirigir Admins a orders.index
    useEffect(() => {
        if (!user || user?.role === 'Admin') {
            router.get(route('orders.index'));
        }
    }, [user]);

    // Render null mientras redirige Admin
    if (!user || user?.role === 'Admin') {
        return null;
    }

    return (
        <Layout
            currentPage="MyOrders"
            locale={locale}
            auth={auth}
            lang={lang}
        >
            <Head title="MyOrders" />
            <div className="relative flex min-h-screen flex-col selection:bg-[#FF2D20] selection:text-white items-center">
                <div className="relative w-full px-6 flex flex-col items-center max-w-4xl text-center">
                    <h1 className="mt-6 text-3xl font-bold text-gray-900 dark:text-white">{lang.myOrders}</h1>

                    {ordersUser?.data?.length > 0 ? (
                        ordersUser.data.map((order) => (
                            <div key={order.id} className="mt-6 w-full bg-white shadow-2xl rounded-2xl p-6 dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
                                <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                    {lang.order} #{order.id}
                                </h2>
                                <p className="text-gray-700 dark:text-gray-300">
                                    {lang.date}: {new Date(order.created_at).toLocaleDateString(locale)}
                                </p>
                                <p className="text-gray-700 dark:text-gray-300">
                                    {lang.total}: {order.total}€
                                </p>

                                <div className="mt-4 text-left">
                                    <h3 className="text-lg font-semibold text-gray-900 dark:text-white">{lang.chairs}:</h3>
                                    <ul className="list-disc list-inside text-gray-700 dark:text-gray-300">
                                        {/* Chairs */}
                                        {order.tickets?.length > 0 ? (
                                            order.tickets.map(ticket => (
                                                <li key={ticket.id} className='mb-6 list-outside ml-6 mt-2'>
                                                    <div>
                                                        {lang.chair}: {ticket.chair?.row}{ticket.chair?.column}
                                                    </div>
                                                    <div>
                                                        {lang.room}: {ticket.time?.room?.number}
                                                    </div>
                                                    <div>
                                                        {lang.film}: {ticket.time?.film?.name}
                                                    </div>
                                                    <div>
                                                        {lang.time}: {ticket.time?.time ? new Date(ticket.time.time).toLocaleTimeString(locale, { hour: '2-digit', minute: '2-digit' }) : 'N/A'} {ticket.time?.time ? new Date(ticket.time.time).toLocaleDateString(fullLocale, {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', }) : ''}
                                                    </div>
                                                </li>
                                            ))
                                        ) : (
                                            <li>{lang.noChairs}</li>
                                        )}

                                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white">{lang.products}:</h3>
                                        {/* Products */}
                                        {order.products?.length > 0 ? (
                                            order.products.map(op => (
                                                <li key={op.id}  className='mb-6 list-outside ml-6 mt-2'>
                                                    {op.product?.name} x {op.quantity} ({op.product?.price ?? 0}€ {lang.each})
                                                </li>
                                            ))
                                        ) : (
                                            <li>{lang.noProducts}</li>
                                        )}
                                    </ul>
                                </div>
                            </div>
                        ))
                    ) : (
                        <h2 className="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{lang.noOrders}</h2>
                    )}
                </div>
            </div>
        </Layout>
    );
}
