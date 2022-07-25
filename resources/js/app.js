import Alpine from "alpinejs";
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

window.Alpine = Alpine;

window.Alpine.start();

const loader = document.querySelector('.full-screen-loader');
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
            {
                id: 'save-page',
                async run(editor) {
                    loader.classList.add('show');

                    try {
                        fetch(`${window.astralStoreUrl}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': window.csrf,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({

                                html: editor.getHtml(),
                                css: editor.getCss(),
                                js: editor.getJs(),
                                data: editor.getProjectData(),
                            })
                        })
                    } catch(e) {
                        alert('There was an error saving your page.');
                    }

                    loader.classList.remove('show');
                }
            },
            {
                id: 'preview-live',
                run(editor) {
                    console.log('Previewing live...');
                }
            },
            {
                id: 'exit-editor',
                run() {
                    if(confirm('Are you sure you want to exit? Unsaved changes might be lost.'))
                        window.location.replace(`${window.astralAdminUrl}/pages`);
                }
            }
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

const panels = editor.Panels;

const panelView = panels.addPanel({
    id: 'options'
})

panelView.get('buttons').add([
    {
        attributes: {
            'class': 'fa fa-save'
        },
        label: '',
        command: 'save-page',
        id: 'save-page'
    },

    {
        attributes: {
            'class': 'fa fa-external-link'
        },
        label: '',
        command: 'preview-live',
        id: 'preview-live'
    },

    {
        attributes: {
            'class': 'fa fa-times'
        },
        label: '',
        command: 'exit-editor',
        id: 'exit-editor'
    }
])

editor.on('asset:upload:start', () => {
    loader.classList.add('show');
});
  
// The upload is ended (completed or not)
editor.on('asset:upload:end', () => {
    loader.classList.remove('show');
});
  
// Error handling
editor.on('asset:upload:error', (err) => {
    console.error(err);
    alert('There was an error uploading the media.');
    loader.classList.end('show');
});

if(window.astralPageData) {
    editor.loadProjectData(JSON.parse(window.astralPageData));
}

const bm = editor.Blocks;

bm.add('TEST-BLOCK', {
    label: 'Testing Block',
    content: '<h1>Hello Howdy?</h1.',
    category: 'Astral CMS',
    attributes: {
        title: 'Hello'
    }
})