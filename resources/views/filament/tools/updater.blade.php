@if(file_exists( base_path( 'upload.zip' ) ))
<div class="flex items-start px-3 py-2 space-x-2 backdrop-blur-xl backdrop-saturate-150 rtl:space-x-reverse text-sm text-green-600 shadow ring-1 rounded bg-green-50/50 ring-green-400">Ready to Update! Press the Button down below to update.</div>
@else
    <div class="flex items-start px-3 py-2 space-x-2 backdrop-blur-xl backdrop-saturate-150 rtl:space-x-reverse text-sm text-danger-400 shadow ring-1 rounded bg-danger-50/50 ring-danger-200">Put the upload.zip file in the root of your website to update your script.</div>
@endif

