import { useForm } from '@inertiajs/react';
import { useEcho } from '@laravel/echo-react';
import React, { useState } from 'react';
// import squashed_face from '../../../../images/coin_Face-squashed.png';
import coin_face from '../../../../images/coin_Face.png'
// import squashed_number from '../../../../images/coin_Number-squashed.png'
import coin_number from '../../../../images/coin_Number.png'


function LeaveBTN(){

    const { processing, post, errors } = useForm()
    const leave = (e: React.FormEvent) => {
        e.preventDefault()
        post('/games/leave')

        if (errors) {
            console.log(errors)
        }
    }

    return (
        <form className="m-6" onSubmit={leave}>
                <button disabled={processing} type="submit" className="flex w-full justify-center rounded-md bg-red-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-red-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    Leave
                </button>
        </form>
    )
}
function Coin({ list_players, user_id, start_face }: any) {
    const [user, setUser] = useState(
        list_players.filter((player: { id: number }) => player.id == user_id)[0]
    )

    const [players, setPlayers] = useState(
        list_players.filter((player: { id: number }) => player.id !== user_id)
    );


    switch (start_face){
        case 'face':
            start_face = coin_face
            break

        case 'num':
            start_face = coin_number
            break
    }

    const [img, setImg] = useState(start_face)


    const { data: { bet }, setData, processing, post, errors } = useForm({
        bet: 0,
    });



    const betNumber = (e: any) => {
        e.preventDefault();
        setUser({
            ...user,
            curr_bet: bet,
            points_curr_table: user.points_curr_table - bet
        })
        post('/games/coin/num');
        setData('bet', 0)
    };

    const betFace = (e: any) => {
        e.preventDefault();
        setUser({
            ...user,
            curr_bet: bet,
            points_curr_table: user.points_curr_table - bet
        })
        post('/games/coin/face');
        setData('bet', 0);
    };



    useEcho('coin', '.player-list-changed', (e) => {
        setUser(
           e.playerList.filter(
                (player: { id: number }) => player.id == user_id,
            )[0],
        );
        setPlayers(
            e.playerList.filter((player: { id: number }) => player.id !== user_id),
        );
    });

    useEcho('coin', '.coin-flipped', (e) => {

        if (e.face == 'face') {
            setImg(coin_face)
        }

        if (e.face == 'num') {
            setImg(coin_number);
        }



    })



    return (
        <div className="grid h-screen w-screen text-white/60">
            <div className="absolute self-center justify-self-center">
                <img src={img} alt="" className="max-h-120" />
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

                        <div className="grid min-h-20 min-w-20 rounded-xl border border-black bg-indigo-400/50 font-bold text-black hover:bg-indigo-500/50">
                            <div className="mx-auto self-center">
                                <button onClick={betFace} disabled={processing}>
                                    Face
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        className="m-3 flex flex-col items-center space-y-1"
                        hidden={!user.curr_bet}
                    >
                        <div>
                            placed: <strong>{user.curr_bet}</strong> on: <strong>{user.action_table}</strong>
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
export default Coin
