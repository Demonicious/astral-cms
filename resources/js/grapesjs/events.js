import editor from './initializer';

editor.on('asset:upload:start', () => {
    window.fullScreenLoader.classList.add('show');
});

// The upload is ended (completed or not)
editor.on('asset:upload:end', () => {
    window.fullScreenLoader.classList.remove('show');
});

// Error handling
editor.on('asset:upload:error', (err) => {
    console.error(err);
    alert('There was an error uploading the media.');
    window.fullScreenLoader.classList.end('show');
});