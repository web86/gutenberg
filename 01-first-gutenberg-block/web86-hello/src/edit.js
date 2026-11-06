import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';

export default function Edit() {
    return (
        <p {...useBlockProps()}>
            Привет! Это мой первый блок Gutenberg.
        </p>
    );
}
