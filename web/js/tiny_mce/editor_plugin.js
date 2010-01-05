/**
 * TinyMCE Plugin for opRichTextareaSyntaxHighlightPlugin
 *
 * @author Rimpei Ogawa <ogawa@tejimaya.com>
 */

(function() {
    var config = op_mce_editor_get_config();

    tinymce.create('tinymce.plugins.opSyntaxHighlight', {
        init : function(ed, url) {
            ed.addButton('op_source', {
                title: config['op_source'].caption,
                cmd: 'op_source',
                image: config['op_source'].imageURL
            });

            ed.addCommand('op_source', function(u, v) {
                var s = ed.selection, DOM = tinymce.DOM;

                var head = DOM.encode('<op:source lang="">');
                var tail = DOM.encode('</op:source>');
                var br = '<br />';

                tinyMCE.execCommand("mceInsertContent", false, head+br+s.getContent()+br+tail);
            });
        }
    });

    tinymce.PluginManager.add('opSyntaxHighlight', tinymce.plugins.opSyntaxHighlight);
})();
