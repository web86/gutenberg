import { useBlockProps } from '@wordpress/block-editor';

export default function save() {
    return (
        <div { ...useBlockProps.save() }>
            <strong>Web86 File Map</strong>
            <p>block.json → index.js → edit.js / save.js</p>
        </div>
    );
}
