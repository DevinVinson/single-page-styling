(function( $ ) {
	'use strict';


	 $(function() {
        
        //Make sure the editor exists before attaching ace to it
        if ( document.getElementById('js__sps-ace-editor') ){

         var editor = ace.edit('js__sps-ace-editor');
         editor.setTheme('ace/theme/chrome');
         editor.getSession().setMode('ace/mode/css');
         editor.setOption( 'showPrintMargin', false);
         editor.getSession().setValue( $( '#css_metabox_field' ).val() );

         var input = $('#css_metabox_field');
         editor.getSession().on("change", function () {
             input.val(editor.getSession().getValue());
         });

        }

	 });


})( jQuery );
