import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit() {
    return (
        <div { ...useBlockProps() }>
            <strong>Web86 File Map</strong>
            <p>block.json → index.js → edit.js / save.js</p>
        </div>
    );
}
