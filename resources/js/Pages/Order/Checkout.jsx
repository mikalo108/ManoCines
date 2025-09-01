import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, usePage, router } from '@inertiajs/react';
import BlueButton from '@/components/BlueButton';

export default function Checkout(props) {
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
        if (!props.order) {
            router.get(route('home'));
            return null;
        }
        return (
            <Layout
                currentPage={"Checkout"}
                locale={props.locale}
                auth={props.auth}
                lang={props.lang}
            >
                <Head title={"Checkout"} />
                <div className="relative flex min-h-screen flex-col selection:bg-[#FF2D20] selection:text-white items-center">
                    <div className="relative w-full px-6 flex flex-col items-center max-w-4xl text-center">
                        <h1 className="text-green-600 text-3xl font-bold mb-6">Compra realizada con éxito</h1>
                        <p className="mb-4">{props.lang.numberOrder} <strong>{props.order.id}</strong></p>
                        <p className="mb-4">{props.lang.subtotalPaid} <strong>{(props.order.subtotal)}€</strong></p>
                        <p className="mb-4">{props.lang.totalPaid} <strong>{(props.order.total)}€</strong></p>
                        <p className="mb-8">{props.lang.congrats}</p>
                        <BlueButton link="home">{props.lang.backToHome}</BlueButton>
                    </div>
                </div>
            </Layout>
        );
    } else {
        router.get(route('orders.index'));
        return null;
    }
}
