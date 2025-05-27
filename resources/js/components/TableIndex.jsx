import React from 'react';
import ActionButtons from '@/components/ActionButtons';

export default function TableIndex({ columnsTable, items, keyTable }) {

    const columnsTableArray = Object.entries(columnsTable);

    if (!columnsTableArray || !Array.isArray(columnsTableArray)) {
        return <div>No column headers provided</div>;
    }

    if (!items || !Array.isArray(items)) {
        return <div>No data available</div>;
    }

    return (
        <>
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
                                            ) : (
                                                item[column[0]]
                                            )}
                                        </td>
                                    );
                                })}
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
            
        </>
    );
}
