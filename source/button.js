(function(){   
    tinymce.create('tinymce.plugins.wprButton', {
    
        init : function(ed, url){
            ed.addCommand('wpr', function(){
                var title = prompt("Please insert the Title:");
                var url = prompt("Please insert the URI:", "http://");
                var result = "[ref" + (title.length === 0 ? "" : " title=\"" + title + "\"") + "]" + url + "[/ref]";
                tinyMCE.activeEditor.setContent(tinyMCE.activeEditor.getContent({format : 'raw'}) + result, {format : 'raw'});
            });
            ed.addButton('wprb', {
                text: 'WP References',
                title: 'WP References',
                image: url + '/references.png',
                cmd: 'wpr'
            });
			
        },
        createControl : function(n, cm){
            return null;
        },
        getInfo : function(){
            return {
                longname: 'WP References Button',
                author: 'Oliver Haucke',
                authorurl: 'http://gadean.de/',
                infourl: 'http://gadean.de/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('wprButton', tinymce.plugins.wprButton);
})();