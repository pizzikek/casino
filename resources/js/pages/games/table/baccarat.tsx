import Card from '@/components/card';
import { useForm } from '@inertiajs/react';
import { useEcho } from '@laravel/echo-react';
import React, { useState } from 'react';

interface Player_vals{
    id: number,
    username: string,
    points_curr_table: number,
    curr_bet: number,
    action_table: string
}

interface BE_vals{
    list_players: Player_vals[],
    user_id: number,
    table_id: string
}

function LeaveBTN() {
    const { processing, post, errors } = useForm();
    const leave = (e: React.FormEvent) => {
        e.preventDefault();
        post('/baccarat/leave');

        if (errors) {
            console.log(errors);
        }
    };

    return (
        <form className="m-6" onSubmit={leave}>
            <button
                disabled={processing}
                type="submit"
                className="flex w-full justify-center rounded-md bg-red-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-red-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
            >
                Leave
            </button>
        </form>
    );
}
function Baccarat({ list_players, user_id, table_id }: BE_vals) {
    const [user, setUser] = useState(
        list_players.filter(
            (player: { id: number }) => player.id == user_id,
        )[0],
    );

    const [players, setPlayers] = useState(
        list_players.filter((player: { id: number }) => player.id !== user_id),
    );



    const {
        data: { bet, bet_on },
        setData,
        processing,
        post,
        errors,
        setError
    } = useForm({
        bet: 0,
        bet_on: '',
    });

    const do_bet = (event: { preventDefault: () => void; }, bet_on: string) => {
        event.preventDefault();
        if (bet > user.points_curr_table){
            setError('bet', "The Bet can not exceed your points inside the table.")
            return
        }
        setUser({
            ...user,
            curr_bet: bet,
            points_curr_table: user.points_curr_table - bet,
            action_table: bet_on
        });
        setData('bet_on', bet_on)
        post('/games/baccarat/bet');
        setData('bet', 0);
    }

    useEcho('baccarat', '.player-list-changed' + table_id, (e: {playerList: Player_vals[], data : object|null}) => {
        setUser(
            e.playerList.filter(
                (player: { id: number }) => player.id == user_id,
            )[0],
        );
        setPlayers(
            e.playerList.filter(
                (player: { id: number }) => player.id !== user_id,
            ),
        );
        console.log(e)
    });


    return (
        <div className="grid h-screen w-screen text-white/60">
            <div className="absolute flex self-center justify-self-center gap-8">
                <div className='flex flex-col'>
                    <div className='mx-auto text-black font-bold text-2xl'>Player: 0</div>
                    <div className='gap-2 flex flex-row'>
                        <Card code='card'/>
                        <Card code='card'/>
                    </div>
                </div>
                <div className='flex flex-col'>
                    <div className='mx-auto text-black font-bold text-2xl'>Banker: 0</div>
                    <div className='gap-2 flex flex-row'>
                        <Card code='card'/>
                        <Card code='card'/>
                    </div>
                </div>
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


            <div className="place-items-center self-end justify-self-center">
                <div className="mb-2 border-2 border-black">
                    <div className="mx-2">{user.points_curr_table}</div>
                </div>

                <div className="mb-6 rounded-2xl border-2 border-black bg-gray-950">
                    <div
                        className="m-3 flex flex-col gap-0.5"
                        hidden={user.curr_bet !== null}
                    >
                        <div className="grid rounded-md min-w-15  mx-auto mb-1 border border-black bg-indigo-500/30 hover:bg-indigo-600/30 font-bold text-white/50">
                            <div className="mx-auto self-center">
                                <button
                                    onClick={(e)=>do_bet(e, 'tie')}
                                    disabled={processing}
                                >
                                    Tie
                                </button>
                            </div>
                        </div>


                        <div className="grid min-h-15 min-w-30 rounded-xl border border-black bg-indigo-400/50 font-bold text-black hover:bg-indigo-500/50">
                            <div className="mx-auto self-center">
                                <button
                                    onClick={(e)=>do_bet(e, 'player')}
                                    disabled={processing}
                                >
                                    Player
                                </button>
                            </div>
                        </div>


                        <div className="grid min-h-15 min-w-30 rounded-xl border border-black bg-indigo-400/50 font-bold text-black hover:bg-indigo-500/50">
                            <div className="mx-auto self-center">
                                <button
                                    onClick={(e)=>do_bet(e, 'banker')}
                                    disabled={processing}
                                >
                                    Banker
                                </button>
                            </div>
                        </div>

                        <div className="mx-1 mt-1 grid">
                            <div className="self-center rounded-md border border-black bg-gray-900">
                                <input
                                    className='max-w-40'
                                    type="number"
                                    placeholder="Bet:"
                                    value={bet}
                                    onChange={(e) =>
                                        setData('bet', parseInt(e.target.value))
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
                    </div>

                    <div
                        className="m-3 flex flex-col items-center space-y-1"
                        hidden={!user.curr_bet}
                    >
                        <div>
                            placed: <strong>{user.curr_bet}</strong> on:{' '}
                            <strong>{user.action_table}</strong>
                        </div>
                        <div className="font-bold">Wait until throw</div>
                    </div>
                </div>
            </div>

            <div className="absolute self-end justify-self-end">
                <LeaveBTN />
            </div>
        </div>
    );
}
export default Baccarat;
