import React from 'react';

interface Props {
    label: string;
    name: string;
    type: 'email' | 'password' | 'text' | 'number';
    id: string;
    value: string;
    onChange: React.ChangeEventHandler<HTMLInputElement>
}
function InputLabel({label, name, type, id, value, onChange }:Props) {
    return (
        <>
            <label
                htmlFor={id}
                className="block text-sm/6 font-medium text-gray-100"
            >
                {label}
            </label>
            <div className="mt-2">
                <input
                    id={id}
                    name={name}
                    type={type}
                    value={value}
                    onChange={onChange}
                    autoComplete={name}

                    className="block w-full max-w-sm rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 border "
                />
            </div>
        </>
    );
}

export default InputLabel
