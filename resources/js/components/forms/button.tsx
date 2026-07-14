
interface Props{
    label: string;
    disabled: boolean;
}
function Button({label, disabled}: Props){
    return (
        <>
            <button
                type="submit"
                disabled={disabled}
                className="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
            >
                {label}
            </button>
        </>
    );
}
export default Button
