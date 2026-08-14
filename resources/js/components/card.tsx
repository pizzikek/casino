
const cards = import.meta.glob('../../images/cards/*.png', { eager: true, as: 'url' });

export default function Card( {code}: any ) {

    const imagePath = `../../images/cards/${code}.png`;
    const src = cards[imagePath];

    return <img src={src} alt={`${code}`} width="100" height="140" />;
}