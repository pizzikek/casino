
const cards = import.meta.glob('../../images/cards/*.png', { eager: true, as: 'url' });

export default function Card( {code}: any ) {

    const imagePath = `../../images/cards/${code}.png`;
    const src = cards[imagePath];

    return (
        <div className="max-w-50">
            <img src={src} alt={`${code}`} className="w-full" />
        </div>);
}