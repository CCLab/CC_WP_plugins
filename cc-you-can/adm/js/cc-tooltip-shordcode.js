(function() {
   tinymce.create('tinymce.plugins.cc_you_can_tooltip', {
      init : function(ed, url) {
         ed.addButton('cc_you_can_tooltip', {
            title : 'Dodaj tooltip',
            image : url+'/tooltip.png',
            onclick : function() {
               if(ed.selection.getContent() != "") {
                  var tooltip_text = prompt("Tekst podpowiedzi", "");
                  if(tooltip_text != "" && tooltip_text != null)
                     ed.execCommand('mceInsertContent', false, '[cc-tooltip tooltip_text="'+tooltip_text+'"]'+ed.selection.getContent()+'[/cc-tooltip]');
                  else 
                     ed.execCommand('mceInsertContent', false, '[cc-tooltip tooltip_text="'+"Wpisz tutaj treść podpowiedzi"+'"]'+ed.selection.getContent()+'[/cc-tooltip]');
               }
               else {
                  var text = prompt("Tekst wyświetlany", "");
                  if(text != "" && text != null) {
                     var tooltip_text = prompt("Tekst podpowiedzi", "");
                     if(tooltip_text != "" && tooltip_text != null)
                        ed.execCommand('mceInsertContent', false, '[cc-tooltip tooltip_text="'+tooltip_text+'"]'+text+'[/cc-tooltip]');
                     else 
                        ed.execCommand('mceInsertContent', false, '[cc-tooltip tooltip_text="'+"Wpisz tutaj treść podpowiedzi"+'"]'+text+'[/cc-tooltip]');
                  }
               }
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Recent Posts",
            author : 'Konstantinos Kouratoras',
            authorurl : 'http://www.kouratoras.gr',
            infourl : 'http://wp.smashingmagazine.com',
            version : "1.0"
         };
      }
   });
   tinymce.PluginManager.add('cc_you_can_tooltip', tinymce.plugins.cc_you_can_tooltip);
})();