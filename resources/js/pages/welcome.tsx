import { Head } from '@inertiajs/react';
import Layout from '../components/layout';

export default function Welcome() {
    return (
        <>
            <Head title="Title" />
            <Layout>
                <h1>Welcome</h1>
            </Layout>
        </>
    );
}
