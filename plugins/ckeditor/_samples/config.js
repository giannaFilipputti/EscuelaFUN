/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'Admin';


        config.toolbar_Admin = [

        ['Bold','Italic','Strike'],['SelectAll','RemoveFormat'],['Link','Unlink','Anchor'],['NumberedList','BulletedList'],['Image'],['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker'],['Maximize','ShowBlocks'],
        '/',

   ['Source'],['Format'],['TextColor','BGColor']['Smiley','SpecialChar'],['Undo','Redo','-','Find','Replace'] // No comma for the last row.
        ] ;
};
