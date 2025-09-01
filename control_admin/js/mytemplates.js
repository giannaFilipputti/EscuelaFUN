CKEDITOR.addTemplates( 'default',
{
	// The name of the subfolder that contains the preview images of the templates.
	imagesPath : CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),
 
	// Template definitions.
	templates :
		[
			{
				title: '3 Columnas',
				image: 'col3.gif',
				description: 'Description of My Template 1.',
				html:
					'<div class="super_box"><div class="elbox_1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor scelerisque enim, non varius augue tristique nec. Mauris laoreet consectetur ultrices. Aliquam consequat facilisis orci, ac vulputate turpis semper at. Etiam tincidunt pulvinar eleifend. Maecenas elementum sollicitudin dolor, eget dignissim metus sollicitudin at. Etiam interdum, leo quis cursus cursus, justo sapien luctus nisl, a porta dui urna vitae turpis. Cras lobortis lobortis arcu, sed cursus leo eleifend quis. Maecenas at metus vel libero ultricies commodo. Cras eget egestas turpis. Fusce non eros mauris, sed molestie orci.</div>' +
					'<div class="elbox_2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor scelerisque enim, non varius augue tristique nec. Mauris laoreet consectetur ultrices. Aliquam consequat facilisis orci, ac vulputate turpis semper at. Etiam tincidunt pulvinar eleifend. Maecenas elementum sollicitudin dolor, eget dignissim metus sollicitudin at. Etiam interdum, leo quis cursus cursus, justo sapien luctus nisl, a porta dui urna vitae turpis. Cras lobortis lobortis arcu, sed cursus leo eleifend quis. Maecenas at metus vel libero ultricies commodo. Cras eget egestas turpis. Fusce non eros mauris, sed molestie orci.</div>' +
					'<div class="elbox_3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor scelerisque enim, non varius augue tristique nec. Mauris laoreet consectetur ultrices. Aliquam consequat facilisis orci, ac vulputate turpis semper at. Etiam tincidunt pulvinar eleifend. Maecenas elementum sollicitudin dolor, eget dignissim metus sollicitudin at. Etiam interdum, leo quis cursus cursus, justo sapien luctus nisl, a porta dui urna vitae turpis. Cras lobortis lobortis arcu, sed cursus leo eleifend quis. Maecenas at metus vel libero ultricies commodo. Cras eget egestas turpis. Fusce non eros mauris, sed molestie orci.</div></div>'
					
			},
			{
				title: '1 Columna',
				image: 'col1.gif',
				html:
					'<div class="super_box"><div class="elbox_uni">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor scelerisque enim, non varius augue tristique nec. Mauris laoreet consectetur ultrices. Aliquam consequat facilisis orci, ac vulputate turpis semper at. Etiam tincidunt pulvinar eleifend. Maecenas elementum sollicitudin dolor, eget dignissim metus sollicitudin at. Etiam interdum, leo quis cursus cursus, justo sapien luctus nisl, a porta dui urna vitae turpis. Cras lobortis lobortis arcu, sed cursus leo eleifend quis. Maecenas at metus vel libero ultricies commodo. Cras eget egestas turpis. Fusce non eros mauris, sed molestie orci.</div></div>'
			},
			{
				title: 'Titulo - Texto',
				image: 'col_tit_text.gif',
				html:
					'<div class="super_box"><div class="elbox_uni2"><h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor scelerisque enim, non varius augue tristique nec.</h3> <p>Mauris laoreet consectetur ultrices. Aliquam consequat facilisis orci, ac vulputate turpis semper at. Etiam tincidunt pulvinar eleifend. Maecenas elementum sollicitudin dolor, eget dignissim metus sollicitudin at. Etiam interdum, leo quis cursus cursus, justo sapien luctus nisl, a porta dui urna vitae turpis. Cras lobortis lobortis arcu, sed cursus leo eleifend quis. Maecenas at metus vel libero ultricies commodo. Cras eget egestas turpis. Fusce non eros mauris, sed molestie orci.</p></div></div>'
			}
		]
});