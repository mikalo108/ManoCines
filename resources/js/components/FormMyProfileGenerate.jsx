import React, { useState, useEffect } from 'react';

const FormMyProfileGenerate = ({ element, dataControl, keyElements, lang }) => {
  const [formData, setFormData] = useState({});
  

 useEffect(() => {
  const initialData = {};
  dataControl.forEach(({ key, field, type }) => {
    if (type === 'date' && typeof field === 'object' && field !== null) {
      initialData[`${key}`] = field.fecha || '';
      initialData[`${key}_hour`] = field.hora || '';
      initialData[`${key}_minute`] = field.minuto || '';
    } else {
      initialData[key] = field !== undefined && field !== null ? field : '';
    }
  });
  setFormData(initialData);
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
    } else if (type === 'date') {
      setFormData(prev => ({
        ...prev,
        [key]: e.target.value,
      }));
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
                  src={`/storage/${keyElements}/${field}`}
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
              min={!element ? todayDate : undefined}
              required
              style={{ borderRadius: '10px' }}
              onChange={e => setFormData(prev => ({ ...prev, [key]: e.target.value }))}
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
                if (val === '') {
                  setFormData(prev => ({
                    ...prev,
                    [`${key}_hour`]: ''
                  }));
                } else {
                  val = Math.max(0, Math.min(23, Number(val)));
                  setFormData(prev => ({
                    ...prev,
                    [`${key}_hour`]: val
                  }));
                }
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
                if (val === '') {
                  setFormData(prev => ({
                    ...prev,
                    [`${key}_minute`]: ''
                  }));
                } else {
                  val = Math.max(0, Math.min(59, Number(val)));
                  setFormData(prev => ({
                    ...prev,
                    [`${key}_minute`]: val
                  }));
                }
              }}
              placeholder="MM"
              className="shadow appearance-none border rounded py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-16"
              style={{ borderRadius: '10px' }}
              required
            />
          </div>
        </div>
      );
      case 'password':
        // Si es creación (no hay element), no mostrar checkbox y el campo siempre está activado
        if (!element) {
          return (
            <div key={key} className="mb-4" style={{ position: 'relative' }}>
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
              <label htmlFor={`${key}_confirmation`} className="block text-gray-700 font-bold mb-2 dark:text-white mt-4">
                {lang.confirmPassword || 'Confirm Password'}
              </label>
              <input
                type="password"
                id={`${key}_confirmation`}
                name={`${key}_confirmation`}
                value={formData[`${key}_confirmation`] || ''}
                required
                style={{ borderRadius: '10px' }}
                onChange={e => setFormData(prev => ({ ...prev, [`${key}_confirmation`]: e.target.value }))}
                className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                autoComplete="new-password"
              />
              {formData[key] && formData[`${key}_confirmation`] && formData[key] !== formData[`${key}_confirmation`] && (
                <div className="text-red-500 text-sm mt-1">
                  {lang.passwordsDoNotMatch || 'Passwords do not match'}
                </div>
              )}
            </div>
          );
        } else {
            return (
            <div key={key} className="mb-4" style={{ position: 'relative' }}>
              <div className="flex items-center mb-2">
                
              <input
                type="checkbox"
                id={`${key}_enable`}
                style={{ marginRight: '10px', position: 'relative', left: 0, top: 0 }}
                checked={!!formData[`${key}_enabled`]}
                  onChange={e => {
                  setFormData(prev => {
                    let updated = { ...prev };
                    if (e.target.checked) {
                    // Restore password and confirmation if they exist
                    if (prev[`${key}_temp`] !== undefined) {
                      updated[key] = prev[`${key}_temp`];
                    }
                    if (prev[`${key}_confirmation_temp`] !== undefined) {
                      updated[`${key}_confirmation`] = prev[`${key}_confirmation_temp`];
                    }
                    updated[`${key}_enabled`] = true;
                    } else {
                    // Store current password and confirmation temporarily
                    updated[`${key}_temp`] = prev[key] || '';
                    updated[`${key}_confirmation_temp`] = prev[`${key}_confirmation`] || '';
                    updated[key] = '';
                    updated[`${key}_confirmation`] = '';
                    updated[`${key}_enabled`] = false;
                    }
                      return updated;
                      })}}
                      />
                    <label htmlFor={key} className="block text-gray-700 font-bold dark:text-white" style={{ flex: 1 }}>
                      {key.charAt(0).toUpperCase() + key.slice(1)}
                    </label>
                    {!formData[`${key}_enabled`]}
                  </div>
                  <input
                    type="password"
                    id={key}
                    name={key}
                    value={formData[key] || ''}
                    required={!!formData[`${key}_enabled`]}
                    style={{
                    borderRadius: '10px',
                    backgroundColor: !formData[`${key}_enabled`] ? '#d1d5db' : undefined,
                    userSelect: !formData[`${key}_enabled`] ? 'none' : undefined,
                    cursor: !formData[`${key}_enabled`] ? 'not-allowed' : undefined,
                    }}
                    onChange={e => setFormData(prev => ({
                    ...prev,
                    [key]: formData[`${key}_enabled`] ? e.target.value : prev[key],
                    [`${key}_temp`]: prev[`${key}_temp`] !== undefined ? prev[`${key}_temp`] : prev[key]
                    }))}
                    className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    autoComplete="new-password"
                    disabled={!formData[`${key}_enabled`]}
                  />
                  {formData[`${key}_enabled`] && (
                    <>
                      <label htmlFor={`${key}_confirmation`} className="block text-gray-700 font-bold mb-2 dark:text-white mt-4">
                        {lang.confirmPassword || 'Confirm Password'}
                      </label>
                      <input
                        type="password"
                        id={`${key}_confirmation`}
                        name={`${key}_confirmation`}
                        value={formData[`${key}_confirmation`] || ''}
                        required={!!formData[`${key}_enabled`]}
                        style={{ borderRadius: '10px' }}
                        onChange={e => setFormData(prev => ({
                          ...prev,
                          [`${key}_confirmation`]: e.target.value,
                          [`${key}_confirmation_temp`]: prev[`${key}_confirmation_temp`] !== undefined ? prev[`${key}_confirmation_temp`] : prev[`${key}_confirmation`]
                        }))}
                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        autoComplete="new-password"
                        disabled={!formData[`${key}_enabled`]}
                      />
                    </>
                  )}
                  {formData[key] && formData[`${key}_confirmation`] && formData[key] !== formData[`${key}_confirmation`] && (
                    <div className="text-red-500 text-sm mt-1">
                      {lang.passwordsDoNotMatch || 'Passwords do not match'}
                    </div>
                  )}
                </div>
            );
        }
      case 'text':
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
          required
          style={{ borderRadius: '10px' }}
          onChange={e => handleChange(e, key, type)}
          className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        />
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
      default:
        return null;
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    // Password confirmation validation
    let passwordError = false;
    dataControl.forEach(({ key, type }) => {
      if (type === 'password') {
        // Solo validar si está activado el cambio de contraseña o si es creación
        if (!element || formData[`${key}_enabled`]) {
          if (formData[key] !== formData[`${key}_confirmation`]) {
            passwordError = true;
          }
        }
      }
    });
    if (passwordError) {
      alert(lang.passwordsDoNotMatch || 'Passwords do not match');
      return;
    }

    const form = new FormData();
    dataControl.forEach(({ key, type }) => {
      if (type === 'image') {
        // If a new file is selected, append the file object; otherwise, append the existing filename if present
        if (formData[`${key}_file`]) {
          form.append(key, formData[`${key}_file`]);
        } else if (formData[key]) {
          form.append(key, formData[key]);
        } else {
          form.append(key, '');
        }
      } else if (type === 'date') {
        const hour = formData[`${key}_hour`] !== '' ? formData[`${key}_hour`] : '0';
        const minute = formData[`${key}_minute`] !== '' ? formData[`${key}_minute`] : '0';
        form.append(key, formData[key] || '');
        form.append(`${key}_hour`, hour);
        form.append(`${key}_minute`, minute);
      } else if (type === 'password') {
          if (!element || formData[`${key}_enabled`]) {
            form.append(key, formData[key] || '');
            form.append(`${key}_confirmation`, formData[`${key}_confirmation`] || '');
          }
      } else {
        form.append(key, formData[key] !== undefined ? formData[key] : '');
      }
    });

    let url, method;
    if (element) {
      url = `/${keyElements}/updateMyProfile/${element.id}`;
      method = 'POST';
      form.append('_method', 'put');
    } else {
      url = `/${keyElements}/store`;
      method = 'POST';
    }

    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
    fetch(url, {
      method: method,
      body: form,
      headers: {
        'X-CSRF-TOKEN': csrfToken,
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
        if (data && data.message) {
          alert(data.message);
        }
      })
      .catch(error => {
        console.error(error);
      });
  };

  return (
    <form onSubmit={handleSubmit}>
      {dataControl.map(({ key, field, type, posibilities }) => (
        renderInputField({ key, field, type, posibilities })
      ))}
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

export default FormMyProfileGenerate;