import React from 'react';
import { Link } from '@inertiajs/react';
import ActionButtons from '@/components/ActionButtons';

export default function TableIndex({ columnsTable, items, keyTable, pagination, onPageChange }) {
    const columnsTableArray = Object.entries(columnsTable);

if (!columnsTableArray || !Array.isArray(columnsTableArray)) {
    return <div>No column headers provided</div>;
}

if (!items || !Array.isArray(items)) {
    return <div>No data available</div>;
}

const currentPage = pagination?.current_page || 1;
const totalPages = pagination?.last_page || 1;

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages) {
        onPageChange(page);
    }
};

return (
    <>
        <Link
            href={route(`${keyTable}.create`)}
            className="flex mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center"
            style={{ justifyContent: 'center', width: '100%', alignSelf: 'center' }}
        >
            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
            </svg>
        </Link>
        <div className="overflow-x-auto">
            <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                    <tr>
                        {columnsTableArray.map((column) => (
                            <th
                                key={column[0]}
                                className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                {column[1]}
                            </th>
                        ))}
                    </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                    {items.map((item) => (
                        <tr key={item.id}>
                            {columnsTableArray.map((column) => {
                                const style = column[0] === 'actions'
                                    ? { minWidth: '200px' }
                                    : { minWidth: '100px' }
                                return (
                                    <td
                                        style={style}
                                        key={column[0]}
                                        className="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                                    >
                                        {column[0] === 'actions' ? (
                                            <ActionButtons item={item} keyTable={keyTable} />
                                        ) : column[0] === 'image' ? (
                                            <img src={`storage/${keyTable}/${item[column[0]]}`} alt="" />
                                        ) : (
                                            typeof item[column[0]] === 'string' && item[column[0]].length > 30
                                                ? item[column[0]].slice(0, 30) + "..."
                                                : item[column[0]]
                                        )}
                                    </td>
                                );
                            })}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
        <div className="flex justify-center mt-4" style={{ width: '100%' }}>
            <nav className="inline-flex -space-x-px">
                <button
                    className="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700"
                    aria-label="Anterior"
                    onClick={() => goToPage(currentPage - 1)}
                    disabled={currentPage === 1}
                >
                    &lt;
                </button>
                {[...Array(totalPages)].map((_, idx) => (
                    <button
                        key={idx + 1}
                        className={`px-3 py-2 leading-tight border border-gray-300 ${
                            currentPage === idx + 1
                                ? "text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700"
                                : "text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700"
                        }`}
                        onClick={() => goToPage(idx + 1)}
                    >
                        {idx + 1}
                    </button>
                ))}
                <button
                    className="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700"
                    aria-label="Siguiente"
                    onClick={() => goToPage(currentPage + 1)}
                    disabled={currentPage === totalPages}
                >
                    &gt;
                </button>
            </nav>
        </div>
    </>
)
}
