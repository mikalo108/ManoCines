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
                <div className="relative flex min-h-screen items-center flex-col selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full px-6 flex flex-col items-center justify-center max-w-4xl text-center">
                        <div className="flex justify-between mb-4 w-full">
                            <BlueButton link={"products.chairs"} params={[
                                { key: 'cinema', value: props.cinema?.id },
                                { key: 'film', value: props.film?.id },
                                { key: 'room', value: props.room?.id },
                                { key: 'time', value: props.time?.id }
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
                            <p className="mb-6">{props.cinema?.name || ''}</p>

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
                                                <div>Subtotal: {(product.price * quantity).toFixed(2)}€</div>
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
                                    <li className="mb-4 border rounded p-4 flex flex-col items-center gap-4">
                                        <img src={`/storage/films/${props.film.image}`} alt={props.film.name} className="w-20 h-20 object-cover" />
                                        <div>
                                            <div className="font-semibold">{props.film.name}</div>
                                            <div>x{chairsSelected.length}</div>
                                            <div>Subtotal: {Array.isArray(chairsSelected) && chairsSelected.length > 0 && typeof chairsSelected.reduce === 'function' ? chairsSelected.reduce((acc, chair) => acc + (parseFloat(chair.price) || 0), 0).toFixed(2) : '0.00'}€</div>
                                        </div>
                                    </li>
                                ) : (
                                    <p>{props.lang.noChairsSelected}</p>
                                )}
                        </ul>
                            <h3 className="font-semibold mb-4">Subtotal Products:</h3>
                            <p className="mb-6">
                                {props.selectedProducts && props.selectedProducts.length > 0
                                    ? props.selectedProducts.reduce((acc, [product, quantity]) => acc + product.price * quantity, 0).toFixed(2) + '€'
                                    : '0.00€'}
                            </p>
                            {chairsSelected && chairsSelected.length > 0 ? (
                            <form method="POST" action={route('orders.createByClient')}>
                                <input type="hidden" name="cinema_id" value={props.cinema?.id} />
                                <input type="hidden" name="time_id" value={props.time?.id} />
                                <input type="hidden" name="room_id" value={props.room?.id} />
                                <input type="hidden" name="film_id" value={props.film?.id} />
                                {props.selectedProducts && props.selectedProducts.length > 0 && props.selectedProducts.map(([product, quantity], index) => (
                                    <input key={`product-${index}`} type="hidden" name={`selectedProducts[${index}][0][id]`} value={product.id} />
                                ))}
                                {props.selectedProducts && props.selectedProducts.length > 0 && props.selectedProducts.map(([product, quantity], index) => (
                                    <input key={`quantity-${index}`} type="hidden" name={`selectedProducts[${index}][1]`} value={quantity} />
                                ))}
                                {props.chairsSelected && props.chairsSelected.length > 0 && props.chairsSelected.map((chair, index) => (
                                    <input key={`chair-${index}`} type="hidden" name={`selectedChairs[${index}][id]`} value={chair.id} />
                                ))}
                                <button
                                    type="submit"
                                    className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer"
                                >
                                    {props.langTable.goToPay}
                                </button>
                            </form>
                            ):(null)}
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
