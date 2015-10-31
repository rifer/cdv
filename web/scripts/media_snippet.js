'use strict';
// Insert media snippet inside textarea

$('.add-media').on('click', function(){
	var mediaInsert = $(this).data('add');
	tinyMCE.execCommand('mceInsertContent', false, '[['+mediaInsert+']]');
});
