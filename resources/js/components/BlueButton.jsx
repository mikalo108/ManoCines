import React from 'react';
import { Link } from '@inertiajs/react';

const BlueButton = ({ link, children }) => {

  return (
    <Link
      href={route(link)}
      style={{
        backgroundColor: '#007bff',
        color: 'white',
        border: 'none',
        padding: '10px 20px',
        borderRadius: '4px',
        cursor: 'pointer',
        fontSize: '16px',
      }}
    >
      {children}
    </Link>
  );
};

export default BlueButton;
