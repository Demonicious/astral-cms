import editor from "./initializer";

const panels = editor.Panels;

const panelView = panels.addPanel({
    id: 'options'
})

panelView.get('buttons').add([{
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