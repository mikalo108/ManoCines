import React from 'react';
import { Link } from '@inertiajs/react';

const BlueButton = ({ link, params, children }) => {

  let href;

  if (params) {
    if (Array.isArray(params)) {
      const paramObj = {};
      params.forEach(param => {
        paramObj[param.key] = param.value;
      });
      href = route(link, paramObj);
    } else {
      href = route(link, params);
    }
  } else {
    href = route(link);
  }
  return (
    <Link
      href={href}
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
