import React from 'react';

export default function ChairIcon({ occupied, selected }) {
    let fillColor = '#000000'; // default black
    if (occupied) {
        fillColor = '#dc2626'; // red if occupied
    } else if (selected) {
        fillColor = '#2563eb'; // blue if selected
    }

    const selectedStyle = selected ? { filter: 'drop-shadow(0 0 5px #3b82f6)' } : {};

    return (
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill={fillColor}
            stroke="#333"
            strokeWidth="1"
            viewBox="0 0 24 24"
            width="32"
            height="32"
            style={{ margin: 'auto', backgroundColor: '#eee', borderRadius: '4px', ...selectedStyle, cursor: occupied ? 'not-allowed' : 'pointer', display: 'block' }}
        >
            <path d="M7 7h10v5H7z" />
            <path d="M5 12h14v7H5z" />
            <path d="M7 19h2v2H7zM15 19h2v2h-2z" />
        </svg>
    );
}
