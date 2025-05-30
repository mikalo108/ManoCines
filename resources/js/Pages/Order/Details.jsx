import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, usePage, router } from '@inertiajs/react';
import BlueButton from '@/components/BlueButton';

export default function OrderDetails(props) {
    const user = usePage().props.auth.user;
    const chairsSelected = usePage().props.chairsSelected || [];

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
                currentPage={"orderDetails"}
                locale={props.locale}
                auth={props.auth}
                lang={props.lang}
            >
                <Head title={"Order Details"} />
                <div className="relative flex min-h-screen flex-col selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full px-6 flex flex-col items-center max-w-4xl text-center">
                        <div className="flex justify-between mb-4 w-full">
                            <BlueButton link={"products.chairs"} params={[
                                { key: 'cinema', value: props.cinema_id },
                                { key: 'film', value: props.film_id },
                                { key: 'room', value: props.room_id },
                                { key: 'time', value: props.time_id }
                            ]}>{props.lang.back}</BlueButton>
                        </div>
                        <h1 className="text-black dark:text-white mt-8 font-bold" style={{ fontWeight: 'bolder', width: '100%', textAlign: 'center' }}>
                            {props.langTable.titleClient}
                        </h1>
                        <h2 className="mb-8" style={{ textAlign: 'center' }}>
                            {props.langTable.subtitleClient}
                        </h2>

                        <div className="w-full">
                            <h3 className="font-semibold mb-4">Cinema:</h3>
                            <p className="mb-6">{props.cinema_id}</p> {/* You can replace with cinema name if available */}

                            <h3 className="font-semibold mb-4">Selected Products:</h3>
                            <ul className="mb-6 list-none p-0">
                                {props.selectedProducts && props.selectedProducts.length > 0 ? (
                                    props.selectedProducts.map(([product, quantity], index) => (
                                        <li key={index} className="mb-4 border rounded p-4 flex flex-col items-center gap-4">
                                            <img src={`/storage/products/${product.image}`} alt={product.name} className="w-20 h-20 object-cover" />
                                            <div>
                                                <div className="font-semibold">{product.name}</div>
                                                <div>{product.description}</div>
                                                <div>Quantity: {quantity}</div>
                                            </div>
                                        </li>
                                    ))
                                ) : (
                                    <p>No products selected</p>
                                )}
                            </ul>

                            <h3 className="font-semibold mb-4">Selected Chairs (Tickets):</h3>
                            <ul className="list-none p-0">
                                {chairsSelected && chairsSelected.length > 0 ? (
                                    chairsSelected.map((chair, index) => (
                                        <li key={index}>
                                            Row {chair.row} - Column {chair.column}
                                        </li>
                                    ))
                                ) : (
                                    <p>No chairs selected</p>
                                )}
                            </ul>
                        </div>
                    </div>
                </div>
            </Layout>
        );
    } else {
        router.get(route('orders.index'));
        return null;
    }
}
