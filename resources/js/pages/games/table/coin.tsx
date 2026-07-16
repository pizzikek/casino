import { useForm } from '@inertiajs/react';
import LeaveButton from '@/components/forms/leaveButton';
import coin_number from '../../../../images/coin_Number.png'

function Coin(){
    const { post, processing } = useForm({
        email: '',
        password: '',
    });
    function handelLeave(){
        post('/games/leave')
    }

    return (
        <div className="grid h-screen w-screen text-white/60">
            <div className="absolute self-center justify-self-center">
                <img src={coin_number} alt="" className="max-h-120" />
            </div>

            <div className="absolute mb-40 flex w-2/5 justify-around gap-2 self-end justify-self-start">
                <div className="flex flex-col">
                    <div>Hans</div>
                    <div className="rounded-md border border-black bg-gray-950">
                        <div className="m-2">
                            <span className="font-bold">Bet on:</span> Face
                        </div>
                    </div>
                </div>
                <div className="flex flex-col">
                    <div>Hans</div>
                    <div className="rounded-md border border-black bg-gray-950">
                        <div className="m-2">
                            <span className="font-bold">Bet on:</span> Number
                        </div>
                    </div>
                </div>
                <div className="flex flex-col">
                    <div>Hans</div>
                    <div className="rounded-md border border-black bg-gray-950">
                        <div className="m-2">
                            <span className="font-bold">Bet on:</span> Face
                        </div>
                    </div>
                </div>
            </div>

            <div className="absolute mb-40 flex w-2/5 justify-around gap-2 self-end justify-self-end">
                <div className="flex flex-col">
                    <div>Hans</div>
                    <div className="rounded-md border border-black bg-gray-950">
                        <div className="m-2">
                            <span className="font-bold">Bet on:</span> Number
                        </div>
                    </div>
                </div>
                <div className="flex flex-col">
                    <div>Hans</div>
                    <div className="rounded-md border border-black bg-gray-950">
                        <div className="m-2">
                            <span className="font-bold">Bet on:</span>
                        </div>
                    </div>
                </div>
                <div className="flex flex-col">
                    <div>Hans</div>
                    <div className="rounded-md border border-black bg-gray-950">
                        <div className="m-2">
                            <span className="font-bold">Bet on:</span>
                        </div>
                    </div>
                </div>
            </div>

            <div className="place-items-center self-end justify-self-center">
                <div className="mb-2 border-2 border-black">
                    <div className="mx-2">145</div>
                </div>

                <div className="mb-6 rounded-2xl border-2 border-black bg-gray-950">
                    <div className="m-3 flex justify-around">
                        <div className="grid min-h-20 min-w-20 rounded-xl border border-black bg-indigo-400/50 font-bold text-black hover:bg-indigo-500/50">
                            <div className="mx-auto self-center">
                                <button>Number</button>
                            </div>
                        </div>

                        <div className="mx-1 grid">
                            <div className="self-center rounded-md border border-black bg-gray-900">
                                <input type="number" placeholder="Bet:" />
                            </div>
                        </div>

                        <div className="grid min-h-20 min-w-20 rounded-xl border border-black bg-indigo-400/50 font-bold text-black hover:bg-indigo-500/50">
                            <div className="mx-auto self-center">
                                <button>Face</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="absolute self-end justify-self-end">
                <form onSubmit={handelLeave} className="mr-6 mb-6 max-w-24">
                    <LeaveButton disabled={processing} />
                </form>
            </div>
        </div>
    );
}
export default Coin
