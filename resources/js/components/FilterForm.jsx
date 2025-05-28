import React, { useState } from 'react';

const FilterForm = ({ fieldsCanFilter, onFilter, lang }) => {

  const initialState = fieldsCanFilter.reduce((acc, field) => {
    acc[field] = '';
    return acc;
  }, {});

  const [filters, setFilters] = useState(initialState);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFilters((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onFilter(filters);
  };

  const handleReset = () => {
    setFilters(initialState);
    onFilter(initialState);
  };

return (
    <form
        onSubmit={handleSubmit}
        className="filter-form grid grid-rows-[minmax(0,_1fr)] grid-cols-3 md:grid-cols-2 gap-7 py-5 max-md:grid-cols-1 max-md:grid-rows-3"
        style={{ alignItems: 'center', justifyItems: 'center' }}
    >
        {fieldsCanFilter.map((field) => (
            <div key={field.key} className="filter-field grid grid-rows-1 grid-cols-2" style={{ alignItems: 'center' }}>
                <label htmlFor={field.key} className="filter-label gap-7">
                    {field.key.charAt(0).toUpperCase() + field.key.slice(1)}:
                </label>
                <input
                    type="text"
                    style={{ borderRadius: '10px' }}
                    id={field.key}
                    name={field.key}
                    value={filters[field.value]}
                    onChange={handleChange}
                    className="filter-input"
                />
            </div>
        ))}
        <div className="col-span-3 md:col-span-2 flex w-full justify-between mt-2 max-md:col-span-1" style={{ marginBottom: '15px' }}>
            <button
                type="submit"
                className="btn btn-primary px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition"
            >
                {lang.filterButton}
            </button>
            <button
                type="button"
                onClick={handleReset}
                className="btn btn-secondary px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400 transition"
            >
                {lang.clearFilterButton}
            </button>
        </div>
    </form>
);
};

export default FilterForm;
