import React, { useState, useEffect } from 'react';

const FormGenerate = ({ element, dataControl, keyElements, lang }) => {
  const [formData, setFormData] = useState({});

  useEffect(() => {
    if (element) {
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
      const initialData = {};
      dataControl.forEach(({ key, field }) => {
        initialData[key] = field !== undefined && field !== null ? field : '';
      });
      setFormData(initialData);
    }
  }, [element, dataControl]);

  const handleChange = (e, key, type) => {
    if (type === 'image') {
      const file = e.target.files && e.target.files[0];
      setFormData(prev => ({
        ...prev,
        [key]: file ? file.name : '',
        [`${key}_file`]: file || null,
        [`${key}_preview`]: undefined,
      }));
      if (file) {
        const reader = new FileReader();
        reader.onload = (ev) => {
          setFormData(prev => ({
            ...prev,
            [`${key}_preview`]: ev.target.result,
          }));
        };
        reader.readAsDataURL(file);
      }
    } else {
      setFormData(prev => ({
        ...prev,
        [key]: e.target.value,
      }));
    }
  };

  const todayDate = new Date().toISOString().split('T')[0];

  const renderInputField = ({ key, field, type, posibilities }) => {
    switch (type) {
      case 'hidden':
        if (!field) return null;
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key.charAt(0).toUpperCase() + key.slice(1)} <span className='text-red-500' style={{float:'right'}}>{lang.noChange}</span>
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
      case 'image':
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key.charAt(0).toUpperCase() + key.slice(1)}
            </label>
            <input
              type="file"
              id={key}
              name={key}
              accept="image/*"
              onChange={e => handleChange(e, key, type)}
              className="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              style={{ borderRadius: '10px', width: '100%', marginBottom: '16px' }}
              title={field ? field : ''}
            />
            <div className="flex flex-row items-center space-x-4 mb-2"></div>
            <div className="flex flex-row items-center space-x-4 mb-2">
              {field && (
                <img
                  src={`/storage/films/${field}`}
                  alt={key}
                  className="max-w-md h-40 object-contain border"
                  style={{ background: '#f3f3f3', borderRadius: '8px' }}
                />
              )}
              {field && formData[`${key}_preview`] && (
                <span className="mx-2 text-2xl">→</span>
              )}
              {formData[`${key}_preview`] && (
                <img
                  src={formData[`${key}_preview`]}
                  alt="preview"
                  className="max-w-md h-40 object-contain border"
                  style={{ background: '#f3f3f3', borderRadius: '8px' }}
                />
              )}
            </div>
            <div className="text-gray-500 text-sm mt-1">
              {field || formData[`${key}_preview`] ? '' : 'Ninguna imagen seleccionada'}
            </div>
          </div>
        );
      case 'number':
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key.charAt(0).toUpperCase() + key.slice(1)}
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
              onChange={e => handleChange(e, key, type)}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
        );
      case 'select':
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key.charAt(0).toUpperCase() + key.slice(1)}
            </label>
            <select
              id={key}
              name={key}
              value={formData[key] || ''}
              style={{ borderRadius: '10px' }}
              onChange={e => handleChange(e, key, type)}
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
              {key.charAt(0).toUpperCase() + key.slice(1)}
            </label>
            <div className="flex flex-row gap-2 items-center">
              <input
          type="date"
          id={key}
          name={key}
          value={formData[key] || ''}
          min={todayDate}
          required
          style={{ borderRadius: '10px' }}
          onChange={e => handleChange(e, key, type)}
          className="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              />
              <input
          type="number"
          min={0}
          max={23}
          name={`${key}_hour`}
          value={formData[`${key}_hour`] || ''}
          onChange={e => {
            let val = e.target.value;
            if (val === '') val = '';
            else val = Math.max(0, Math.min(23, Number(val)));
            setFormData(prev => ({
              ...prev,
              [`${key}_hour`]: val
            }));
          }}
          placeholder="HH"
          className="shadow appearance-none border rounded py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-16"
          style={{ borderRadius: '10px' }}
          required
              />
              <span>:</span>
              <input
          type="number"
          min={0}
          max={59}
          name={`${key}_minute`}
          value={formData[`${key}_minute`] || ''}
          onChange={e => {
            let val = e.target.value;
            if (val === '') val = '';
            else val = Math.max(0, Math.min(59, Number(val)));
            setFormData(prev => ({
              ...prev,
              [`${key}_minute`]: val
            }));
          }}
          placeholder="MM"
          className="shadow appearance-none border rounded py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-16"
          style={{ borderRadius: '10px' }}
          required
              />
            </div>
          </div>
        );
      case 'email':
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key.charAt(0).toUpperCase() + key.slice(1)}
            </label>
            <input
              type="email"
              id={key}
              name={key}
              value={formData[key] || ''}
              required
              style={{ borderRadius: '10px' }}
              onChange={e => handleChange(e, key, type)}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
        );
      case 'password':
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key.charAt(0).toUpperCase() + key.slice(1)}
            </label>
            <input
              type="password"
              id={key}
              name={key}
              value={formData[key] || ''}
              required
              style={{ borderRadius: '10px' }}
              onChange={e => handleChange(e, key, type)}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              autoComplete="new-password"
            />
          </div>
        );
      
      case 'text':
      default:
        return (
          <div key={key} className="mb-4">
            <label htmlFor={key} className="block text-gray-700 font-bold mb-2 dark:text-white">
              {key.charAt(0).toUpperCase() + key.slice(1)}
            </label>
            <input
              type="text"
              id={key}
              name={key}
              value={formData[key] || ''}
              style={{ borderRadius: '10px' }}
              onChange={e => handleChange(e, key, type)}
              className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
        );
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const form = new FormData();
    dataControl.forEach(({ key, type }) => {
      if (type === 'image' && formData[`${key}_file`]) {
        form.append(key, formData[`${key}_file`]);
      } else {
        form.append(key, formData[key]);
      }
    });

    let url, method;
    if (element) {
      url = `/films/${element}`;
      method = 'POST';
      form.append('_method', 'put');
    } else {
      url = '/films';
      method = 'POST';
    }

    fetch(url, {
      method: method,
      body: form,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json',
      },
      credentials: 'same-origin',
    })
      .then(response => {
        if (response.redirected) {
          window.location.href = response.url;
        } else {
          return response.json();
        }
      })
      .then(data => {
        // Puedes manejar mensajes de éxito o error aquí
        if (data && data.message) {
          alert(data.message);
        }
      })
      .catch(error => {
        console.error(error);
      });
  };

  return (
    <form 
      onSubmit={handleSubmit}
      encType="multipart/form-data"
    >
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