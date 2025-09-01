import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, usePage, router } from '@inertiajs/react';
import BlueButton from '@/components/BlueButton';

export default function OrderDetails(props) {
    const user = usePage().props.auth.user;
    const { chairsSelected, selectedProducts, lang} = usePage().props;
    const subtotal = ((chairsSelected && chairsSelected.length > 0 && typeof chairsSelected.reduce === 'function' ? chairsSelected.reduce((acc, chair) => acc + (parseFloat(chair.price) || 0), 0) : 0) + (selectedProducts && selectedProducts.length > 0 ? selectedProducts.reduce((acc, [product, quantity]) => acc + product.price * quantity, 0) : 0)).toFixed(2);
    const total = ((((chairsSelected && chairsSelected.length > 0 && typeof chairsSelected.reduce === 'function' ? chairsSelected.reduce((acc, chair) => acc + (parseFloat(chair.price) || 0), 0) : 0) + (selectedProducts && selectedProducts.length > 0 ? selectedProducts.reduce((acc, [product, quantity]) => acc + product.price * quantity, 0) : 0))) * 1.21).toFixed(2);


    const handleSubmit = (e) => {
            e.preventDefault();
    
            // Send to orders.createByClient route
            router.post(route('orders.createByClient'), {
                subtotal: subtotal,
                total: total,
            });
        };

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
                            <h3 className="font-semibold mb-4">{lang.cinema}:</h3>
                            <p className="mb-6">{props.cinema?.name || ''}</p>

                            <h3 className="font-semibold mb-4">{lang.selectedProductsText}</h3>
                            <ul className="mb-6 border rounded list-none p-0">
                                {props.selectedProducts && props.selectedProducts.length > 0 ? (
                                    props.selectedProducts.map(([product, quantity], index) => (
                                        <li key={index} className="mb-4 p-4 flex flex-col items-center gap-4">
                                            <img src={`/storage/products/${product.image}`} alt={product.name} className="w-20 h-20 object-cover" />
                                            <div>
                                                <div className="font-semibold">{product.name}</div>
                                                <div>{product.description}</div>
                                                <div>{props.lang.quantity}: {quantity}</div>
                                                <div>Subtotal: {(product.price * quantity).toFixed(2)}€</div>
                                            </div>
                                        </li>
                                    ))
                                ) : (
                                    <p>{lang.noProductsSelected}</p>
                                )}
                            </ul>

                            <h3 className="font-semibold mb-4">{props.lang.selectedChairsTickets}</h3>
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
                        <div style={{ paddingBlock:'50px', marginTop:'15px', width:'100%' }} className='mt-2 flex flex-col items-center justify-center'> 
                            <div className='text-2xl font-semibold text-gray-600'>
                                <span>Subtotal:</span>
                                <span className='text-2xl font-bold text-gray-600 relative left-2'>
                                    {subtotal}€
                                </span>
                            </div>
                            <div>
                                {lang.taxIncluded}
                            </div>
                            <div className='text-2xl font-bold text-gray-900 relative' style={{ border: '1px solid #2d2d2dff', marginTop: '10px', paddingTop: '10px', paddingBlock: '10px', paddingLeft: '20px', paddingRight: '20px', borderRadius: '5px' }}>
                                <span>Total:</span>
                                <span className='text-2xl font-bold text-gray-900 relative left-2'>{total}€</span>
                            </div>
                        </div>
                            {chairsSelected && chairsSelected.length > 0 ? (
                                <form id='payForm' onSubmit={handleSubmit}>
                                    <button
                                        type="submit"
                                        className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer text-xl font-semibold mb-4"
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
