import grapesjs from "grapesjs";

import pluginExport from 'grapesjs-plugin-export';
import parserPostCSS from 'grapesjs-parser-postcss';
import componentCodeEditor from 'grapesjs-component-code-editor';

import pluginBasicBlocks from 'grapesjs-blocks-basic';
import pluginBlockFlexbox from 'grapesjs-blocks-flexbox';
import pluginLorySlider from 'grapesjs-lory-slider';
import customCode from 'grapesjs-custom-code';

import pluginNavbar from 'grapesjs-navbar';
import styleGradient from 'grapesjs-style-gradient';
import styleFilter from 'grapesjs-style-filter';
import styleBg from 'grapesjs-style-bg';
import pluginTabs from 'grapesjs-tabs';
import pluginTooltip from 'grapesjs-tooltip';

import exitEditor from "./commands/exit-editor";
import previewLive from "./commands/preview-live";
import savePage from "./commands/save-page";

window.fullScreenLoader = document.querySelector('.full-screen-loader');

const editor = grapesjs.init({
    container: '#astral-cms-content',

    storageManager: {
        type: 'local',
        stepsBeforeSave: 3,

        options: {
            local: {
                key: 'page-' + window.astralPageId
            }
        }
    },

    canvas: {
        scripts: [
            'https://unpkg.com/tailwindcss-jit-cdn'
        ]
    },

    assetManager: {
        assets: window.assets ? JSON.parse(window.assets) : [],

        upload: window.astralUploadUrl,
        uploadName: 'files',

        headers: {
            'X-CSRF-TOKEN': window.csrf
        }
    },

    jsInHtml: false,
    commands: {
        defaults: [
            savePage,
            previewLive,
            exitEditor
        ]
    },

    components: [
        componentCodeEditor
    ],

    plugins: [
        parserPostCSS,
        pluginExport,
        pluginBasicBlocks,
        pluginNavbar,
        styleGradient,
        styleFilter,
        styleBg,
        pluginBlockFlexbox,
        pluginLorySlider,
        customCode,
        pluginTabs,
        pluginTooltip
    ],

    height: '100vh',
});

if (window.astralPageData) {
    editor.loadProjectData(JSON.parse(window.astralPageData));
}

export default editor;