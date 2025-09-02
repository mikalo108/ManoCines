import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, router, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import BlueButton from '@/components/BlueButton';

export default function IndexBarProducts(props) {
    const user = usePage().props.auth.user;
    const [selectedCategory, setSelectedCategory] = useState(props.categories.length > 0 ? Object.keys(props.categories[0])[0] : '');
    const [selectedProducts, setSelectedProducts] = useState({}); // productId => quantity
    const [expandedProductIds, setExpandedProductIds] = useState(new Set());

    useEffect(() => {
        if (!user || user?.role === 'Admin') {
            router.get(route('orders.index'));
        }
    }, [user]);

    const Layout = (() => {
        if (user && user.role === 'Admin') {
            return AdminLayout;
        } else if (user) {
            return AuthenticatedLayout;
        } else {
            return GuestLayout;
        }
    })();

    const toggleProductExpand = (productId) => {
        const newSet = new Set(expandedProductIds);
        if (newSet.has(productId)) {
            newSet.delete(productId);
        } else {
            newSet.add(productId);
        }
        setExpandedProductIds(newSet);
    };

    const handleQuantityChange = (productId, quantity) => {
        setSelectedProducts(prev => ({
            ...prev,
            [productId]: quantity > 0 ? quantity : undefined
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        // Prepare array as [[productData, quantity], ...]
        const selectedArray = Object.entries(selectedProducts).map(([id, qty]) => {
            const product = props.categories.flatMap(cat => Object.values(cat)[0]).find(p => p.id.toString() === id);
            return [product, qty];
        }).filter(item => item[1] !== undefined);

        // Send data to orders.details route with parameters
        router.post(route('orders.details'), {
            selectedProducts: selectedArray,
        });
    };

    if (props.auth.user.role !== 'Admin') {
        return (
            <Layout
                currentPage={"products"}
                locale={props.locale}
                auth={props.auth}
                lang={props.lang}
            >
                <Head title={"Bar Products"} />
                <div className="relative flex min-h-screen flex-col selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full px-6 flex flex-col items-center">
                        <div className="flex justify-between mb-4" style={{ width: '50%' }}>
                            <BlueButton link={"chairs.time"} params={[
                                { key: 'cinema', value: props.cinema_id },
                                { key: 'film', value: props.film_id },
                                { key: 'room', value: props.room_id },
                                { key: 'time', value: props.time_id }
                            ]}>{props.lang.back}</BlueButton>
                            <button
                                type="submit"
                                form="productSelectionForm"
                                className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                            >
                                {props.lang.next}
                            </button>
                        </div>
                        <h1 className='text-black dark:text-white mt-8 font-bold' style={{ fontWeight: 'bolder', width: '100%', textAlign: 'center' }}>{props.langTable.titleClient}</h1>
                        <h2 className='mb-8' style={{ textAlign: 'center' }}>{props.langTable.subtitleClient}</h2>
                        <h3 className='mb-12' style={{ textAlign: 'center' }}>{props.langTable.infoYouCanDo}</h3>

                        <div className="w-full max-w-4xl">
                            <div className="flex space-x-4 mb-4 flex justify-center">
                                {props.categories.map((category, idx) => {
                                    const categoryName = Object.keys(category)[0];
                                    return (
                                        <button
                                            key={idx}
                                            className={`px-4 py-2 rounded ${selectedCategory === categoryName ? 'bg-blue-600 text-white' : 'bg-gray-200 text-black'}`}
                                            onClick={() => setSelectedCategory(categoryName)}
                                        >
                                            {categoryName}
                                        </button>
                                    );
                                })}
                            </div>

                            <form id="productSelectionForm" onSubmit={handleSubmit}>
                                {props.categories.map((category, idx) => {
                                    const categoryName = Object.keys(category)[0];
                                    const products = category[categoryName];
                                    if (categoryName !== selectedCategory) return null;
                                    return (
                                        <div key={idx} className="space-y-2">
                                            {products.map(product => (
                                                <div key={product.id} className="border rounded p-2">
                                                    <div className="flex items-center cursor-pointer" onClick={() => toggleProductExpand(product.id)}>
                                                        <img src={`/storage/products/${product.image}`} alt={product.name} className="w-16 h-16 object-cover mr-4" />
                                                        <div className="flex-grow">
                                                            <div className="font-semibold">{product.name}</div>
                                                            <div>{product.price}€</div>
                                                        </div>
                                                    </div>
                                                    {expandedProductIds.has(product.id) && (
                                                        <div className="mt-2">
                                                            <div className="mb-2">{product.description}</div>
                                                            <input
                                                                type="number"
                                                                min="0"
                                                                value={selectedProducts[product.id] || ''}
                                                                onChange={e => handleQuantityChange(product.id, parseInt(e.target.value) || 0)}
                                                                className="border rounded p-1 w-20"
                                                            />
                                                        </div>
                                                    )}
                                                </div>
                                            ))}
                                        </div>
                                    );
                                })}
                            </form>
                        </div>
                    </div>
                </div>
            </Layout>
        );
    } else {
        router.get(route('products.index'));
        return null;
    }
}
