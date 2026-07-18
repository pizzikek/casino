import { useForm } from '@inertiajs/react';
import { useEcho } from '@laravel/echo-react';
import { useState } from 'react';
import coin_number from '../../../../images/coin_Number.png'

function Coin({ list_players, user }: any) {
    console.log(list_players)
    const [ players, setPlayers] = useState(list_players)

    const { data, setData, processing, post, errors } = useForm({
        bet: '',
    });

    const betNumber = (e: any) => {
        e.preventDefault();
        post('/games/coin/num');
    };

    const betFace = (e: any) => {
        e.preventDefault();
        post('/games/coin/face');
    };

    useEcho('coin', ['.user-left', '.user-joined'], (e) => {
        console.log(e)

    });

    return (
        <div className="grid h-screen w-screen text-white/60">
            <div className="absolute self-center justify-self-center">
                <img src={coin_number} alt="" className="max-h-120" />
            </div>

            <div className="absolute mb-40 flex w-2/5 justify-around gap-2 self-end justify-self-start">
                {players.map((item: any) => (
                    <div className="flex flex-col" key={item.id}>
                        <div>{item['username']}</div>
                        <div className="rounded-md border border-black bg-gray-950">
                            <div className="m-2">
                                <span className="font-bold">Bet on:</span>{' '}
                                {item['action_table']}
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            <div className="absolute mb-40 flex w-2/5 justify-around gap-2 self-end justify-self-end"></div>

            <div className="place-items-center self-end justify-self-center">
                <div className="mb-2 border-2 border-black">
                    <div className="mx-2">{user.points_curr_table}</div>
                </div>

                <div className="mb-6 rounded-2xl border-2 border-black bg-gray-950">
                    <div
                        className="m-3 flex justify-around"
                        hidden={user.curr_bet}
                    >
                        <div className="grid min-h-20 min-w-20 rounded-xl border border-black bg-indigo-400/50 font-bold text-black hover:bg-indigo-500/50">
                            <div className="mx-auto self-center">
                                <button
                                    onClick={betNumber}
                                    disabled={processing}
                                >
                                    Number
                                </button>
                            </div>
                        </div>

                        <div className="mx-1 grid">
                            <div className="self-center rounded-md border border-black bg-gray-900">
                                <input
                                    type="number"
                                    placeholder="Bet:"
                                    value={data.bet}
                                    onChange={(e) =>
                                        setData('bet', e.target.value)
                                    }
                                />
                                <div className="text-red-600">
                                    {errors.bet && (
                                        <div className="error">
                                            {errors.bet}
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        <div className="grid min-h-20 min-w-20 rounded-xl border border-black bg-indigo-400/50 font-bold text-black hover:bg-indigo-500/50">
                            <div className="mx-auto self-center">
                                <button onClick={betFace} disabled={processing}>
                                    Face
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        className="m-3 flex justify-around"
                        hidden={!user.curr_bet}
                    >
                        <div>Wait until throw</div>
                    </div>
                </div>
            </div>

            <div className="absolute self-end justify-self-end">
                <div className="m-6">
                    <a href="/games/leave">
                        <button className="flex w-full justify-center rounded-md bg-red-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-red-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                            Leave
                        </button>
                    </a>
                </div>
            </div>
        </div>
    );
}
export default Coin
