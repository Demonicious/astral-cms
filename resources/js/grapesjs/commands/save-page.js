import { minify } from "csso";

export default {
    id: 'save-page',
    async run(editor) {
        window.fullScreenLoader.classList.add('show');

        try {
            const combined = minify(editor.Canvas.getDocument().querySelector('style').textContent + ' ' + editor.getCss()).css;

            fetch(`${window.astralStoreUrl}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': window.csrf,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({

                    html: editor.getHtml(),
                    css: combined,
                    js: editor.getJs(),
                    data: editor.getProjectData(),
                })
            })
        } catch (e) {
            alert('There was an error saving your page.');
        }

        window.fullScreenLoader.classList.remove('show');
    }
}