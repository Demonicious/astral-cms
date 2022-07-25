import editor from './initializer';

const cm = editor.Components;
const bm = editor.Blocks;

if (window.extensionBlocks)
    window.extensionBlocks.forEach(([id, data]) => bm.add(id, data))