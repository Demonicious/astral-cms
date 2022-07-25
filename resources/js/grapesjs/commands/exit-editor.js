export default {
    id: 'exit-editor',
    run() {
        if (confirm('Are you sure you want to exit? Unsaved changes might be lost.'))
            window.location.replace(`${window.astralAdminUrl}/pages`);
    }
}