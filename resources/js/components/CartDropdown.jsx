import { useState } from 'react';
import { Head, router, usePage } from '@inertiajs/react';
import BlueButton from '@/components/BlueButton';
import { left } from '@popperjs/core';

export default function CartDropdown({ auth }) {
    const [isOpen, setIsOpen] = useState(false);
    const { chairsSelected, selectedProducts, langTableChair, film_id, room_id, time_id, lang, allFilms, allRooms, allTimes} = usePage().props;
    const film = allFilms.find(f => f.id == film_id);
    const room = allRooms.find(r => r.id == room_id);
    const time = allTimes.find(t => t.id == time_id);
    const timeStr = time ? time.time.slice(5,-3) : '';

    const handleSubmit = (e) => {
            e.preventDefault();
    
            // Send data to orders.details route with parameters
            router.post(route('orders.details'), {
                selectedProducts: selectedProducts,
            });
        };

    
    if (auth.user && !auth.user.is_admin) {
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" className="h-8 w-8 text-gray-600">
                        <path d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        <span className="absolute -top-2 left-9 rounded-full bg-red-500 p-0.5 px-2 text-sm text-red-50">
                            {chairsSelected && chairsSelected.length > 0 ? (
                                <ul className="list-disc list-inside">
                                    {chairsSelected.length + selectedProducts.reduce((acc, [, quantity]) => acc + quantity, 0)}
                                </ul>
                            ) : (
                                0
                            )}
                        </span>
                    </button>
                </div>
                {isOpen && (
                    <div className="absolute w-[800%] max-md:w-[600%] max-md:left-1/2 max-md:-translate-x-1/2 md:right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-700" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabIndex="-1">
                        <div className="py-1" role="none">
                            {chairsSelected && chairsSelected.length > 0 ? (
                                <div>
                                    <ul className='relative left-6' style={{ listStyleType: 'none', paddingInline: '10%'}}>
                                        <li style={{ paddingBottom:'10px', marginTop:'15px', borderBottom: '1px solid #ccc', width:'80%' }} className='mb-2'>
                                            <strong className='text-xl relative right-4'>{chairsSelected && chairsSelected.length > 0 ? (<span>{chairsSelected.length}</span>) : (0)}x</strong>
                                            <span className='text-xl font-medium text-gray-600'>
                                                {lang.room} {room ? room.number : ''} - {film ? film.name : ''} 
                                            </span> 
                                            <div className='align-items-right justify-items-right text-right relative right-7'>
                                            <strong>{time ? timeStr : ''}</strong>
                                            </div>
                                            <ul className="list-disc list-inside">
                                                {chairsSelected.map((chair, index) => (
                                                    <li key={chair.id ?? index} className="flex items-center justify-between">
                                                        <span>    - {langTableChair.columns.row} {chair.row} - {langTableChair.columns.column} {chair.column}</span> | <strong>{chair.price}€</strong>
                                                    </li>
                                                ))}
                                            </ul>
                                        </li>
                                        <li style={{ paddingBottom:'10px', marginTop:'15px', borderBottom: '1px solid #ccc', width:'80%' }}>
                                            <strong className='text-xl relative right-4'>
                                                {selectedProducts && selectedProducts.length > 0 ? (
                                                    <span>{
                                                        selectedProducts.reduce((acc, [, quantity]) => acc + quantity, 0)
                                                    }</span>
                                                    ) : (0)
                                                }x</strong>
                                            <span  className='text-xl font-medium text-gray-600'>{lang.products}: </span> 
                                            <ul className="list-disc list-inside">
                                                {selectedProducts.map(([product, quantity], index) => (
                                                    <li key={product.id ?? index} className="flex items-center justify-between">
                                                        <span> <strong className='text-sm relative right-3'><span>{quantity}x</span></strong>{product.name}</span> | <strong>{product.price}€</strong>
                                                    </li>
                                                ))}
                                            </ul>   
                                        </li>
                                        <li style={{ paddingBottom:'10px', marginTop:'15px', width:'80%' }} className='mt-2 flex flex-col items-start justify-start'> 
                                            <div className='text-2xl font-semibold text-gray-600'>
                                                <span>Subtotal:</span>
                                                <span className='text-2xl font-bold text-gray-600 relative left-2'>
                                                    {((chairsSelected && chairsSelected.length > 0 && typeof chairsSelected.reduce === 'function' ? chairsSelected.reduce((acc, chair) => acc + (parseFloat(chair.price) || 0), 0) : 0) + (selectedProducts && selectedProducts.length > 0 ? selectedProducts.reduce((acc, [product, quantity]) => acc + product.price * quantity, 0) : 0)).toFixed(2)}€
                                                </span>
                                            </div>
                                            <div>
                                                {lang.taxIncluded}
                                            </div>
                                            <div className='text-2xl font-bold text-gray-900 relative' style={{ border: '1px solid #2d2d2dff', marginTop: '10px', paddingTop: '10px', paddingBlock: '10px', paddingLeft: '20px', paddingRight: '20px', borderRadius: '5px' }}>
                                                <span>Total:</span>
                                                <span className='text-2xl font-bold text-gray-900 relative left-2'>
                                                    {((((chairsSelected && chairsSelected.length > 0 && typeof chairsSelected.reduce === 'function' ? chairsSelected.reduce((acc, chair) => acc + (parseFloat(chair.price) || 0), 0) : 0) + (selectedProducts && selectedProducts.length > 0 ? selectedProducts.reduce((acc, [product, quantity]) => acc + product.price * quantity, 0) : 0))) * 1.21).toFixed(2)}€
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                    <div className='flex justify-center mb-4 mt-2'>
                                        <form id="productSelectionForm" onSubmit={handleSubmit}>
                                            <button
                                                type="submit"
                                                className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                            >
                                                {lang.goToCart}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                            ) : (
                                <p>{lang.emptyCart}</p>
                            )}
                                
                        </div>
                    </div>
                )}
            </div>
        )
    }

}