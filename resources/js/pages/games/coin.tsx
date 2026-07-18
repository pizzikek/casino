import { Head, useForm } from '@inertiajs/react';
import Button from '@/components/forms/button';
import InputLabel from '@/components/forms/input-label';
import Layout from '@/components/layout';

function Coin(user:any) {

    const { data, setData, post, processing, errors } = useForm({
        points: ''
    });
    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/coin');
    };

    return (
        <>
            <Head title="Home" />
            <Layout userProp={user.user} header="enter a Coin Flip table">
                <div className="text-white/60">
                    <form onSubmit={handleSubmit}>
                        <InputLabel
                            label="Points to take into Table"
                            name="points"
                            type="number"
                            id="points"
                            value={data.points}
                            onChange={(e) => setData('points', e.target.value)}
                        />
                        <div className="text-red-600">
                            {errors.points && (
                                <div className="error">{errors.points}</div>
                            )}
                        </div>

                        <div className="text-white/80 mt-6">
                            <span className="text-red-600/80">DO NOT</span> leave the table by closing the tab,<br/>
                            <span className="text-red-600/80">ALWAYS</span> use the leave button <br/>
                            <span className="text-red-600/80">ELSE you loose the taken in points</span>
                        </div>


                        <div className="mt-12">
                            <Button label="Enter Table" disabled={processing} />
                        </div>
                    </form>
                </div>
            </Layout>
        </>
    );
}
export default Coin;
