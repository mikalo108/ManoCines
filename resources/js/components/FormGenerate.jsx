import { right } from '@popperjs/core';
import React, { useState, useEffect } from 'react';

const FormGenerate = ({ element, dataControl, keyElements, lang }) => {
  const [formData, setFormData] = useState({});

  useEffect(() => {
    if (element) {
      // Initialize formData with keys from dataControl and values from element if exist
      const initialData = {};
      dataControl.forEach(({ key, field }) => {
        if (element[key] !== undefined && element[key] !== null) {
          initialData[key] = element[key];
        } else if (field !== undefined && field !== null) {
          initialData[key] = field;
        } else {
          initialData[key] = '';
        }
      });
      setFormData(initialData);
    } else {
      // No element, initialize with empty strings or field values if provided
      const initialData = {};
      dataControl.forEach(({ key, field }) => {
        initialData[key] = field !== undefined && field !== null ? field : '';
      });
      setFormData(initialData);
    }
  }, [element, dataControl]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value,
    }));
  };

  const todayDate = new Date().toISOString().split('T')[0];

  const renderInputField = ({ key, field, type, posibilities }) => {
    switch (type) {
      case 'hidden':
        if (!field) {
          return null;
        }
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key} <span className='text-red-500' style={{float:'right'}}>{lang.noChange}</span>
            </label>
            <input
              type="text"
              id={key}
              name={key}
              value={formData[key] || ''}
              style={{ borderRadius: '10px' }}
              readOnly
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200 cursor-not-allowed"
            />
          </div>
        );
      case 'number':
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key}
            </label>
            <input
              type="number"
              id={key}
              name={key}
              required
              value={formData[key] || ''}
              min={1}
              max={posibilities || ''}
              style={{ borderRadius: '10px' }}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
        );
      case 'select':
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key}
            </label>
            <select
              id={key}
              name={key}
              value={formData[key] || ''}
              style={{ borderRadius: '10px' }}
              onChange={handleChange}
              required
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
              <option value="" disabled>Select an option</option>
              {Array.isArray(posibilities) && posibilities.map((option) => (
                <option key={option} value={option}>
                  {option}
                </option>
              ))}
            </select>
          </div>
        );
      case 'date':
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key}
            </label>
            <input
              type="date"
              id={key}
              name={key}
              value={formData[key] || ''}
              min={todayDate}
              required
              style={{ borderRadius: '10px' }}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
        );
      case 'text':
      default:
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key}
            </label>
            <input
              type="text"
              id={key}
              name={key}
              value={formData[key] || ''}
              style={{ borderRadius: '10px' }}
              onChange={handleChange}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
        );
    }
  };

  return (
    <form action={element ? route(`${keyElements}.update`, element) : route(`${keyElements}.store`)}>
      {dataControl.map(({ key, field, type, posibilities }) => {
        if ((element && element[key] !== undefined) || field !== undefined) {
          return renderInputField({ key, field, type, posibilities });
        }
        return null;
      })}
      <input
        style={{
          backgroundColor: '#007bff',
          color: 'white',
          border: 'none',
          padding: '10px 20px',
          borderRadius: '4px',
          cursor: 'pointer',
          fontSize: '16px',
          width: '100%',
          marginTop: '40px',
        }}
        type="submit"
        value={element ? lang.updateButton : lang.createButton}
      />
    </form>
  );
};

export default FormGenerate;
