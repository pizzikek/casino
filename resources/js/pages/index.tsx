import { Head } from '@inertiajs/react';
import Layout from '@/components/layout';


function Index(user: any) {
    return (
        <>
            <Head title="Home" />
            <Layout userProp={user.user} header="User Information">
                <div className="text-white/60">
                    <br />
                    <div>
                        <div className="text-2xl">{user.user.points}</div>
                        <div className="text-xl font-bold">points </div>
                    </div>
                    <br />
                    <div>
                        <div className="font-bold">User Name: </div>
                        {user.user.username}
                    </div>
                    <br />
                    <div>
                        <div className="font-bold">Email: </div>
                        {user.user.email}
                    </div>
                </div>
            </Layout>
        </>
    );
}
export default Index
