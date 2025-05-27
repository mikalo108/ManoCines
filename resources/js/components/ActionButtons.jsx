import React from 'react';
import { Link } from '@inertiajs/react';

export default function ActionButtons({ item, keyTable }) {

    return (
        <div className="flex space-x-2">
            <div style={{ display: 'inline' }}>
                <Link
                    href={route(`${keyTable}.edit`, item.id)}
                    className="px-3 py-1 text-sm text-white rounded hover:bg-gray-200 flex items-center justify-center"
                >
                <img src="storage/general/pencil-solid.svg" style={{height: '20px', marginBlock:'7.5px', width:'50px', textAlign: 'center'}} alt="Edit" />
            </Link>
            </div>
            
            <form
                method="delete"
                action={route(`${keyTable}.destroy`, item.id)}
                onSubmit={e => {
                    if (!confirm('¿Estás seguro de que deseas borrar este elemento?')) e.preventDefault();
                }}
                style={{ display: 'inline' }}
            >
                <input type="hidden" name="_method" value="delete" />
                <button
                    type="submit"
                    className="px-3 py-1 text-sm text-white rounded hover:bg-gray-200 flex items-center justify-center"
                >
                    <img src="storage/general/trash-solid.svg" style={{height: '20px', marginBlock:'7.5px', width:'50px', textAlign: 'center'}} alt="Borrar" />
                </button>
            </form>
        </div>
    );
}
