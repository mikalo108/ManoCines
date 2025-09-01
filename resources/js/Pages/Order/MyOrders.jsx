import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, usePage, router } from '@inertiajs/react';

export default function MyOrders(props) {
    const user = usePage().props.auth.user;

    const Layout = (() => {
        if (user && user.role === 'Admin') {
            return AdminLayout;
        } else if (user) {
            return AuthenticatedLayout;
        } else {
            return GuestLayout;
        }
    })();

    if (props.auth.user.role !== 'Admin') {
        return (
            <Layout
                currentPage={"MyOrders"}
                locale={props.locale}
                auth={props.auth}
                lang={props.lang}
            >
                <Head title={"MyOrders"} />
                <div className="relative flex min-h-screen flex-col selection:bg-[#FF2D20] selection:text-white items-center">
                    <div className="relative w-full px-6 flex flex-col items-center max-w-4xl text-center">
                        <h1 className="mt-6 text-3xl font-bold text-gray-900 dark:text-white">{props.lang.myOrders}</h1>
                        {props.orders.length > 0 ? (
                            <div>
                            {props.orders.map((order) => (
                                <div key={order.id} className="mt-6 w-full bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">
                                    <h2 className="text-xl font-semibold text-gray-900 dark:text-white">{props.lang.order} #{order.id}</h2>
                                    <p className="text-gray-700 dark:text-gray-300">{props.lang.date}: {new Date(order.created_at).toLocaleDateString(props.locale)}</p>
                                    <p className="text-gray-700 dark:text-gray-300">{props.lang.total}: ${order.total.toFixed(2)}</p>
                                    <div className="mt-4">
                                        <h3 className="text-lg font-semibold text-gray-900 dark:text-white">{props.lang.chairs}:</h3>
                                        <ul className="list-disc list-inside text-gray-700 dark:text-gray-300">
                                            {order.order_tickets.map((ticket) => (
                                                <li key={ticket.id}>
                                                    {props.lang.room}: {ticket.time.room.name}, {props.lang.chair}: {ticket.chair.row}{ticket.chair.number}, {props.lang.movie}: {ticket.time.movie.title}, {props.lang.time}: {new Date(ticket.time.start_time).toLocaleTimeString(props.locale, { hour: '2-digit', minute: '2-digit' })}
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                </div>
                            ))}
                            </div>
                        ): <h2 className='mt-6 text-xl font-semibold text-gray-900 dark:text-white'>{props.lang.noOrders}</h2>}
                    </div>
                </div>
            </Layout>
        );
    } else {
        router.get(route('orders.index'));
        return null;
    }
}
